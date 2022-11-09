import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { SharedModule } from 'src/app/core/shared/shared.module';
import { ServicesModule } from 'src/app/core/shared/services/services.module';
import {ScrollingModule} from '@angular/cdk/scrolling';
import { NgbDropdownModule, NgbRatingModule } from '@ng-bootstrap/ng-bootstrap';
import { ReviewComponent } from './review.component';
import { ReviewRoutingModule } from './review-routing.module';




@NgModule({
  declarations: [
    ReviewComponent
  ],
  imports: [
    CommonModule,
    ReviewRoutingModule,
    SharedModule,
    ServicesModule,
    ScrollingModule,
    NgbRatingModule
  ],
  exports:[
    ReviewComponent
  ],
  providers:[
    
  ]
})
export class ReviewModule { }
