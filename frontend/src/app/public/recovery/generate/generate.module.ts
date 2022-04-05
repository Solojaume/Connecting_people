import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { GenerateRoutingModule } from './generate-routing.module';
import { GenerateComponent } from './generate.component';
import { SharedModule } from 'src/app/core/shared/shared.module';



@NgModule({
  declarations: [
    GenerateComponent
  ],
  imports: [
    CommonModule,
    GenerateRoutingModule,
    SharedModule
  ],exports:[
    GenerateComponent
  ]
})
export class GenerateModule { }
