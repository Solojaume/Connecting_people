import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ActivarComponent } from './activar.component';
import { ActivarRoutingModule } from './activar.routing.module';
import { SharedModule } from 'src/app/core/shared/shared.module';



@NgModule({
  declarations: [ActivarComponent],
  imports: [
    CommonModule,
    ActivarRoutingModule,
    SharedModule
  ],exports:[
    ActivarComponent
  ]
})
export class ActivarModule { }
