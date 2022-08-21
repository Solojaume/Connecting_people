import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RegisterComponent } from './register.component';
import { RegisterRoutingModule } from './register-routing.module';
import { SharedModule } from 'src/app/core/shared/shared.module';
import { ServicesModule } from 'src/app/core/shared/services/services.module';

@NgModule({
  declarations: [
    RegisterComponent
  ],
  imports: [
    CommonModule,
    RegisterRoutingModule,
    SharedModule,
    ServicesModule
  ],exports:[
    RegisterComponent
  ]
})
export class RegisterModule { }
