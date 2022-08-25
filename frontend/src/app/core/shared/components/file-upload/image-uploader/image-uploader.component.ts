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
  @Input()  config!: AngularFileUploaderConfig;
  @Input()  srcImage: any = "";
  imagen!:Imagen;
  constructor(private imgService:ImagenesService) { }
  
  ngOnChanges(){
    console.log("SRCimage:", this.srcImage);
    this.srcImage = this.srcImage=="undefined"?this.srcImage:environment.imagenesBase + this.srcImage.imagen_src;
  }

  ngOnInit(): void {
    console.log("Imagen src:",this.srcImage)
    this.imagen=this.srcImage;
    this.srcImage = this.srcImage=="undefined"?this.srcImage:environment.imagenesBase + this.srcImage.imagen_src;
    
  }

  exits(vari:any){
    console.log("vari:",vari );
    if(vari == "undefined")
      return true;
    if(vari == 'http://localhost/connectingpeople/api/imagenes/'){
      return true;
    }
    return false;
  };

  delete(){
    console.log("Delete");
    this.imgService.deleteImagen(this.imagen.imagen_id); 
    this.srcImage="";
  }
  
  updateImage(event:any){
    console.log("Update Event:", event.body);
    this.srcImage = environment.imagenesBase+ event.body.imagen.imagen_src;

  }
}
