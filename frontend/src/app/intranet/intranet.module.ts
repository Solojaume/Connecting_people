import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { IntranetComponent } from './intranet.component';
import { IntranetRoutingModule } from './intranet-routing.module';
import { SharedModule } from '../core/shared/shared.module';
import { WebSocketService } from '../core/shared/services/web-socket.service';
import { ServicesModule } from '../core/shared/services/services.module';

@NgModule({
  declarations: [
    IntranetComponent
  ],
  imports: [
    CommonModule,
    IntranetRoutingModule,
    SharedModule, 
    ServicesModule
  ],
  exports:[
    IntranetComponent
  ], 
  providers:[
    
  ]
})
export class IntranetModule { }
