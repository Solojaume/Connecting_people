import { Injectable } from '@angular/core';
import { Router } from '@angular/router';
import { CookieService } from 'ngx-cookie-service';
import { ChatMessageDto } from '../../models/chat/chatMessageDto';
import { ChatRoom } from '../../models/chat/chat_room';
import { Comunicacion } from '../../models/chat/comunicacion';
import { IChatModels } from '../../models/chat/Interfaces/IChatModels';
import { Match } from '../../models/chat/Match';
import { TokenStorageService } from './token-storage.service';

const WEB_SOCKET_KEY = 'Web-socket';
const WEB_SOCKET_URL='ws://localhost:8080/demo/php-socket.php';
const AUTH_KEY = 'autenticacion';

@Injectable({
  providedIn: 'root'
})
export class WebSocketService {

  webSocket!: WebSocket;
  chatMessages: ChatMessageDto[] = [];
  chatRooms:ChatRoom[] = [];
  matches:Match[] = []
  chatUsar!:any;
  constructor(private token:TokenStorageService, private cookies:CookieService, private router:Router) {
    this.webSocket = new WebSocket(WEB_SOCKET_URL);
    this.chatUsar;
  }
  
  private newWebSocket() {
    this.webSocket = new WebSocket(WEB_SOCKET_URL);
    
  }

  private setAutenticadoTrue() {
    window.sessionStorage.removeItem(AUTH_KEY);
    window.sessionStorage.setItem(AUTH_KEY, "true");
  }

  public setAutenticadoFalse(){
    window.sessionStorage.removeItem(AUTH_KEY);
    window.sessionStorage.setItem(AUTH_KEY, "false");
  }
  
  public getAutenticado(){
    return window.sessionStorage.getItem(AUTH_KEY);
  }

  /*
  *Este metodo sirve para abrir la conexion 
  */
  public openWebSocket(){
    if(this.webSocket.readyState>=1 && this.getAutenticado()=="false"){
      this.newWebSocket();
      this.setAutenticadoFalse();
      //this.webSocket.OPEN;
    }else if(this.getAutenticado()=="true"){
      this.newWebSocket();
    }
    console.log(this.webSocket)
    this.webSocket.onopen = (event) => {
      console.log('Open: ', event);
      if(this.getAutenticado()=="false"){
        this.chatMessages = [];
        this.chatRooms = [];
        let token=this.token.getToken()??JSON.parse(this.cookies.get('usuario')).token;
        let com = new Comunicacion("auth",token)
        console.log("Pre auth");
        this.sendMessage(com);
        console.log("auth");
        this.setAutenticadoTrue();
      } else if(this.getAutenticado()=="true"){
        let token=this.token.getToken()??JSON.parse(this.cookies.get('usuario')).token;
        let com = new Comunicacion("cambiada_pagina",token)
        console.log("Pre pagina cambiada");
        this.sendMessage(com);
        console.log("Página cambiada");
      }
     
    };

    this.webSocket.onmessage = (event) => {
      const chatMessageDto = JSON.parse(event.data);
      switch (chatMessageDto.message_type) {
        case "auth_error":

          this.token.signOut();
          this.cookies.deleteAll();
          this.webSocket.close();
          this.router.navigateByUrl("/");
          this.chatMessages = [];
          this.chatRooms = [];
          console.log("Chat Messages:",this.chatMessages);
          break;
        case "auth":
          console.log(chatMessageDto);
          //this.chatRooms.push(chatMessageDto.message);
          console.log(chatMessageDto.message);
          this.setAutenticadoTrue();
          break;
        
        case "CambiadaPagina":
          console.log(chatMessageDto);
          let token=this.token.getToken()??JSON.parse(this.cookies.get('usuario')).token;
          let com = new Comunicacion("get_chats",token);
          this.sendMessage(com);  
          break;
        case "mensaje":
          console.log("Nuevo mensaje:",chatMessageDto);
          this.chatMessages;
          break;
        case "chats":
          console.log(chatMessageDto);
          this.chatRooms=chatMessageDto.chat_message.Chats;
          this.matches=chatMessageDto.chat_message.Matches;
          console.log("Chats mensaje: ",chatMessageDto.chat_message.Chats);
          console.log("Match mensaje: ",chatMessageDto.chat_message.Matches);
          console.log("Chats en variable: ",this.chatRooms);
          console.log("Match en variable: ",this.matches);
          break;

        default:
          console.log(chatMessageDto);
          this.chatMessages.push(chatMessageDto);
          console.log("Chat Messages:",this.chatMessages);
          break;
      }
     
    };

    this.webSocket.onclose = (event) => {
      console.log('Close: ', event);
      //this.setAutenticadoFalse();
    };

    this.webSocket.onerror = (error)=>{
      console.log("Error: ", error);
    };

  }

  public sendMessage(chatMessageDto: IChatModels){
    this.webSocket.send(JSON.stringify(chatMessageDto));
  }

  public closeWebSocket() {
    let token=this.token.getToken()??JSON.parse(this.cookies.get('usuario')).token;
    let com = new Comunicacion("desconectar",token);
    this.setAutenticadoFalse();
    this.sendMessage(com);
 
    try {
      console.log(this.webSocket);
      this.webSocket.close();
    } catch (error) {
      console.log(this.webSocket);
      console.log("uPS ALGO HIZO CRACKs");
      //throw error;
      
    }
   
  }

  public CambiarPagina(){
    let token=this.token.getToken()??JSON.parse(this.cookies.get('usuario')).token;
    let com = new Comunicacion("cambiar_pagina",token)
    this.sendMessage(com);
    try {
      console.log(this.webSocket);
      this.webSocket.close();
      
    } catch (error) {
      console.log(this.webSocket);
      console.log("uPS ALGO HIZO CRACKs");
      //throw error;
     
    }
   
  }


  public Resetear(){
    this.chatMessages = [];
    this.chatRooms = [];
  }

  private añadirMensajeAChat(mensaje:any){
    for (let index = 0; index < this.chatRooms.length; index++) {
      const element = this.chatRooms[index];
      if(this.chatUsar.id==this.chatRooms[index].id){
        this.chatRooms[index].mensajes?.push(mensaje);
        return element;
      }
      
    }
    return false;
  }
  private añadirMensajeAMatch(mensaje:any){
    for (let index = 0; index < this.matches.length; index++) {
      const element = this.matches[index];
      if(this.chatUsar.id==this.matches[index].id){
        this.chatUsar.mensajes.push(mensaje);
        this.chatRooms.push(this.chatUsar);
        
        this.matches.slice(index);
        return element;
      }
      
    }
    return false;
  }
}

