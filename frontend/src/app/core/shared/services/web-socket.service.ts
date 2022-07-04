import { Injectable } from '@angular/core';
import { Router } from '@angular/router';
import { CookieService } from 'ngx-cookie-service';
import { ChatMessageDto } from '../../models/chat/chatMessageDto';
import { ChatRoom } from '../../models/chat/chat_room';
import { Comunicacion } from '../../models/chat/comunicacion';
import { IChatModels } from '../../models/chat/Interfaces/IChatModels';
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
  chatRooms:ChatRoom[]= [];
  
  constructor(private token:TokenStorageService, private cookies:CookieService, private router:Router) {
    this.webSocket = new WebSocket(WEB_SOCKET_URL);
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

  public openWebSocket(){
    if(this.webSocket.readyState==3){
      this.newWebSocket();
      this.setAutenticadoFalse();
      //this.webSocket.OPEN;
    }
    console.log(this.webSocket)
    this.webSocket.onopen = (event) => {
      console.log('Open: ', event);
      if(this.getAutenticado()=="false"){
        let token=this.token.getToken()??JSON.parse(this.cookies.get('usuario')).token;
        let com = new Comunicacion("auth",token)
        console.log("Pre auth");
        this.sendMessage(com);
        console.log("auth");
        this.setAutenticadoTrue();
      }else if(this.getAutenticado()=="true"){
        let token=this.token.getToken()??JSON.parse(this.cookies.get('usuario')).token;
        let com = new Comunicacion("auth",token)
        console.log("Pre auth");
        this.sendMessage(com);
        console.log("auth");
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
          break;
        case "auth":
          console.log(chatMessageDto);
          //this.chatRooms.push(chatMessageDto.message);
          console.log(chatMessageDto.message);
          this.setAutenticadoTrue;
          break;
    
        case "chats":
          console.log(chatMessageDto);
          this.chatRooms.push(chatMessageDto.message);
          console.log(chatMessageDto.message);
          break;
        case "CambiadaPagina":
          
          break;
        default:
          console.log(chatMessageDto);
          this.chatMessages.push(chatMessageDto);
          break;
      }
     
    };

    this.webSocket.onclose = (event) => {
      console.log('Close: ', event);
      this.setAutenticadoFalse();
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
    let com = new Comunicacion("desconectar",token)
    this.sendMessage(com);
    try {
      console.log(this.webSocket);
      this.webSocket.close();
      
    } catch (error) {
      console.log(this.webSocket);
      console.log("uPS ALGO HIZO CRACKs");
      throw error;
      
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
      throw error;
     
    }
   
  }
}
