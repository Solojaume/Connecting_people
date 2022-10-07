import { HttpClient, HttpClientXsrfModule } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { find, Observable } from 'rxjs';
import { Imagen } from 'src/app/core/models/imagen';
import { ImagenClass } from 'src/app/core/models/imagenClass';
import { IImagenesComponentConfig } from 'src/app/core/models/Interfaces/IImagenesComponentConfig';
import { UsuarioAPP } from 'src/app/core/models/usuario/usuario-app.model';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root',
})
export class ImagenesService {
  imagenes: ImagenClass[] = [new ImagenClass(0, '', '', 0)];
  imgSRC: ImagenClass = new ImagenClass(0, '', '', 0);

  configIm: IImagenesComponentConfig = {
    type: 'slider-imagen',
    edad: 25,
    username: 'Pene',
    like_dislike_button: true,
  };
  constructor(private http: HttpClient) {}

  getImagenesDelServer(): Observable<ImagenClass[]> {
    return this.http.post<ImagenClass[]>(
      environment.apiBase + 'imagen/get-imagen',
      JSON.stringify({})
    );
  }

  deleteImagen(id: number, posO: number = 0) {
    this.deleteImagenAPI(id).subscribe(() => {
      this.imagenes.slice(posO, posO + 1);
      console.log('Imagenes después de eliminar:', this.imagenes);
    });
  }

  private deleteImagenAPI(id: number): Observable<void> {
    return this.http.post<void>(
      environment.apiBase + 'imagen/delete-imagen',
      JSON.stringify({
        imagen_id: id,
      })
    );
  }

  public getImagenes() {
    return this.imagenes;
  }

  public getConfigImage(array: Imagen[], nombre:string, edad:number) {
    var dev = [];
    
    this.configIm.edad = edad;
    this.configIm.username = nombre;
    for (let index = 0; index < array.length; index++) {
      const element = array[index];
      let o;
      if(element.imagen_src!=""){
        o = {
          config: this.configIm,
          img: element
        }
      }
     
      dev.push(o);
    }
    return dev;
  }
}
