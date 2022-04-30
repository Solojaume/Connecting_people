import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule } from '@angular/forms';
import { ReviewModule } from './components/review/review.module';
import { ReviewsModule } from './components/reviews/reviews.module';
import { ImagenesComponent } from './components/imagenes/imagenes.component';
import { MensajeModule } from './components/mensaje/mensaje.module';
import { ButtonsModule } from './components/buttons/buttons.module';
import { HttpClientModule } from "@angular/common/http";
import { ServicesModule } from './services/services.module';



@NgModule({
  declarations: [
  
    ImagenesComponent
  ],
  imports: [
    CommonModule,
    ReactiveFormsModule,
    ReviewModule,
    ReviewsModule, 
    MensajeModule,
    ButtonsModule,
    ServicesModule
  ],
  exports:[
    ReviewModule,
    ReviewsModule,
    ReactiveFormsModule,
    MensajeModule,
    ButtonsModule,   
    ServicesModule

  ],
  providers:[]
})
export class SharedModule { }
