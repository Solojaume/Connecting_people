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
    let headers = new HttpHeaders().set('Content-type','application/x-www-form-urlencoded');
    headers = headers.set('Accept','*/*');
    //headers = headers.set('Connection','keep-alive')
    //headers = headers.set('Accept-Encoding',['gzip', 'deflate', 'br']);
   // headers = headers.set('Content-Length','104');
    //console.log(headers);
    let rest =this.http.post<UsuarioAPP>(this.apiBase+"usuario/login",{email:email1, password:password1},{headers:headers});
    //console.log(rest);
    return rest;
  }
}
