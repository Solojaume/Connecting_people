import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { MensajeComponent } from './mensaje.component';
import { ServicesModule } from '../../services/services.module';



@NgModule({
  declarations: [
    MensajeComponent
  ],
  imports: [
    CommonModule,
    ServicesModule
  ],
  exports:[
    MensajeComponent,
    
  ]
})
export class MensajeModule { }
