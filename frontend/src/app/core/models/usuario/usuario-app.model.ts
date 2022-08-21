import { Injectable } from "@angular/core";
import { ImagenesComponent } from "../../shared/components/imagenes/imagenes.component";
import { Imagen } from "../imagen";


export interface UsuarioAPP {
    id:number;
    nombre:string;
    rol?:number;
    token?:string;
    error?:string;
    fotos?:Imagen[];
    edad?:number;
}