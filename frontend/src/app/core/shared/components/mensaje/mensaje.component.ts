import { Component, Input, OnInit } from '@angular/core';
import { ChatMessageDto } from 'src/app/core/models/chat/chatMessageDto';
import { IImagenesComponentConfig } from 'src/app/core/models/Interfaces/IImagenesComponentConfig';
import { MensajeModel } from 'src/app/core/models/mensaje.model';
import { ImagenesService } from '../../services/imagenes/imagenes.service';
import { TokenStorageService } from '../../services/token-storage/token-storage.service';
import { ImagenesModule } from '../imagenes/imagenes.module';

@Component({
  selector: 'app-mensaje',
  templateUrl: './mensaje.component.html',
  styleUrls: ['./mensaje.component.scss'],
})
export class MensajeComponent {
  @Input() mensaje!: MensajeModel; //[fecha]
  @Input() u2?: any;
  usuario!: any;

  config: IImagenesComponentConfig = {
    type: 'rounded',
  };
  constructor(
    private token: TokenStorageService,
    public imagenService: ImagenesService
  ) {
    this.usuario = token.getUser();
  }

}
