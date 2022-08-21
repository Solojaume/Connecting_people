import { Component, Input, OnInit, Output } from '@angular/core';

@Component({
  selector: 'app-match-chat-desplegable',
  templateUrl: './match-chat-desplegable.component.html',
  styleUrls: ['./match-chat-desplegable.component.scss']
})
export class MatchChatDesplegableComponent implements OnInit {
  @Input() matches!:any[];
  @Input() mensajes!:{};
  @Input() usuarios!:{};
  m!:[];
  c!:[];
  //@Output () chatEvent = new EventEmitter<any>();
  constructor() { 
    
  }

  ngOnInit(): void {
    
  }
  
  cargarChat($event:Event) {
 $event;
  }
}
