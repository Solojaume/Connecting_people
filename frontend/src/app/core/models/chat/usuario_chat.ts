import { IChatModels } from "./Interfaces/IChatModels";

export class UsuarioChat implements IChatModels{
   id: number;
   nombre!:string;
   edad!:number;
   fotos:any;
   constructor(id:number,nombre:string,edad:number,fotos:any){
      this.id=id;
      this.nombre=nombre;
      this.edad=edad;
      this.fotos=fotos;
   }
}