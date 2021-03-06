import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ChatComponent } from './chat.component';
import { ChatRoutingModule } from './chat-routing.module';
import { SharedModule } from 'src/app/core/shared/shared.module';



@NgModule({
  declarations: [
    ChatComponent
  ],
  imports: [
    CommonModule,
    ChatRoutingModule,
    SharedModule
  ],
  exports:[
    ChatComponent
  ],
  providers:[
    
  ]
})
export class ChatModule { }
