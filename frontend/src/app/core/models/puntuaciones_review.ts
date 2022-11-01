import { Aspecto } from "./aspecto";

export interface Puntuaciones_review{
    puntuaciones_review_id:number,
    puntuaciones_review_aspecto_id:Aspecto ,
    puntuaciones_review_puntuacion:number,
    puntuaciones_review_review_id:number
}