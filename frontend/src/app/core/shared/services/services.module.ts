import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { AuthService } from './auth.service';
import { HttpClientModule } from '@angular/common/http';
import { CookieService } from 'ngx-cookie-service';
import { ActivateRecoveryService } from './activate-recovery.service';



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
    CookieService 
  ]
})
export class ServicesModule { }
