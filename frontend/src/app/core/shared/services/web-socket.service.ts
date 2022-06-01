import { Injectable } from '@angular/core';
import { CookieService } from 'ngx-cookie-service';
import { ChatMessageDto } from '../../models/chat/chatMessageDto';
import { Comunicacion } from '../../models/chat/comunicacion';
import { IChatModels } from '../../models/chat/Interfaces/IChatModels';
import { TokenStorageService } from './token-storage.service';

@Injectable({
  providedIn: 'root'
})
export class WebSocketService {

  webSocket!: WebSocket;
  chatMessages: ChatMessageDto[] = [];

  constructor(private token:TokenStorageService, private cookies:CookieService) { }

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
      console.log(chatMessageDto);
      this.chatMessages.push(chatMessageDto);
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
