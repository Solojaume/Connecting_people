import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { Review } from 'src/app/core/models/review.model';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root'
})
export class ReviewService {

  constructor(private http: HttpClient) { }

  public crearReview(review: Review): Observable<any> {
    let enviar = JSON.stringify({
      review_id: review.review_id,
      review_descripcion: review.review_descripcion,
      review_usuario_id: review.review_usuario_id,
      puntuaciones_review: review.puntuaciones_review
    });
    console.log("Review enviada, se ha enviado:",enviar);
    return this.http.post<any>(
      
      environment.apiBase + "review/create-review",enviar
    );
  }
}
