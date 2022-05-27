import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { AuthService } from './auth.service';
import { HttpClientModule } from '@angular/common/http';
import { CookieService } from 'ngx-cookie-service';
import { ActivateRecoveryService } from './activate-recovery.service';
import { MatchService } from './match.service';
import { authInterceptorProviders } from '../_helpers/auth.interceptor';
import {Subject, Observer, Observable} from 'rxjs';;



@NgModule({
  declarations: [],
  imports: [
    CommonModule,
    HttpClientModule
  ],
  exports:[
    HttpClientModule
  ],
  providers:[
    AuthService,
    ActivateRecoveryService,
    CookieService,
    MatchService,
    authInterceptorProviders
  ]
})
export class ServicesModule { }
