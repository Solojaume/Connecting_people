import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ServicesModule } from './shared/services/services.module';
import { WebSocketService } from './shared/services/activate-recovery/web-socket/web-socket.service';



@NgModule({
  declarations: [],
  imports: [
    CommonModule,   
    ServicesModule
  ],
  exports:[
    ServicesModule

  ],
  providers:[]
})
export class CoreModule { }
