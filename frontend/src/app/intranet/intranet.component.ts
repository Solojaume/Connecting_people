import { Component, OnInit, ViewChild } from '@angular/core';
import { Router } from '@angular/router';
import { CookieService } from 'ngx-cookie-service';
import { Subscription } from 'rxjs';
import { AuthService } from '../core/shared/services/auth.service';
import { TokenStorageService } from '../core/shared/services/token-storage.service';
import { WebSocketStorageService } from '../core/shared/services/web-socket-storage.service';
import { WebSocketService } from '../core/shared/services/web-socket.service';

@Component({
  selector: 'app-intranet',
  templateUrl: './intranet.component.html',
  styleUrls: ['./intranet.component.scss']
})
export class IntranetComponent implements OnInit {
  //webSocketService!:WebSocketService

  constructor( 
    private token:TokenStorageService, 
    private router:Router,
    private cookieService:CookieService, 
    private apiService:AuthService,
    public webSocketService:WebSocketService) {

   }
  subscribe!:Subscription ;
  error:string="";

  
  
  ngOnInit(): void {
    this.webSocketService.openWebSocket();  
  }
  
  logout(){
    this.token.signOut();
    this.cookieService.delete("usuario");
    this.webSocketService.closeWebSocket();
    this.token.signOut();
    this.router.navigateByUrl("/");
  }
  ngOnDestroy(){
    //this.webSocketService.closeWebSocket();
  }
}
