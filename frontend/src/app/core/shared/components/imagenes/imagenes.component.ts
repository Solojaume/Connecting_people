import { Component, Input, OnInit } from '@angular/core';
import { IImagenesComponentConfig } from 'src/app/core/models/Interfaces/IImagenesComponentConfig';

@Component({
  selector: 'app-imagenes',
  templateUrl: './imagenes.component.html',
  styleUrls: ['./imagenes.component.scss']
})
export class ImagenesComponent implements OnInit {
  @Input() config:IImagenesComponentConfig = {
    type:""
  };
  @Input() imagen_src:string="https://bootdey.com/img/Content/avatar/avatar5.png";
  constructor() { }

  ngOnInit(): void {
    console.log("imagen_src:",this.imagen_src)
  }

}
