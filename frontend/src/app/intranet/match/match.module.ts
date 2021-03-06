import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { MatchComponent } from './match.component';
import { MatchRoutingModule } from './match-routing.module';
import { SharedModule } from 'src/app/core/shared/shared.module';



@NgModule({
  declarations: [
    MatchComponent
  ],
  imports: [
    CommonModule,
    MatchRoutingModule,
    SharedModule
  ],
  exports:[
    MatchComponent
  ]
})
export class MatchModule { }
