import { Component, EventEmitter, OnInit, Output } from '@angular/core';
import { NgForm } from '@angular/forms';
import {FormControl, FormGroup, Validators, } from '@angular/forms';
import { CookieService } from 'ngx-cookie-service';
import { ChatMessageDto } from 'src/app/core/models/chat/chatMessageDto';
import { Comunicacion } from 'src/app/core/models/chat/comunicacion';
import { TokenStorageService } from 'src/app/core/shared/services/token-storage/token-storage.service';
import { WebSocketIOService } from 'src/app/core/shared/services/activate-recovery/web-socket/socket IO/web-socket-io.service';
import { Match } from 'src/app/core/models/chat/Match';
import { fromEvent } from 'rxjs';
import { MensajeModel } from 'src/app/core/models/mensaje.model';


@Component({
  selector: 'app-chat',
  templateUrl: './chat.component.html',
  styleUrls: ['./chat.component.scss']
})
export class ChatComponent implements OnInit {
  formularioEnvio = new FormGroup({
    message: new FormControl('')
  });
  
  //@Output() mensaje: EventEmitter<WebSocketService>;
  //webSocketService!:WebSocketService;
  
  typingSended:any=false;
  constructor(
   // public webSocketStorageService:WebSocketStorageService,
    private token:TokenStorageService,
    private cookies:CookieService,
    public socketService:WebSocketIOService
  ) { }

  ngOnInit(): void {
    this.socketService.chatUsar = {match_id_usu2:this.token.getUser(),mensajes:[]};
    this.formularioEnvio.valueChanges.subscribe(x => {
      console.log("x:",x.message);
      this.setTyping(""+x.message);
    })
   
  }

  ngOnDestroy(){
    
   
  }
  


  sendMessage() {
    //console.log("Chat Usar:",this.chatUsar)
    const chatMessageDto = new MensajeModel(
      this.token.getUser().id, 
      this.formularioEnvio.value.message,
      -1 ,
      this.socketService.mensajes_count,
      this.socketService.chatUsar.match_id,
      "mensaje",
      new Date().toDateString()
    );
    let chatUsar = this.socketService.chatUsar;
    this.socketService.mensajes[chatUsar.match_position].push(chatMessageDto);
    let match_id_usu2 = chatUsar.match_id_usu2;
    
    this.socketService.emit("send private message",
    {
      token:this.token.getUser().token,
      mensage:chatMessageDto,
      usu_2:match_id_usu2.id
    });
    //this.webSocketService.sendMessage(comunicaciones);
    this.formularioEnvio.value.message = "";
    this.formularioEnvio.reset();
    this.setTyping("");
  }

  cargarChat(chat:any){
    console.log('Se ha cambiado el chat a:',chat); 
    this.socketService.chatUsar = chat;
    console.log("Mensajes:",this.socketService.mensajes[chat.match_position]);
   
  }

  setTyping(message:string){ 
    let chatUsar=this.socketService.chatUsar;
    if(message!=""){
      if (this.typingSended==false) {
        this.socketService.emitEvent("typing",
        {
          "match_id":chatUsar.match_id,
          "id_usu_send":this.token.getUser().id,
          "token_usu":this.token.getToken(),
          "id_usu2":chatUsar.match_id_usu2.id
        }
      );
      }
      
      this.typingSended=true;
    }else{
      this.socketService.emitEvent("stop typing",
        {
          "match_id":chatUsar.match_id,
          "id_usu_send":this.token.getUser().id,
          "token_usu":this.token.getToken(),
          "id_usu2":chatUsar.match_id_usu2.id
        }
      );
      this.typingSended=false;
    }
    
  }
}

