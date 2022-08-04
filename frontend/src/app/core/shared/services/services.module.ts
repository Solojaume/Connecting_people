import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { AuthService } from './auth/auth.service';
import { HttpClientModule } from '@angular/common/http';
import { CookieService } from 'ngx-cookie-service';
import { ActivateRecoveryService } from './activate-recovery/activate-recovery.service';
import { MatchService } from './match/match.service';
import { authInterceptorProviders } from '../_helpers/auth.interceptor';
import { WebSocketService } from './activate-recovery/web-socket/web-socket.service';
import { SocketIoConfig, SocketIoModule } from 'ngx-socket-io';
import { WebSocketIOService } from './activate-recovery/web-socket/socket IO/web-socket-io.service';
const config:SocketIoConfig={ url: 'socketIO://localhost:3000', options: {}}


@NgModule({
  declarations: [],
  imports: [
    CommonModule,
    HttpClientModule,
    SocketIoModule.forRoot(config)
  ],
  exports:[
    HttpClientModule
  ],
  providers:[
    AuthService,
    ActivateRecoveryService,
    CookieService,
    MatchService,
    WebSocketService,
    authInterceptorProviders,
    
  ]
})
export class ServicesModule { }
