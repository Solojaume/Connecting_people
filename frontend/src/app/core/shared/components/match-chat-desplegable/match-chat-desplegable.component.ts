import { Component, Input, OnInit, Output } from '@angular/core';

@Component({
  selector: 'app-match-chat-desplegable',
  templateUrl: './match-chat-desplegable.component.html',
  styleUrls: ['./match-chat-desplegable.component.scss']
})
export class MatchChatDesplegableComponent  {
  @Input() matches!:any[];
  @Input() mensajes!:{};
  @Input() usuarios!:{};
  m!:[];
  c!:[];
  //@Output () chatEvent = new EventEmitter<any>();
  constructor() { 
    
  }

 
  
  cargarChat($event:Event) {
    $event;
  }
}
