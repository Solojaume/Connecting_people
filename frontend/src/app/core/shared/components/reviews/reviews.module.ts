import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ReviewsComponent } from './reviews.component';
import { ReviewModule } from '../review/review.module';


@NgModule({
  declarations: [
    ReviewsComponent
  ],
  imports: [
    CommonModule,
    ReviewModule
  ],
  exports:[
    ReviewsComponent
  ]
})
export class ReviewsModule { }
