import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { MartinezComponent } from './martinez.component';
import { MartinezRoutingModule } from './martinez-routing.module';



@NgModule({
  declarations: [
    MartinezComponent
  ],
  imports: [
    CommonModule,
    MartinezRoutingModule
  ],
  exports:[
    MartinezComponent
  ]
})
export class MartinezModule { }
