import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { IImagenesComponentConfigAvanzada } from 'src/app/core/models/Interfaces/IImagenesComponentConfigAvanzada';


@Injectable({
  providedIn: 'root'
})
export class SliderService {
  public configImagen:IImagenesComponentConfigAvanzada={
    config: { type: '' },
    img: {
      imagen_id: 0,
      imagen_localizacion_donde_subida: '',
      imagen_src: '',
      imagen_timestamp: '',
    },
  };

  constructor(private http:HttpClient) { 
    
  }

  public setSliderImagen(c:IImagenesComponentConfigAvanzada){
    this.configImagen.config.actived=false;
    this.configImagen=c;
  }


}
