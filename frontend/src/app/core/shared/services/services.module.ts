import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ApiService } from './api.service';
import { HttpClientModule } from '@angular/common/http';
import { AuthService } from './auth.service';
import { TokenStorageService } from './token-storage.service';



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
    ApiService,
    AuthService,
    TokenStorageService
  ]
})
export class ServicesModule { }
