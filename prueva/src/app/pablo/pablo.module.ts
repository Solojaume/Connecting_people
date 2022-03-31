import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { PabloComponent } from './pablo.component';
import { PabloRoutingModule } from './pablo-routing.module';



@NgModule({
  declarations: [
    PabloComponent
  ],
  imports: [
    CommonModule,
    PabloRoutingModule
  ],
  exports:[
    PabloComponent
  ],
  providers:[]
})
export class PabloModule { }
