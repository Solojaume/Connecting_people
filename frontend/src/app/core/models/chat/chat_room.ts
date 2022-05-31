import { ChatMessageDto } from "./chatMessageDto";
import { IMatchModel } from "./Interfaces/IMatchModel";
import { Match } from "./Match";

export class ChatRoom extends Match {
    mensajes?: ChatMessageDto[]|undefined;
    constructor(id:number, estado:string="Online", usuario_1:any, usuario_2:any, mensajes:any=undefined) {
        super(id,estado,usuario_1,usuario_2);
        this.mensajes = mensajes;
    }
}