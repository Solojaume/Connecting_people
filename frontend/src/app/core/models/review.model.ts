import { Puntuaciones_Review } from "./puntuaciones-review.model";

export interface Review{
    punt:number,
    max:number,
    comentario:string, 
    puntuaciones_review:Puntuaciones_Review[]
   
}