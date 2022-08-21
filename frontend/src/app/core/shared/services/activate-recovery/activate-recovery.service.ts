import { HttpClient, HttpClientModule } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { Request } from '../../../models/request.model';

@Injectable({
  providedIn: 'root'
})
export class ActivateRecoveryService {
  private apiBase!:string;
  constructor(private http:HttpClient) {
    this.apiBase = "http://localhost/connectingpeople/api/web/"
  }

  activate(token:string):Observable<Request>{
    return this.http.post<Request>(
      this.apiBase+"usuario/activate",JSON.stringify({
        token_activacion:token
      }));
  }

  recoveryPassword(token:string):Observable<Request>{
    return this.http.post<Request>(
      this.apiBase+"usuario/activate",JSON.stringify({
        token:token
      }));
  }
}
