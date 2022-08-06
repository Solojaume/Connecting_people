import { Component, EventEmitter, OnInit, Output } from '@angular/core';
import { NgForm } from '@angular/forms';
import {FormControl, FormGroup, Validators, } from '@angular/forms';
import { CookieService } from 'ngx-cookie-service';
import { ChatMessageDto } from 'src/app/core/models/chat/chatMessageDto';
import { Comunicacion } from 'src/app/core/models/chat/comunicacion';
import { TokenStorageService } from 'src/app/core/shared/services/token-storage/token-storage.service';
import { WebSocketService } from 'src/app/core/shared/services/activate-recovery/web-socket/web-socket.service';
import { WebSocketIOService } from 'src/app/core/shared/services/activate-recovery/web-socket/socket IO/web-socket-io.service';

@Component({
  selector: 'app-chat',
  templateUrl: './chat.component.html',
  styleUrls: ['./chat.component.scss']
})
export class ChatComponent implements OnInit {
  formularioEnvio = new FormGroup({
    user: new FormControl(''),
    message: new FormControl('')
  });
 //@Output() mensaje: EventEmitter<WebSocketService>;
  //webSocketService!:WebSocketService;
  
  chatUsar:any;
  constructor(
   // public webSocketStorageService:WebSocketStorageService,
    private token:TokenStorageService,
    private cookies:CookieService,
    public webSocketService:WebSocketService,
    public socketService:WebSocketIOService
  ) { }

  ngOnInit(): void {
    this.webSocketService.openWebSocket();
    this.webSocketService.chatUsar = {match_id_usu2:this.token.getUser()}
   
  }

  ngOnDestroy(){
    if(this.webSocketService.getAutenticado()=="true"){
      this.webSocketService.CambiarPagina();  
    }
   
  }

  sendMessage() {
    //console.log("Chat Usar:",this.chatUsar)
    
    const chatMessageDto = new ChatMessageDto(
      this.token.getUser().token, 
      this.formularioEnvio.value.message, 
      "mensaje",
      this.webSocketService.chatUsar.match_id
    );
    const comunicaciones = new Comunicacion("send",chatMessageDto);
    this.webSocketService.sendMessage(comunicaciones);
    this.formularioEnvio.value.message = "";
    this.formularioEnvio.reset();
  }
  cargarChat(chat:any){
    console.log('Se ha cambiado el chat a:',chat); 
    this.webSocketService.chatUsar=chat;
    if(!chat.hasOwnProperty("mensajes")){
      this.webSocketService.chatUsar.mensajes=[];
    }
    this.webSocketService.chatMessages=this.webSocketService.chatUsar.mensajes;
   
  }
}

