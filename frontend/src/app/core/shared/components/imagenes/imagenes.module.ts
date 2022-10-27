import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ImagenesComponent } from './imagenes.component';
import { SliderComponent } from './slider/slider.component';
import { ButtonsModule } from '../buttons/buttons.module';



@NgModule({
  declarations: [ImagenesComponent, SliderComponent],
  imports: [
    CommonModule,
    ButtonsModule
  ],
  exports:[
    ImagenesComponent,
    SliderComponent
  ]
})
export class ImagenesModule { }
