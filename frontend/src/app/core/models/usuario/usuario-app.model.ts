import { Injectable } from "@angular/core";


export interface UsuarioAPP {
    id:number;
    nombre:string;
    rol:number;
    token:string;
    error:any;
    errorType:any;
}