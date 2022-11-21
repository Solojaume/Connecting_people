import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { Aspecto } from 'src/app/core/models/aspecto';
import { Puntuaciones_review } from 'src/app/core/models/puntuaciones_review';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root'
})
export class AspectoService {
  public aspectos: Aspecto[] = [];
  public puntuaciones_review: Puntuaciones_review[] = [];
  constructor(private http: HttpClient) {

  }

  public generarPuntuacionesReview() {
    this.puntuaciones_review=[];
    this.aspectos.forEach(a => {
      this.puntuaciones_review.push({
        puntuaciones_review_aspecto_id: a,
        puntuaciones_review_puntuacion: 1,
        puntuaciones_review_id: 0,
        puntuaciones_review_review_id: 0

      })
    });
  }
  public obtenerAspetos() {
    this.getAspectos().subscribe(
      (x) => {
        this.aspectos = x;
        let count = this.puntuaciones_review.length ?? 0;
        this.generarPuntuacionesReview();
      }
    )
  }

  getAspectos(): Observable<Aspecto[]> {
    return this.http.post<Aspecto[]>(
      environment.apiBase + "aspecto/get-aspectos", JSON.stringify({})
    );
  }
}
