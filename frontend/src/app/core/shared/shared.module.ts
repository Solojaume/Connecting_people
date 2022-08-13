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
import { MatchChatDesplegableComponent } from './components/match-chat-desplegable/match-chat-desplegable.component';
import { MatchChatDesplegableModule } from './components/match-chat-desplegable/match-chat-desplegable.module';
import { HttpClientModule } from '@angular/common/http';


@NgModule({
  declarations: [
    ImagenesComponent,
   
  ],
  imports: [
    CommonModule,
    HttpClientModule,
    ReactiveFormsModule,
    ReviewModule,
    ReviewsModule, 
    MensajeModule,
    ButtonsModule,
    DesplegableModule,
    MatchChatDesplegableModule

  ],
  exports:[
    HttpClientModule,
    ReviewModule,
    ReviewsModule,
    ReactiveFormsModule,
    MensajeModule,
    ButtonsModule,   
    DesplegableModule,
    MatchChatDesplegableModule,
    
  ],
  providers:[]
})
export class SharedModule { }
