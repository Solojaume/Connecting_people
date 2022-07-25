import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { MensajesComponent } from './mensajes.component';
import { ServicesModule } from '../../services/services.module';
import { MensajeModule } from '../mensaje/mensaje.module';



@NgModule({
  declarations: [
    MensajesComponent
  ],
  imports: [
    CommonModule,
    ServicesModule,
    MensajeModule
  ],
  exports:[
   MensajesComponent
    
  ]
})
export class MensajesModule { }
