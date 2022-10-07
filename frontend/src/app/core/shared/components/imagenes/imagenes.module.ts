import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ImagenesComponent } from './imagenes.component';
import { SliderComponent } from './slider/slider.component';



@NgModule({
  declarations: [ImagenesComponent, SliderComponent],
  imports: [
    CommonModule
  ],
  exports:[
    ImagenesComponent,
    SliderComponent
  ]
})
export class ImagenesModule { }
