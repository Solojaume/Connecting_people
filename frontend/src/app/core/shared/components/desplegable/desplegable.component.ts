import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { IMatchModel } from 'src/app/core/models/chat/Interfaces/IMatchModel';
import { WebSocketIOService } from '../../services/activate-recovery/web-socket/socket IO/web-socket-io.service';

@Component({
  selector: 'app-desplegable',
  templateUrl: './desplegable.component.html',
  styleUrls: ['./desplegable.component.scss']
})
export class DesplegableComponent implements OnInit {
  desplegado:boolean=true;
  
  @Input () tipo_objeto!:string;
  @Input () lista_objetos!:any[];
  @Output () chatEvent = new EventEmitter<any>();
 
  constructor(public socket:WebSocketIOService) {
  }
  //emited:boolean=false;
  ngOnChanges(){
    /*
    if(this.lista_objetos.length>=1 && this.emited == false){
      this.cambiarChatOMatch(this.lista_objetos[0]);
      this.emited = true;
    }
    */

    if(this.lista_objetos.length>=1){
      this.cambiarChatOMatch(this.lista_objetos[0]);
    }
  }

  ngOnInit(): void {
    if(this.lista_objetos.length>=1){
      this.cambiarChatOMatch(this.lista_objetos[0]);
    }
   
  }
  con(objeto:any){
    return  objeto.match_count_no_leidos>0;

  }
  ocultar(){
    this.desplegado=false;
  }

  mostrar(){
    this.desplegado=true;
  }
  
  cambiarChatOMatch(element:any){
    console.log("Element",element);
    this.chatEvent.emit(element);

  }

}
