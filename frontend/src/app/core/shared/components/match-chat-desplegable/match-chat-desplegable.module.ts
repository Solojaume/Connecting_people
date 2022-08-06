import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { MatchChatDesplegableComponent } from './match-chat-desplegable.component';
import { DesplegableModule } from '../desplegable/desplegable.module';



@NgModule({
  declarations: [
    MatchChatDesplegableComponent
  ],
  imports: [
    CommonModule,
    DesplegableModule
  ],
  exports:[
    MatchChatDesplegableComponent    
  ]
})
export class MatchChatDesplegableModule { }