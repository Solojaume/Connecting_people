import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { environment } from 'src/environments/environment';
import { Match } from '../../../models/match.model';
import { SliderButtonService } from '../slider-button/slider-button.service';

@Injectable({
  providedIn: 'root'
})
export class MatchService {
  private apiBase!:string;

  constructor(private http:HttpClient) { 
    this.apiBase = environment.apiBase;
  }

  getNewMatchUsers(){

    return this.http.post<Match[]>(
      this.apiBase+"mach/get_new_match_users_list",JSON.stringify(
      {
      }
      ));
  }
  

  likeDislike(id:number,estado:number){
    return this.http.post(this.apiBase+"mach/like-dislike",JSON.stringify({
      usuario_id:id,
      estado:estado
    }));
  }

  deshacerPost(match_id:number){
    return this.http.post(this.apiBase+"mach/deshacer",JSON.stringify({
      match_id: match_id     
    }));
  }

}

