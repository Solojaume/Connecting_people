import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { PruevaComponent } from './prueva.component';
import { PruevaRoutingModule } from './prueva-routing.module';



@NgModule({
  declarations: [
    PruevaComponent,
  ],
  imports: [
    CommonModule,
    PruevaRoutingModule
  ],
  exports:[
    PruevaComponent
  ],
  providers:[]
  
})
export class PruevaModule { }
