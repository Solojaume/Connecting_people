import { Component, Input, OnInit } from '@angular/core';
import { ChatMessageDto } from 'src/app/core/models/chat/chatMessageDto';

@Component({
  selector: 'app-mensaje',
  templateUrl: './mensaje.component.html',
  styleUrls: ['./mensaje.component.scss']
})
export class MensajeComponent implements OnInit {
  @Input () mensaje!:ChatMessageDto; //[fecha]
  constructor() { }

  ngOnInit(): void {
  }

}
