export class ChatMessageDto {
    chat_user: string;
    chat_message: string;

    constructor(user: string, message: string){
        this.chat_user = user;
        this.chat_message = message;
    }
}
