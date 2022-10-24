import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { DesplegableComponent } from './desplegable.component';
import { ServicesModule } from '../../services/services.module';
import { ImagenesModule } from '../imagenes/imagenes.module';



@NgModule({
  declarations: [
    DesplegableComponent
  ],
  imports: [
    CommonModule,
    ServicesModule,
    ImagenesModule
  ],
  exports:[
    DesplegableComponent
  ]
})
export class DesplegableModule { }
