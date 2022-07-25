import { Component, EventEmitter, OnInit, Output } from '@angular/core';
import { NgForm } from '@angular/forms';
import {FormControl, FormGroup, Validators, } from '@angular/forms';
import { CookieService } from 'ngx-cookie-service';
import { ChatMessageDto } from 'src/app/core/models/chat/chatMessageDto';
import { Comunicacion } from 'src/app/core/models/chat/comunicacion';
import { TokenStorageService } from 'src/app/core/shared/services/token-storage.service';
import { WebSocketService } from 'src/app/core/shared/services/web-socket.service';

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
    public webSocketService:WebSocketService
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
  findIndexChat(){
    for (let index = 0; index < this.webSocketService.chatRooms.length; index++) {
      let chatUsar=this.webSocketService.chatUsar;
      let chatRec=this.webSocketService.chatRooms[index];
      if (chatUsar.match_id==chatRec.match_id) {
        return {"type":"chat","in":index};
      }
      
    }

    for (let index = 0; index < this.webSocketService.matches.length; index++) {
      let chatUsar=this.webSocketService.chatUsar;
      let chatRec=this.webSocketService.matches[index];
      if (chatUsar.match_id==chatRec.match_id) {
        return {"type":"match","in":index};
      }
      
    }
    return {"type":"n","in":0}
  }

  sendMessage() {
    
    const chatMessageDto = new ChatMessageDto(
      this.token.getUser().id, 
      this.formularioEnvio.value.message, 
      "mensaje",
      this.webSocketService.chatUsar.match_id
    );
    console.log("Mensaje nuevo:",chatMessageDto);

    this.webSocketService.chatMessages.push(chatMessageDto);
    var re=this.findIndexChat();
    switch (re.type) {
      case "chat":
        this.webSocketService.chatRooms[re.in].mensajes?.push(chatMessageDto);
        this.webSocketService.chatUsar.mensajes?.push(chatMessageDto);

        break;
      case "match":
        let m=this.webSocketService.matches[re.in];
        this.webSocketService.añadirMensajeAMatch(chatMessageDto);
        this.webSocketService.chatUsar.mensajes?.push(chatMessageDto);

        break;
      default:
        break;
    }
    //const comunicaciones = new Comunicacion("send",chatMessageDto);
    //this.webSocketService.sendMessage(comunicaciones);
    this.webSocketService.mensajes_sin_enviar.push(chatMessageDto);
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
    
    if(this.webSocketService.findChat()==false){
      this.webSocketService.setChat(chat);
    }
  }
}

