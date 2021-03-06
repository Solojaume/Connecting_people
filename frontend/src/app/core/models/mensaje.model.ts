import { Time } from "@angular/common";
import { Injectable } from "@angular/core";
import { Timestamp } from "rxjs";
import { Model } from "./model.model";

@Injectable({
    providedIn: 'root'
})

export class MensajeModel  {
    mensajes_id!:number;
    mensajes_match_id!:number;
    mensajes_contenido!:string;
    timestamp!:any;
    entregado!:number;
    mensajes_usuario_id!:number;
    constructor(args:any[]=[],men_id:number=0,men_match_id=0,m_cont="",time="2000-04-11", entregado=0,m_u_id=0) {
        if(args.length==6){
            for (let index = 0; index < args.length; index++) {

               switch (index) {
                   case 0:
                        this.mensajes_id = men_id;
                    break;
                   case 1:
                        this.mensajes_match_id = men_match_id;

                       break;
                    case 2:
                        this.mensajes_contenido = m_cont;

                        break;
                    case 3:
                        this.timestamp = time;
                       break;
                    case 4:
                        this.entregado = entregado;

                        break;
                    case 5:
                        this.mensajes_usuario_id = m_u_id;

                        break;
                   default:
                       break;
               } 
            }

        }else if(args.length==5){
           
            for (let index = 0; index < args.length; index++) {
               switch (index) {
                   case 0:
                        this.mensajes_match_id = men_match_id;

                       break;
                    case 1:
                        this.mensajes_contenido = m_cont;

                        break;
                    case 2:
                        this.timestamp = time;
                       break;
                    case 3:
                        this.entregado = entregado;

                        break;
                    case 4:
                        this.mensajes_usuario_id = m_u_id;
                        break;
                   default:
                       break;
               } 
            }
        }else{
           
            this.mensajes_id=men_id;
            this.mensajes_match_id = men_match_id;
            this.mensajes_contenido = m_cont;
            this.timestamp = time;
            this.entregado=entregado;
            this.mensajes_usuario_id=m_u_id;
        }

    }
}