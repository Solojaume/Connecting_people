import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ReviewsComponent } from './reviews.component';
import { ReviewModule } from '../review/review.module';
import { ScrollingModule } from '@angular/cdk/scrolling';


@NgModule({
  declarations: [
    ReviewsComponent
  ],
  imports: [
    CommonModule,
    ReviewModule,
    ScrollingModule
  ],
  exports:[
    ReviewsComponent
  ]
})
export class ReviewsModule { }
