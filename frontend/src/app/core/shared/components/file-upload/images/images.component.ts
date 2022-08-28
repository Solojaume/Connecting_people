import { Component, Input, OnInit } from '@angular/core';
import { AngularFileUploaderConfig } from 'angular-file-uploader';
import { ImagenClass } from 'src/app/core/models/imagenClass';

@Component({
  selector: 'app-images',
  templateUrl: './images.component.html',
  styleUrls: ['./images.component.scss']
})
export class ImagesComponent implements OnInit {
  @Input() imagenes!:ImagenClass[];
  @Input()  config!: AngularFileUploaderConfig;
 

  constructor() { }

  ngOnInit(): void {
  }

}
