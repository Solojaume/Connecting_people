import { Imagen } from "./imagen";

export class ImagenClass implements Imagen{
   
    constructor(
        public imagen_id: number,
        public imagen_src?: string,
        public imagen_timestamp?: any,
        public imagen_usuario_id?: number
    ){}
   
}