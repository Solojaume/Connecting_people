import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ChatComponent } from './chat.component';
import { ChatRoutingModule } from './chat-routing.module';
import { SharedModule } from 'src/app/core/shared/shared.module';
import { ServicesModule } from 'src/app/core/shared/services/services.module';
import { SocketModule } from 'src/app/core/shared/services/activate-recovery/web-socket/socket-module/socket.module';



@NgModule({
  declarations: [
    ChatComponent
  ],
  imports: [
    CommonModule,
    ChatRoutingModule,
    SharedModule,
    ServicesModule,
    SocketModule
  ],
  exports:[
    ChatComponent
  ],
  providers:[
    
  ]
})
export class ChatModule { }
