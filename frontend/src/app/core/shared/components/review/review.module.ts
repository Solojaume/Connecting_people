import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ReviewComponent } from './review.component';
import { StarsComponent } from './components/stars/stars.component';
import { ComentarioComponent } from './components/comentario/comentario.component';
import { PuntuacionesReviewComponent } from './components/puntuaciones-review/puntuaciones-review.component';


@NgModule({
  declarations: [
    ReviewComponent,
    StarsComponent,
    ComentarioComponent,
    PuntuacionesReviewComponent
  ],
  imports: [
    CommonModule
  ],
  exports:[
    ReviewComponent
  ]
})
export class ReviewModule { }
