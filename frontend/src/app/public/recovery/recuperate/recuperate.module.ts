import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RecuperateComponent } from './recuperate.component';
import { SharedModule } from 'src/app/core/shared/shared.module';
import { RecuperateRoutingModule } from './recuperate-routing.module';



@NgModule({
  declarations: [
    RecuperateComponent
  ],
  imports: [
    CommonModule,
    SharedModule, 
    RecuperateRoutingModule
  ],exports:[
    RecuperateComponent
  ]
})
export class RecuperateModule { }
