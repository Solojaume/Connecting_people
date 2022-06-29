import { IChatModels } from "./Interfaces/IChatModels";

export class ChatMessageDto implements IChatModels {
    id?: number | undefined;
    chat_room_id?:number | undefined;
    match_id?:number |undefined;
    chat_user: string;//token
    chat_message: any;
    chat_message_type:string;
    constructor(user: string, message: string, type:string, match_id:any =undefined, chat_room_id:any=undefined){
        this.chat_user = user;
        this.chat_message = message;
        this.chat_message_type = type;
        this.chat_room_id = chat_room_id;
        this.match_id = match_id;
    }
}
