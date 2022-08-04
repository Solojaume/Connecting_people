import { Component, Input, OnInit } from '@angular/core';
import { ChatMessageDto } from 'src/app/core/models/chat/chatMessageDto';
import { TokenStorageService } from '../../services/token-storage/token-storage.service';

@Component({
  selector: 'app-mensaje',
  templateUrl: './mensaje.component.html',
  styleUrls: ['./mensaje.component.scss']
})
export class MensajeComponent implements OnInit {
  @Input () mensaje!:ChatMessageDto; //[fecha]
  @Input () u2?:any;
  usuario!:any;
  constructor(private token:TokenStorageService) {
    this.usuario=token.getUser();
   }

  ngOnInit(): void {
  }

}
