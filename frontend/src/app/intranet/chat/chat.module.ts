import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ChatComponent } from './chat.component';
import { ChatRoutingModule } from './chat-routing.module';
import { SharedModule } from 'src/app/core/shared/shared.module';
import { ServicesModule } from 'src/app/core/shared/services/services.module';
import {ScrollingModule} from '@angular/cdk/scrolling';
import { NgbDropdownModule } from '@ng-bootstrap/ng-bootstrap';



@NgModule({
  declarations: [
    ChatComponent
  ],
  imports: [
    CommonModule,
    ChatRoutingModule,
    SharedModule,
    ServicesModule,
    ScrollingModule,
    NgbDropdownModule,
  ],
  exports:[
    ChatComponent
  ],
  providers:[
    
  ]
})
export class ChatModule { }
