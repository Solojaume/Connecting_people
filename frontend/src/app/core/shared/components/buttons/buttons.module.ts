import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ButtonsComponent } from './buttons.component';
import { ButtonCircularComponent } from './button-circular/button-circular.component';



@NgModule({
  declarations: [
    ButtonsComponent,
    ButtonCircularComponent
  ],
  imports: [
    CommonModule
  ], exports:[
    ButtonsComponent,
    ButtonCircularComponent
  ]
})
export class ButtonsModule { }
