import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { MensajeComponent } from './mensaje.component';



@NgModule({
  declarations: [
    MensajeComponent
  ],
  imports: [
    CommonModule,

  ],
  exports:[
    MensajeComponent,
    
  ]
})
export class MensajeModule { }
