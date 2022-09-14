import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { IMatchModel } from 'src/app/core/models/chat/Interfaces/IMatchModel';
import { IImagenesComponentConfig } from 'src/app/core/models/Interfaces/IImagenesComponentConfig';
import { WebSocketIOService } from '../../services/activate-recovery/web-socket/socket IO/web-socket-io.service';

@Component({
  selector: 'app-desplegable',
  templateUrl: './desplegable.component.html',
  styleUrls: ['./desplegable.component.scss'],
})
export class DesplegableComponent implements OnInit {
  desplegado: boolean = true;

  @Input() tipo_objeto!: string;
  @Input() lista_objetos!: any[];
  @Output() chatEvent = new EventEmitter<any>();

  config: IImagenesComponentConfig = {
    type: 'rounded-with-margin',
  };
  imagen_por_defecto = 'https://bootdey.com/img/Content/avatar/avatar5.png';
  constructor(public socket: WebSocketIOService) {}
  //emited:boolean=false;
  ngOnChanges() {
    if (this.lista_objetos.length >= 1) {
      this.cambiarChatOMatch(this.lista_objetos[0]);
    }
  }

  ngOnInit(): void {
    if (this.lista_objetos.length >= 1) {
      this.cambiarChatOMatch(this.lista_objetos[0]);
    }
  }

  con(objeto: any) {
    return objeto.match_count_no_leidos > 0;
  }

  ocultar() {
    this.desplegado = false;
  }

  mostrar() {
    this.desplegado = true;
  }

  cambiarChatOMatch(element: any) {
    console.log('Element', element);
    this.chatEvent.emit(element);
  }

  exist(d: any) {
    try {
      if (d) {
        return true;
      }
    } catch (error) {
      return false;
    }
    return false;
  }
}
