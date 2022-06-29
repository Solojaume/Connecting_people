import { Imagen } from "./imagen";
import { Review } from "./review.model";

export interface Match{
    id:number,
    timestamp_nacimiento:any,
    nombre:string,
    imagenes:Imagen[],
    reviews:Review[];
}