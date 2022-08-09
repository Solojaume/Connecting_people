import { Time } from "@angular/common";
import { Inject, Injectable} from "@angular/core";
import { Timestamp } from "rxjs";
import { Model } from "./model.model";

@Injectable({
    providedIn: 'root',
    
})

export class MensajeModel  {
    
    constructor(
        @Inject(Number) public chat_user:number,
        @Inject(String) public chat_message:string,
        @Inject(Number) public estado:number,
        @Inject(Number) public id:number,
        @Inject(Number) public match_id:number,
        @Inject(String) public message_type:string,
        @Inject(String) public timestamp:string
    )
    {
        
    }

}
