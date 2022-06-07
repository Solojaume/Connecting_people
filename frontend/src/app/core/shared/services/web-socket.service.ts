import { Injectable } from '@angular/core';
import { Router } from '@angular/router';
import { CookieService } from 'ngx-cookie-service';
import { ChatMessageDto } from '../../models/chat/chatMessageDto';
import { ChatRoom } from '../../models/chat/chat_room';
import { Comunicacion } from '../../models/chat/comunicacion';
import { IChatModels } from '../../models/chat/Interfaces/IChatModels';
import { TokenStorageService } from './token-storage.service';

@Injectable({
  providedIn: 'root'
})
export class WebSocketService {

  webSocket!: WebSocket;
  chatMessages: ChatMessageDto[] = [];
  chatRooms:ChatRoom[]= []

  constructor(private token:TokenStorageService, private cookies:CookieService, private router:Router) { }

  public openWebSocket(){
    this.webSocket = new WebSocket('ws://localhost:8080/demo/php-socket.php');

    this.webSocket.onopen = (event) => {
      console.log('Open: ', event);
      let token=this.token.getToken()??JSON.parse(this.cookies.get('usuario')).token;
      let com= new Comunicacion("auth",token)
      this.sendMessage(com);
    };

    this.webSocket.onmessage = (event) => {
      const chatMessageDto = JSON.parse(event.data);
      switch (chatMessageDto.message_type) {
        case "auth_error":
          this.token.signOut();
          this.cookies.deleteAll();
          this.router.navigateByUrl("/");
          break;
        case "auth":
          console.log(chatMessageDto);
          this.chatRooms.push(chatMessageDto.message);
          console.log(chatMessageDto.message);
          break;
        default:
          console.log(chatMessageDto);
          this.chatMessages.push(chatMessageDto);
          break;
      }
     
    };

    this.webSocket.onclose = (event) => {
      console.log('Close: ', event);
    };

    this.webSocket.onerror = (error)=>{
      console.log("Error: ", error);
    };

  }

  public sendMessage(chatMessageDto: IChatModels){
    this.webSocket.send(JSON.stringify(chatMessageDto));
  }

  public closeWebSocket() {
    this.webSocket.close();
  }
}
