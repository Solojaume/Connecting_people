import { IChatModels } from "./Interfaces/IChatModels";

export class Comunicacion implements IChatModels{
    id?: number | undefined;
    //comand:string;
    //objeto:any;
    constructor(public comand:string, public objeto:any){

    }
}