import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { DesplegableComponent } from './desplegable.component';



@NgModule({
  declarations: [
    DesplegableComponent
  ],
  imports: [
    CommonModule
  ],
  exports:[
    DesplegableComponent
  ]
})
export class DesplegableModule { }
