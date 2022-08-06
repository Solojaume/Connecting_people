import { Component, OnInit, ViewChild } from '@angular/core';
import { Router } from '@angular/router';
import { CookieService } from 'ngx-cookie-service';
import { Subscription } from 'rxjs';
import { AuthService } from '../core/shared/services/auth/auth.service';
import { TokenStorageService } from '../core/shared/services/token-storage/token-storage.service';
import { WebSocketService } from '../core/shared/services/activate-recovery/web-socket/web-socket.service';
import { WebSocketIOService } from '../core/shared/services/activate-recovery/web-socket/socket IO/web-socket-io.service';

@Component({
  selector: 'app-intranet',
  templateUrl: './intranet.component.html',
  styleUrls: ['./intranet.component.scss']
})
export class IntranetComponent implements OnInit {

  constructor( 
    private token:TokenStorageService, 
    private router:Router,
    private cookieService:CookieService, 
    private apiService:AuthService,
    public webSocketService:WebSocketService,
    private socketService:WebSocketIOService
  ) {

   }
  subscribe!:Subscription ;
  error:string="";

  
  
  ngOnInit(): void {
    
    //this.webSocketService.openWebSocket();  
  }
  
  logout(){
    this.webSocketService.closeWebSocket();
    this.token.signOut();
    this.cookieService.delete("usuario");
  
    this.token.signOut();
    this.router.navigateByUrl("/");
    //this.webSocketService.Resetear();
    this.socketService.close()
  }
  ngOnDestroy(){
    //this.webSocketService.CambiarPagina();  
  }
}
