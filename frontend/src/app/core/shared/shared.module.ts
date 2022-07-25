import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule } from '@angular/forms';
import { ReviewModule } from './components/review/review.module';
import { ReviewsModule } from './components/reviews/reviews.module';
import { ImagenesComponent } from './components/imagenes/imagenes.component';
import { MensajeModule } from './components/mensaje/mensaje.module';
import { ButtonsModule } from './components/buttons/buttons.module';
import { ServicesModule } from './services/services.module';
import { DesplegableComponent } from './components/desplegable/desplegable.component';
import { DesplegableModule } from './components/desplegable/desplegable.module';
import { MensajesModule } from './components/mensajes/mensajes.module';


@NgModule({
  declarations: [
      ImagenesComponent,
  ],
  imports: [
    CommonModule,
    ReactiveFormsModule,
    ReviewModule,
    ReviewsModule, 
    MensajeModule,
    ButtonsModule,
    DesplegableModule,
    MensajesModule
  ],
  exports:[
    ReviewModule,
    ReviewsModule,
    ReactiveFormsModule,
    MensajeModule,
    ButtonsModule,   
    DesplegableModule,
    MensajesModule    
  ],
  providers:[]
})
export class SharedModule { }
