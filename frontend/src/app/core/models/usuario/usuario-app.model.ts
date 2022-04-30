import { Injectable } from "@angular/core";
import { Model } from "../model.model";


export interface UsuarioAPP {
    id:number;
    nombre:string;
    rol:number;
    token:string;
    error:string;
}