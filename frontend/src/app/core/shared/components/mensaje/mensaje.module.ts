import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { MensajeComponent } from './mensaje.component';
import { ServicesModule } from '../../services/services.module';
import { ImagenesModule } from '../imagenes/imagenes.module';



@NgModule({
  declarations: [
    MensajeComponent
  ],
  imports: [
    CommonModule,
    ServicesModule,
    ImagenesModule
  ],
  exports:[
    MensajeComponent,
    
  ]
})
export class MensajeModule { }
