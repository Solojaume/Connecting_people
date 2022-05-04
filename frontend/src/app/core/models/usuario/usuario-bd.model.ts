import { Injectable } from "@angular/core";
import { Model } from "../model.model";
import { UsuarioAPP } from "./usuario-app.model";

@Injectable({
    providedIn: 'root'
})

export class  UsuarioBd extends Model{
    /**
     *
     */
    constructor(
        object: {
            id:number,
            email:string,
            password:string,
            nombre:string,
            rol:number,
            timestamp_nacimiento:string, 
            token:string, 
            cad_token:string,
            token_recuperar_pass:string, 
            cad_token_recuperar_pass:string,
            activo:number}=
            {id:-1,email:"", password:"", nombre:"", rol:0, timestamp_nacimiento:"", token:"", 
                cad_token:"", token_recuperar_pass:"", cad_token_recuperar_pass:"", activo:0},
        id:number=-1,
        private email:string=" ",
        private password:string="",
        private nombre:string="",
        private rol:number,
        private timestamp_nacimiento:string="", 
        private token:string="", 
        private cad_token:string="",
        private token_recuperar_pass:string="",
        private cad_token_recuperar_pass:string="", 
        private activo:number=0
        ) 
        {
            super(object.id);
            if(id==-1&&email==" "){
                this.email=object.email;
                this.password=object.password,
                this.timestamp_nacimiento = object.timestamp_nacimiento, 
                this.cad_token = object.cad_token,
                this.token_recuperar_pass = object.token_recuperar_pass, 
                this.cad_token_recuperar_pass = object.cad_token_recuperar_pass,
                this.activo = object.activo;
            }else{
                super(id);
                this.email = email;
                this.password = password ,
                this.timestamp_nacimiento = timestamp_nacimiento, 
                this.cad_token = cad_token,
                this.token_recuperar_pass = token_recuperar_pass, 
                this.cad_token_recuperar_pass = cad_token_recuperar_pass,
                this.activo = activo;
            }
        
    }
}