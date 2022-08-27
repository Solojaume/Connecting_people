import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule } from '@angular/forms';
import { ReviewModule } from './components/review/review.module';
import { ReviewsModule } from './components/reviews/reviews.module';
import { MensajeModule } from './components/mensaje/mensaje.module';
import { ButtonsModule } from './components/buttons/buttons.module';
import { DesplegableModule } from './components/desplegable/desplegable.module';
import { MatchChatDesplegableModule } from './components/match-chat-desplegable/match-chat-desplegable.module';
import { HttpClientModule } from '@angular/common/http';
import { FileUploadModule } from './components/file-upload/file-upload.module';
import { ImagesComponent } from './components/file-upload/images/images.component';


@NgModule({
  declarations: [
   
   
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
    FileUploadModule
  ],
  exports:[
    HttpClientModule,
    ReviewModule,
    ReviewsModule,
    ReactiveFormsModule,
    MensajeModule,
    ButtonsModule,   
    DesplegableModule,
    FileUploadModule
  ],
  providers:[]
})
export class SharedModule { }
