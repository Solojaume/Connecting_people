import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { environment } from 'src/environments/environment';
import { Request } from '../../../models/request.model';
@Injectable({
  providedIn: 'root'
})
export class CarmbiarService {
  usuarioCambiar(email:string,cambiarEmail:boolean,pass1:string,pass2:string,passO:string,cambiarContrasenya:boolean){
    return this.http.post<Request>(
      environment.apiBase+"usuario/update2",JSON.stringify({
        email:email,
        cambiarEmail:cambiarEmail,
        password:pass1,
        pass2:pass2,
        passO:passO,
        cambiarContrasenya

    }));
  }
  constructor(private http:HttpClient) { }
}
