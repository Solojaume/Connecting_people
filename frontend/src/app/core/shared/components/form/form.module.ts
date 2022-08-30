import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormComponent } from './form.component';
import { ImputTextComponent } from './imputs/imput-text/imput-text.component';
import { ReactiveFormsModule } from '@angular/forms';
import { ButtonsModule } from '../buttons/buttons.module';



@NgModule({
  declarations: [
    FormComponent,
    ImputTextComponent
  ],
  imports: [
    CommonModule,
    ReactiveFormsModule,
    ButtonsModule
  ],
  exports:[
    FormComponent,
   
  ]
})
export class FormModule { }
