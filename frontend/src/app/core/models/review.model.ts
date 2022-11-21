import { Puntuaciones_review } from "./puntuaciones_review";


export interface Review{
    review_id:number,
    review_descripcion:string,
    review_usuario_id:number, 
    puntuaciones_review:Puntuaciones_review[]
}