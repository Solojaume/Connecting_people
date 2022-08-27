import { Component, Input, OnInit } from '@angular/core';
import { AngularFileUploaderConfig } from 'angular-file-uploader';
import { Imagen } from 'src/app/core/models/imagen';
import { environment } from 'src/environments/environment';

@Component({
  selector: 'app-new-image-uploader',
  templateUrl: './new-image-uploader.component.html',
  styleUrls: ['./new-image-uploader.component.scss']
})
export class NewImageUploaderComponent implements OnInit {
  @Input()  config!: AngularFileUploaderConfig;
  imagen!:Imagen;
  cond!:boolean;
  constructor() { }

  ngOnInit(): void {

  }

  updateImage(event:any){
    this.imagen = event.body.imagen;
    this.cond=typeof this.imagen.imagen_src!=='undefined';
    this.imagen.imagen_src = environment.imagenesBase + this.imagen.imagen_src;
  }
}
