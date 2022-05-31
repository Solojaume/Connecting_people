import { IChatModels } from "./Interfaces/IChatModels";

export class usuario implements IChatModels{
    id?: number | undefined;
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