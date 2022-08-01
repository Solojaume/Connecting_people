import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { DesplegableComponent } from './desplegable.component';
import { ServicesModule } from '../../services/services.module';



@NgModule({
  declarations: [
    DesplegableComponent
  ],
  imports: [
    CommonModule,
    ServicesModule
  ],
  exports:[
    DesplegableComponent
  ]
})
export class DesplegableModule { }
