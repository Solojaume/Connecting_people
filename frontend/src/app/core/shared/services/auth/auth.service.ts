import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { UsuarioAPP } from '../../../models/usuario/usuario-app.model';
import { Request } from '../../../models/request.model';
import { environment } from 'src/environments/environment';
@Injectable({
  providedIn: 'root'
})
export class AuthService {
  private apiBase!:string;
  constructor(private http:HttpClient) {
    this.apiBase = environment.apiBase;
  }

  usuarioLogin(password1:string,email1:string):Observable<UsuarioAPP>{
    //Defino las caveceras de la peticion
  
    let rest =this.http.post<UsuarioAPP>(
      this.apiBase+"usuario/login",JSON.stringify({
        email:email1, 
        password:password1
      }));
    //console.log(rest);
    return rest;
  }

  usuarioRegistro(email:string,pass1:string,pass2:string,nombre:string,fecha_na:string){
    return this.http.post<Request>(
      this.apiBase+"usuario/create2",JSON.stringify({
        email:email,
        password:pass1,
        pass2:pass2,
        nombre:nombre, 
        fecha_na:fecha_na
    }));
  }
  autenticacion(token:string){
    return this.http.post<UsuarioAPP>(
      this.apiBase+"usuario/autenticate",JSON.stringify({
        token:token
      }));
  }
}
