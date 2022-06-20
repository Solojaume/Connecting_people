import { Injectable } from '@angular/core';
import { WebSocketService } from './web-socket.service';

const WEB_SOCKET_SERVICE_KEY = 'web-socket-service';
@Injectable({
  providedIn: 'root'
})
export class WebSocketStorageService {

  constructor(private webSocketService:WebSocketService) {
   
  }
  
  public setWebSocketServiceWithStoredSocket() {
    this.webSocketService=this.getWebSocketStoredService();
    return this.webSocketService;
  }

  public saveWebSocketService(webSocketService:WebSocketService){
    window.sessionStorage.removeItem(WEB_SOCKET_SERVICE_KEY);
    window.sessionStorage.setItem(WEB_SOCKET_SERVICE_KEY, JSON.stringify(webSocketService));
  }

  public getWebSocketStoredService(){
   return JSON.parse(window.sessionStorage.getItem(WEB_SOCKET_SERVICE_KEY)??"");
   
  }

  public getWebSocketService(){
    return this.webSocketService;
  }

  public openWebSocketService(){
    this.webSocketService.openWebSocket()
    
  }

  public closeWebSocketService(){
    this.webSocketService.closeWebSocket();
    window.sessionStorage.removeItem(WEB_SOCKET_SERVICE_KEY);
  }

}
