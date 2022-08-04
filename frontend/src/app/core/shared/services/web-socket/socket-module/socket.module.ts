import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { HttpClientModule } from '@angular/common/http';
import { SocketIoModule } from 'ngx-socket-io';
import { WebSocketIOService } from '../socket IO/web-socket-io.service';



@NgModule({
  declarations: [],
  imports: [
    CommonModule,
    HttpClientModule,
    SocketIoModule,
  ],
  exports:[
    HttpClientModule
  ],
  providers:[
    WebSocketIOService
  ]
})
export class SocketModule { }
