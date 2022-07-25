import { Component, Input, OnInit } from '@angular/core';
import { ChatMessageDto } from 'src/app/core/models/chat/chatMessageDto';
import { TokenStorageService } from '../../services/token-storage.service';

@Component({
  selector: 'app-mensajes',
  templateUrl: './mensajes.component.html',
  styleUrls: ['./mensajes.component.scss']
})
export class MensajesComponent implements OnInit {
  @Input () mensajes!:ChatMessageDto[]; //[fecha]
  @Input () u2:any;
  usuario!:any;
  constructor(private token:TokenStorageService) {
    this.usuario=token.getUser();
   }

  ngOnInit(): void {
  }

}
