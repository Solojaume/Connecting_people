import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { UsuarioAPP } from '../../models/usuario/usuario-app.model';

@Injectable({
  providedIn: 'root'
})
export class ApiService {
  private apiBase!:string;
  constructor(private http:HttpClient) {
    this.apiBase = "http://localhost/connectingpeople/api/web/"
  }

  usuarioLogin(password1:string,email1:string):Observable<UsuarioAPP>{
    //Defino las caveceras de la peticion
  
    let rest =this.http.post<UsuarioAPP>(
      this.apiBase+"usuario/login",JSON.stringify({email:email1, password:password1}));
    //console.log(rest);
    return rest;
  }
}
