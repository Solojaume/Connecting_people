import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { SubmitButtonComponent } from './submit-button/submit-button.component';
import { ButtonsComponent } from './buttons.component';
import { RedirectableButtonComponent } from './redirectable-button/redirectable-button.component';



@NgModule({
  declarations: [
    SubmitButtonComponent,
    ButtonsComponent,
    RedirectableButtonComponent
  ],
  imports: [
    CommonModule,
    
  ],
  exports:[
    SubmitButtonComponent,
    ButtonsComponent, 
    RedirectableButtonComponent,
    
  ]
})
export class ButtonsModule { }
