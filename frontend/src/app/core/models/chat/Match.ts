import { ChatMessageDto } from "./chatMessageDto";
import { IChatModels } from "./Interfaces/IChatModels";
import { IMatchModel } from "./Interfaces/IMatchModel";

export class Match implements IMatchModel,IChatModels {
    id:number;
    match_id_usu1: any;
    match_id_usu2: any;
    estado_conexion_u1!: string;
    estado_conexion_u2!: string;
    match_fecha!: string;
    match_id!:number;
    
    constructor(id:number, estado_u1:string="Online",estado_u2:string="Online", usuario_1:any, usuario_2:any, match_fecha: string) {
        this.id = id;
        this.match_id = id;
        this.estado_conexion_u1 = estado_u1;
        this.estado_conexion_u2 = estado_u2;
        this.match_id_usu1 = usuario_1;
        this.match_id_usu2 = usuario_2;
        this.match_fecha = match_fecha;
    }
}