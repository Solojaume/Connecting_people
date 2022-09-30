import { Component, Input, OnChanges, OnInit } from '@angular/core';
import { AngularFileUploaderConfig } from 'angular-file-uploader';
import { Imagen } from 'src/app/core/models/imagen';
import { environment } from 'src/environments/environment';
import { ImagenesService } from '../../../services/imagenes/imagenes.service';
import {NgbActiveModal, NgbModal} from '@ng-bootstrap/ng-bootstrap';

@Component({
  selector: 'app-new-image-uploader',
  templateUrl: './new-image-uploader.component.html',
  styleUrls: ['./new-image-uploader.component.scss']
})
export class NewImageUploaderComponent implements OnChanges {
  @Input()  config!: AngularFileUploaderConfig;
  @Input() imagen!:Imagen;
  cond!:boolean;
  constructor(public imgService:ImagenesService) { }
  ngOnChanges(){
    this.cond = typeof this.imagen.imagen_src!=='undefined';

  }

  updateImage(event:any){
    this.imagen = event.body.imagen;
    this.cond=typeof this.imagen.imagen_src!=='undefined';
    this.imagen.imagen_src = environment.imagenesBase + this.imagen.imagen_src;
  }
  
  deleteI(){
    this.imagen.imagen_src = undefined;
    this.cond=typeof this.imagen.imagen_src!=='undefined';
    console.log("typeof imagen_src:", typeof this.imagen.imagen_src);
    this.imgService.deleteImagen(this.imagen.imagen_id); 

  }
}
