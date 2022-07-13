import { IChatModels } from "./Interfaces/IChatModels";

export class ChatMessageDto implements IChatModels {
    id?: number | undefined;
    match_id?:number |undefined;
    chat_user: string;//token
    chat_message: any;
    chat_message_type:string;
    timestamp!:Date
    constructor(user: string, message: string, type:string, match_id:any = undefined,id=0,timestamp = new Date()){
        this.chat_user = user;
        this.chat_message = message;
        this.chat_message_type = type;
        this.match_id = match_id;
        this.id=id;
        this.timestamp = timestamp;
    }
}
