import { ChatMessageDto } from "./chatMessageDto";
import { IChatModels } from "./Interfaces/IChatModels";
import { IMatchModel } from "./Interfaces/IMatchModel";

export class Match implements IMatchModel,IChatModels {
    id:number;
    usuario_1!:any;//Siempre es el local
    usuario_2!:any;
    estado:string;
    
    constructor(id:number, estado:string="Online", usuario_1:any, usuario_2:any) {
        this.id = id;
        this.estado = estado;
        this.usuario_1 = usuario_1;
        this.usuario_2 = usuario_2;
    }
}