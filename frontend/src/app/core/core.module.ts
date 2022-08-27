import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ServicesModule } from './shared/services/services.module';



@NgModule({
  declarations: [
  ],
  imports: [
    CommonModule,   
    ServicesModule
  ],
  exports:[
    ServicesModule

  ],
  providers:[]
})
export class CoreModule { }
