import { Injectable } from '@angular/core';
import { Router } from '@angular/router';
import { CookieService } from 'ngx-cookie-service';
import { ChatMessageDto } from '../../models/chat/chatMessageDto';
import { ChatRoom } from '../../models/chat/chat_room';
import { Comunicacion } from '../../models/chat/comunicacion';
import { IChatModels } from '../../models/chat/Interfaces/IChatModels';
import { Match } from '../../models/chat/Match';
import { TokenStorageService } from './token-storage.service';

const CHAT_USADO= 'Chat_usado';
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
  mensajes_sin_enviar:any[]=[]; 
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

  public setChat(params:any,param2="") {
    window.sessionStorage.removeItem(CHAT_USADO);
    window.sessionStorage.setItem(CHAT_USADO, params.match_id);
    if(param2!=""){
      window.sessionStorage.removeItem(CHAT_USADO);
      window.sessionStorage.setItem(CHAT_USADO, param2);
    }
    this.chatUsar=params;
    this.chatMessages=params.mensajes;
  }  

  public getChat():any{
    return window.sessionStorage.getItem(CHAT_USADO);
  }

  public findChat() : any {
    let devolver:any=false;
    this.chatRooms.forEach(element => {
      if(element.match_id == this.getChat()){
        devolver = element;
      }
      
    });
    return devolver;
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
        case "update_chats":

          break;
        case "reauth":
          console.log(chatMessageDto);
          let token2=this.token.getToken()??JSON.parse(this.cookies.get('usuario')).token;
          let com2 = new Comunicacion("update_chats",{"auth":token2});
          //let com2 = new Comunicacion("get_chats",token2);
          if(this.mensajes_sin_enviar.length>0){
            com2 = new Comunicacion("update_chats",{"auth":token2,"mensajes_nuevos":this.mensajes_sin_enviar});
            this.mensajes_sin_enviar=[];
          }
          this.sendMessage(com2);  
          break;
        case "CambiadaPagina":
          console.log(chatMessageDto);
          let token=this.token.getToken()??JSON.parse(this.cookies.get('usuario')).token;
          let com = new Comunicacion("get_chats",token);
          this.sendMessage(com);  
          break;
        case"estas":
          console.log(chatMessageDto);
          let token3=this.token.getToken()??JSON.parse(this.cookies.get('usuario')).token;
          let com3 = new Comunicacion("get_chats",token3);
          this.sendMessage(com3);  
          break;
        case "mensaje":
          console.log("Nuevo mensaje:",chatMessageDto);
          if(this.chatUsar.hasOwnProperty("mensajes")){
            this.añadirMensajeAChat(chatMessageDto);
          }
          else{
            this.añadirMensajeAMatch(chatMessageDto);
          }
          this.chatMessages=this.chatUsar.mensajes;
          break;
        case "chats":
          console.log(chatMessageDto);
          this.chatRooms=chatMessageDto.chat_message.Chats;
          this.matches=chatMessageDto.chat_message.Matches;
          let chat=this.findChat();
          if (chat!=false) {
            this.chatUsar=chat;
            this.chatMessages=chat.mensajes;
          }
          //console.log("Chats mensaje: ",chatMessageDto.chat_message.Chats);
         // console.log("Match mensaje: ",chatMessageDto.chat_message.Matches);
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

  public añadirMensajeAChat(mensaje:any){
    for (let index = 0; index < this.chatRooms.length; index++) {
      const element = this.chatRooms[index];
      //Si tiene mensajes y esta en chat usar
      if(this.chatUsar.match_id==this.chatRooms[index].match_id){
        this.chatRooms[index].mensajes?.push(mensaje);
       // this.chatUsar.mensajes.push(mensaje);
        //this.chatMessages.push(mensaje);
        return element;
      }
      //Si tiene mensajes y no esta en chat usar
      if(this.chatRooms[index].match_id==mensaje.match_id){
        this.chatRooms[index].mensajes?.push(mensaje);
        return element;
      }
    }
    return false;
  }
  public añadirMensajeAMatch(mensaje:any){
    for (let index = 0; index < this.matches.length; index++) {
      const element = this.matches[index];//
      //Si no tiene mensajes y no esta en chat usar
      if(mensaje.match_id==this.matches[index].match_id){
        //this.chatUsar.mensajes.push(mensaje);
        this.chatRooms.push(this.chatUsar);
        this.matches.slice(index);
        return element;
      }
      
    }
    return false;
  }
}

