import { Component, EventEmitter, Input, OnChanges, OnInit, Output } from '@angular/core';
import { IMatchModel } from 'src/app/core/models/chat/Interfaces/IMatchModel';
import { Match } from 'src/app/core/models/chat/Match';
import { IImagenesComponentConfig } from 'src/app/core/models/Interfaces/IImagenesComponentConfig';
import { WebSocketIOService } from '../../services/activate-recovery/web-socket/socket IO/web-socket-io.service';

@Component({
  selector: 'app-desplegable',
  templateUrl: './desplegable.component.html',
  styleUrls: ['./desplegable.component.scss'],
})
export class DesplegableComponent implements OnInit,OnChanges {
  desplegado: boolean = true;

  @Input() tipo_objeto!: string;
  @Input() lista_objetos!: Match[];
  @Output() chatEvent = new EventEmitter<any>();

  config: IImagenesComponentConfig = {
    type: 'rounded-with-margin',
  };
  imagen_por_defecto = 'https://bootdey.com/img/Content/avatar/avatar5.png';
  constructor(public socket: WebSocketIOService) {}
  //emited:boolean=false;
  ngOnChanges() {
    if (this.lista_objetos.length >= 1) {
      if(this.socket.chatUsar=="blanco"){
        this.cambiarChatOMatch(this.lista_objetos[0]);
      }
      this.cambiarChatOMatch(this.socket.chatUsar);
     
    }else{
      this.cambiarChatOMatch("blanco");
    }
  }

  ngOnInit(): void {
    if (this.lista_objetos.length >= 1) {
      if(this.socket.chatUsar=="blanco"){
        this.cambiarChatOMatch(this.lista_objetos[0]);
      }
      this.cambiarChatOMatch(this.socket.chatUsar);
      
    } else{
      this.cambiarChatOMatch("blanco");
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

  existFotosEnObjeto(objeto:any){
    if(objeto[0]){
      return true;
    }
    return false;
  }
}
