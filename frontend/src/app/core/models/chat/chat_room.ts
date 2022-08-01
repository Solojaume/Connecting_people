import { ChatMessageDto } from "./chatMessageDto";
import { IMatchModel } from "./Interfaces/IMatchModel";
import { Match } from "./Match";

export class ChatRoom extends Match {
    mensajes?: ChatMessageDto[]|undefined;
    
    constructor(
        id:number, 
        estado_u1:string="Online",
        estado_u2:string="Online",
        usuario_1:any, 
        usuario_2:any,
        match_fecha: string,
        mensajes:any=undefined) {
        super(id,estado_u1,estado_u2,usuario_1,usuario_2,match_fecha);
        this.mensajes = mensajes;
    }
}