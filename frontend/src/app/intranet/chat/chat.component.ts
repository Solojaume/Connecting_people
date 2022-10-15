import {
  Component,
  EventEmitter,
  OnInit,
  Output,
  ViewChild,
} from '@angular/core';

import { FormControl, FormGroup, Validators } from '@angular/forms';
import { CookieService } from 'ngx-cookie-service';

import { TokenStorageService } from 'src/app/core/shared/services/token-storage/token-storage.service';
import { WebSocketIOService } from 'src/app/core/shared/services/activate-recovery/web-socket/socket IO/web-socket-io.service';
import { MensajeModel } from 'src/app/core/models/mensaje.model';
import { IImagenesComponentConfig } from 'src/app/core/models/Interfaces/IImagenesComponentConfig';
import { CdkScrollable, CdkVirtualScrollViewport } from '@angular/cdk/scrolling';

@Component({
  selector: 'app-chat',
  templateUrl: './chat.component.html',
  styleUrls: ['./chat.component.scss'],
})
export class ChatComponent implements OnInit {
  formularioEnvio = new FormGroup({
    message: new FormControl(''),
  });
  @ViewChild(CdkVirtualScrollViewport) cdkScrollable!: CdkVirtualScrollViewport;


  config: IImagenesComponentConfig = {
    type: 'rounded',
  };
  typingSended: any = false;
  constructor(
    private token: TokenStorageService,
    private cookies: CookieService,
    public socketService: WebSocketIOService
  ) {}

  ngOnInit(): void {
    this.socketService.chatUsar = {
      match_id_usu2: this.token.getUser(),
      mensajes: [],
    };
    
    this.formularioEnvio.valueChanges.subscribe((x) => {
      console.log('x:', x.message);
      this.setTyping('' + x.message);
    });
    this.cdkScrollable.scrollTo({ bottom: 100 });
  }

  scrollEnd(){
    this.cdkScrollable.scrollTo({
      bottom: 0,
    });
  }

  sendMessage() {
    //console.log("Chat Usar:",this.chatUsar)
    const chatMessageDto = new MensajeModel(
      this.token.getUser().id,
      this.formularioEnvio.value.message,
      -1,
      this.socketService.mensajes_count,
      this.socketService.chatUsar.match_id,
      'mensaje',
      new Date().toDateString()
    );
    let chatUsar = this.socketService.chatUsar;
    this.socketService.mensajes[chatUsar.match_position].push(chatMessageDto);
    let match_id_usu2 = chatUsar.match_id_usu2;

    this.socketService.emit('send private message', {
      token: this.token.getUser().token,
      mensage: chatMessageDto,
      usu_2: match_id_usu2.id,
    });
    //Esto sirve para que si un usuario envia un mensage a un macth le aparezca como chat
    this.socketService.modify_conection_status()
    this.formularioEnvio.value.message = '';
    this.formularioEnvio.reset();
    this.setTyping('');
    this.cdkScrollable.scrollTo({
      bottom: 0,
    });
  
  }

  cargarChat(chat: any) {
    console.log('Se ha cambiado el chat a:', chat);
    this.socketService.chatUsar = chat;
    this.socketService.matches[chat.match_position].match_count_no_leidos = 0;
    console.log('Mensajes:', this.socketService.mensajes[chat.match_position]);
  }

  setTyping(message: string) {
    let chatUsar = this.socketService.chatUsar;
    if (message != '') {
      if (this.typingSended == false) {
        this.socketService.emitEvent('typing', {
          match_id: chatUsar.match_id,
          id_usu_send: this.token.getUser().id,
          token_usu: this.token.getToken(),
          id_usu2: chatUsar.match_id_usu2.id,
        });
      }

      this.typingSended = true;
    } else {
      this.socketService.emitEvent('stop typing', {
        match_id: chatUsar.match_id,
        id_usu_send: this.token.getUser().id,
        token_usu: this.token.getToken(),
        id_usu2: chatUsar.match_id_usu2.id,
      });
      this.typingSended = false;
    }
  }
}
