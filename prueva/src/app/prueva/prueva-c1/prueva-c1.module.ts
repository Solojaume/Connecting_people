import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { PruevaC1Component } from './prueva-c1.component';
import { PruevaC1RoutingModule } from './prueva-c1-routing.module';



@NgModule({
  declarations: [
    PruevaC1Component
  ],
  imports: [
    CommonModule,
    PruevaC1RoutingModule
  ],
  exports:[
    PruevaC1Component
  ],
  providers: [
  ]
})
export class PruevaC1Module { }
