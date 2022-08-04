import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { HttpClientModule } from '@angular/common/http';
import { Injectable, EventEmitter, Output} from "@angular/core";
import { Socket } from 'ngx-socket-io';
import { CookieService } from 'ngx-cookie-service';
import { SocketIoConfig, SocketIoModule } from 'ngx-socket-io';
import { WebSocketIOService } from '../socket IO/web-socket-io.service';
const config:SocketIoConfig={ url: 'socketIO://localhost:3000', options: {}}


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
