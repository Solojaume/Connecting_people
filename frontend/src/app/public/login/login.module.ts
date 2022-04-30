import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { LoginComponent } from './login.component';
import { LoginRoutingModule } from './login-routing.module';
import { SharedModule } from 'src/app/core/shared/shared.module';
import { ApiService } from 'src/app/core/shared/services/api.service';



@NgModule({
  declarations: [
    LoginComponent
  ],
  imports: [
    CommonModule,
    LoginRoutingModule,
    SharedModule,
  ],
  exports:[
    LoginComponent
  ]
})
export class LoginModule { }
