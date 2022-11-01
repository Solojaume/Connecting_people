import { Puntuaciones_review } from "./puntuaciones_review";


export interface Review{
    review_id:number,
    review_descripcion:number,
    review_usuario_id:string, 
    puntuaciones_review:Puntuaciones_review[]
}