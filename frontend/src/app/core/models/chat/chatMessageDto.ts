import { IChatModels } from "./Interfaces/IChatModels";

export class ChatMessageDto implements IChatModels {
    id?: number | undefined;
    match_id?:number |undefined;
    chat_user: any;//token
    chat_message: any;
    chat_message_type:string;
    timestamp!:Date;
    estado?:number;
    constructor(user: any, message: string, type:string, match_id:any = undefined,id=0,timestamp = new Date(),estado=-1){
        this.chat_user = user;
        this.chat_message = message;
        this.chat_message_type = type;
        this.match_id = match_id;
        this.id=id;
        this.timestamp = timestamp;
        this.estado=estado;
    }

    setEstado(estado:number){
        this.estado=estado;
    }
}
