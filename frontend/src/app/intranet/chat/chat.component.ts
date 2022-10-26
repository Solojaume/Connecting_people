import {
  Component,
  OnInit,
  OnDestroy,
  ViewChild,
  LOCALE_ID,
  Inject,
} from '@angular/core';

import { FormControl, FormGroup } from '@angular/forms';
import { CookieService } from 'ngx-cookie-service';
import { TokenStorageService } from 'src/app/core/shared/services/token-storage/token-storage.service';
import { WebSocketIOService } from 'src/app/core/shared/services/activate-recovery/web-socket/socket IO/web-socket-io.service';
import { MensajeModel } from 'src/app/core/models/mensaje.model';
import { IImagenesComponentConfig } from 'src/app/core/models/Interfaces/IImagenesComponentConfig';
import {
  CdkScrollable,
  CdkVirtualScrollViewport,
} from '@angular/cdk/scrolling';
import { formatDate } from '@angular/common';
import { NgbModal } from '@ng-bootstrap/ng-bootstrap';
import { ModalAutofocusComponent } from 'src/app/core/shared/components/modals/modal-autofocus/modal-autofocus.component';

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
    public socketService: WebSocketIOService,
    @Inject(LOCALE_ID) public locale: string,
    private _modalService: NgbModal
  ) {}
  public typeofUsuario2!: boolean;
  public claseQueUsaImput: string = 'form-control';
  public mensajeVacio: boolean = false;

  ngOnInit(): void {
    this.socketService.setPage('chat');
    this.typeofUsuario2 =
      typeof this.socketService.chatUsar.match_id_usu2 !== 'undefined';
    this.formularioEnvio.valueChanges.subscribe((x) => {
      // console.log('x:', x.message);
      let y = '' + x.message;

      if (y.length <= 1000 && y.length > 0) {
        this.claseQueUsaImput = 'form-control';
        this.setTyping('' + x.message);
      } else {
        this.claseQueUsaImput = 'form-control form-control-error';
      }
    });
    this.cdkScrollable.scrollTo({ bottom: 100 });
  }

  scrollEnd() {
    this.cdkScrollable.scrollTo({
      bottom: 0,
    });
  }

  sendMessage() {
    let chatMessageDto = new MensajeModel(
      this.token.getUser().id,
      this.formularioEnvio.value.message,
      -1,
      this.socketService.mensajes_count,
      this.socketService.chatUsar.match_id,
      'mensaje',
      formatDate(new Date(), 'yyyy-mm-dd HH:mm:ss', this.locale)
    );
    let chatUsar = this.socketService.chatUsar;
    let match_id_usu2 = chatUsar.match_id_usu2;
    if (
      this.formularioEnvio.value.message.length === 0 ||
      this.formularioEnvio.value.message == null
    ) {
      this.mensajeVacio = true;
    } else {
      this.mensajeVacio = false;
      this.socketService.mensajes[chatUsar.match_position].push(chatMessageDto);

      this.socketService.emit('send private message', {
        token: this.token.getUser().token,
        mensage: chatMessageDto,
        usu_2: match_id_usu2.id,
      });
    }

    //Esto sirve para que si un usuario envia un mensage a un macth le aparezca como chat
    this.socketService.modify_conection_status();
    this.formularioEnvio.reset();
    this.formularioEnvio.value.message = '';
    this.setTyping('');
    this.cdkScrollable.scrollTo({
      bottom: 0,
    });
  }

  cargarChat(chat: any) {
    console.log('Se ha cambiado el chat a:', chat);
    this.typeofUsuario2 =
      typeof this.socketService.chatUsar.match_id_usu2 !== 'undefined';

    if (chat != 'blanco') {
      this.socketService.chatUsar = chat;
      this.socketService.matches[chat.match_position].match_count_no_leidos = 0;
      console.log(
        'Mensajes:',
        this.socketService.mensajes[chat.match_position]
      );
    }
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

  open(nombre:string="una putita") {
    let modal = this._modalService.open(ModalAutofocusComponent);
    modal.componentInstance.tittle = 'Deshacer match';
    modal.componentInstance.strong1 = "¿Estas seguro de que quieres deshacer tu match con";
    modal.componentInstance.spanStrong = '"'+nombre+'"';
    modal.componentInstance.textoNormal = "Al deshacer el match te desaparecera la combersación. \n";
    modal.componentInstance.strong2 = "?";
    console.log('let Modal', modal);
    modal.closed.subscribe((closed)=>{
      console.log('CLOSED modal:', closed);
    });
    modal.dismissed.subscribe((dismis)=>{
      console.log('Dismis modal:', dismis);
    });

  }
}
