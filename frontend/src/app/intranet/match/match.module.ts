import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { MatchComponent } from './match.component';
import { MatchRoutingModule } from './match-routing.module';
import { SharedModule } from 'src/app/core/shared/shared.module';
import { ServicesModule } from 'src/app/core/shared/services/services.module';
import { SocketModule } from 'src/app/core/shared/services/activate-recovery/web-socket/socket-module/socket.module';



@NgModule({
  declarations: [
    MatchComponent
  ],
  imports: [
    CommonModule,
    MatchRoutingModule,
    SharedModule,
    ServicesModule,
    SocketModule
  ],
  exports:[
    MatchComponent
  ]
})
export class MatchModule { }
