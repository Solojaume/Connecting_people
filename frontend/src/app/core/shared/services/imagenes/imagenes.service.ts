import { HttpClient, HttpClientXsrfModule } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { find, Observable } from 'rxjs';
import { Imagen } from 'src/app/core/models/imagen';
import { ImagenClass } from 'src/app/core/models/imagenClass';
import { UsuarioAPP } from 'src/app/core/models/usuario/usuario-app.model';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root'
})
export class ImagenesService {
  imagenes:ImagenClass[]=[new ImagenClass(0,"","",0)];
  constructor(private http:HttpClient) { 
    
  }
  
  getImagenesDelServer():Observable<ImagenClass[]>{
    return this.http.post<ImagenClass[]>(
      environment.apiBase+"imagen/get-imagen",JSON.stringify({

      })
    );
    
  }

  deleteImgen(id:number){
    this.deleteImagenAPI(id).subscribe(()=>{
      let posO =  this.imagenes.findIndex(object => { 
        return object.imagen_id === id;
      });
      this.imagenes.slice(posO,posO+1);
    });
  } 

  private deleteImagenAPI(id:number):Observable<void>{
    return this.http.post<void>(
      environment.apiBase+"imagen/get-delete",JSON.stringify({
        imagen_src:id
      })
    );
  }



  public getImagenes()  {
    return this.imagenes;
    
  }
  
  
}
