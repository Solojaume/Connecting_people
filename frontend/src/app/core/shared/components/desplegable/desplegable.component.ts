import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { IMatchModel } from 'src/app/core/models/chat/Interfaces/IMatchModel';

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
  constructor() { }
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
  
  ocultar(){
    this.desplegado=false;
  }

  mostrar(){
    this.desplegado=true;
  }
  
  cambiarChatOMatch(element:any){
    
    this.chatEvent.emit(element);

  }

}
