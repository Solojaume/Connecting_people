import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { LoginComponent } from './login.component';
import { LoginRoutingModule } from './login-routing.module';
import { SharedModule } from 'src/app/core/shared/shared.module';
import { ServicesModule } from 'src/app/core/shared/services/services.module';



@NgModule({
  declarations: [
    LoginComponent
  ],
  imports: [
    CommonModule,
    LoginRoutingModule,
    SharedModule,
    ServicesModule
  ],
  exports:[
    LoginComponent
  ]
})
export class LoginModule { }
