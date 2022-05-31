import { IChatModels } from "./Interfaces/IChatModels";

export class ChatMessageDto implements IChatModels {
    id?: number | undefined;
    id_chat!:number;
    chat_user: string;//token
    chat_message: string;
    chat_message_type:string;
    constructor(user: string, message: string, type:string){
        this.chat_user = user;
        this.chat_message = message;
        this.chat_message_type=type;
    }
}
