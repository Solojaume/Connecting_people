import { Component, Input, OnInit } from '@angular/core';
import { Imagen } from 'src/app/core/models/imagen';
import { environment } from 'src/environments/environment';
import { ImagenesService } from '../../../services/imagenes/imagenes.service';
import { AngularFileUploaderConfig } from './angular-file-uploader.types';
@Component({
  selector: 'app-image-uploader',
  templateUrl: './image-uploader.component.html',
  styleUrls: ['./image-uploader.component.scss']
})
export class ImageUploaderComponent implements OnInit {
  // Inputs
  position!:number;
  @Input()  config!: AngularFileUploaderConfig;
  @Input()  srcImage: any = "";
  imagen!:Imagen;
  base:any = environment.imagenesBase;
  constructor(public imgService:ImagenesService) { }
  
  ngOnChanges(){
    console.log("SRCimage:", this.srcImage);
    this.imagen = this.srcImage;
    this.srcImage =  environment.imagenesBase + this.srcImage.imagen_src;
   
    this.position=this.findImage(this.imagen);
  }

  ngOnInit(): void {
    console.log("Imagen src:",this.srcImage)
    this.imagen=this.srcImage;
    this.srcImage =  environment.imagenesBase + this.srcImage.imagen_src;
    
  }
  
  updateSrc(vari:any){
    console.log("vari:",vari );
    switch (vari) {
      case "undefined":
      case "http://localhost/connectingpeople/api/imagenes/":
      case "http://localhost/connectingpeople/api/imagenes/undefined":
      case "":  
        if(this.imgService.imagenes[this.position].imagen_src != ""){
          this.srcImage="http://localhost/connectingpeople/api/imagenes/"+this.imgService.imagenes[this.position].imagen_src;
          
        }
          return false;
        break;  
      default:
          return true;
        break;
    }
  }

  notExits(vari:any){
    console.log("Position:", this.position );
    console.log("vari:",vari );
    switch (vari) {
      case "undefined":
      case "http://localhost/connectingpeople/api/imagenes/":
      case "http://localhost/connectingpeople/api/imagenes/undefined":
      case "":  
        if(this.imgService.imagenes[this.position].imagen_src != ""){
          this.srcImage="http://localhost/connectingpeople/api/imagenes/"+this.imgService.imagenes[this.position].imagen_src;
          
        }
          return false;
        break;  
      default:
          return true;
        break;
    }
    
  };

  delete(){
    console.log("Delete image:",this.imagen);
    this.imgService.deleteImagen(this.imagen.imagen_id,this.position); 
    this.srcImage="";
  }
  
  updateImage(event:any){
    console.log("Update Event:", event.body);
    this.srcImage = environment.imagenesBase + event.body.imagen.imagen_src;
    this.imgService.imagenes[this.position] = event.body.imagen;
  }

  findImage(i:any){
    
    for (let index = 0; index < this.imgService.imagenes.length; index++) {
      console.log("for:",index);
      console.log("imagenes[index]:",this.imgService.imagenes[index]);
      console.log("i:",i);
      if (this.imgService.imagenes[index].imagen_id == i.imagen_id) {
        console.log("if")
        return index;
        
      } 
    }
    console.log("devuelve0")
    return 0;
  }
}
