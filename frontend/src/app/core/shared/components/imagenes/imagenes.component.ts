import { Component, Input, OnInit } from '@angular/core';
import { Imagen } from 'src/app/core/models/imagen';
import { IImagenesComponentConfig } from 'src/app/core/models/Interfaces/IImagenesComponentConfig';

@Component({
  selector: 'app-imagenes',
  templateUrl: './imagenes.component.html',
  styleUrls: ['./imagenes.component.scss'],
})
export class ImagenesComponent implements OnInit {
  @Input() config: IImagenesComponentConfig = {
    type: '',
  };
  @Input() imagenes: Imagen[]=[];

  imagen_src: string = 'https://bootdey.com/img/Content/avatar/avatar5.png';
  constructor() {}
  ngOnChange():void{
    console.log("Algo cambio aquí tienes las imagenes",this.imagenes);
  }

  ngOnInit(): void {
    console.log('imagen_src:', this.imagen_src);
  }

  existFotosEnArray() {
    try {
      console.log("Entra en try");
      console.log("this.imagenes[0]",this.imagenes[0]);

      if (this.imagenes[0]) {
        console.log("En el if");

        return true;
      }
    } catch (error) {
      console.log("errors",error);
      return false;
    }
    return false;
  }
}
