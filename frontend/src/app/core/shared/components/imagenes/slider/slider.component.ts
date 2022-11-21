import {
  Component,
  EventEmitter,
  Input,
  OnInit,
  Output,
  OnChanges,
  SimpleChanges,
} from '@angular/core';
import { IImagenesComponentConfig } from 'src/app/core/models/Interfaces/IImagenesComponentConfig';
import { IImagenesComponentConfigAvanzada } from 'src/app/core/models/Interfaces/IImagenesComponentConfigAvanzada';
import { SliderService } from './slider.service';

@Component({
  selector: 'app-slider',
  templateUrl: './slider.component.html',
  styleUrls: ['./slider.component.scss'],
})
export class SliderComponent implements OnInit {
  @Input() config: IImagenesComponentConfigAvanzada[] = [];
  configImagen!: IImagenesComponentConfigAvanzada;
  @Output() like = new EventEmitter<string>();
  @Output() dislike = new EventEmitter<string>();
  configIm: IImagenesComponentConfig = {
    type: 'slider-imagen',
    edad: 25,
    username: 'Pene',
    like_dislike_button: true,
    actived: true,
  };
  imagenPosition = 0;
  constructor(public sliderService: SliderService) {}

  likeDislikeM(l_d: string) {
    switch (l_d) {
      case 'dislike':
        this.dislike.emit();
        break;
      case 'like':
        this.like.emit();
        break;
      default:
        break;
    }
  }

  ngOnChanges(changes: SimpleChanges): void {
    console.log('LikeDislike hecho');
    console.log('slider imagenes:', this.config);
    try {
      if (this.config[this.imagenPosition - 1] == null) {
        this.classButtonAtras = 'd-none';
      }else{
        this.classButtonAdelantar = '';
      }
    } catch (error) {
      this.classButtonAtras = 'd-none';
    }
    try {
      if (this.config[this.imagenPosition + 1].img.imagen_src == '') {
        this.classButtonAdelantar = 'd-none';
      }else{
        this.classButtonAdelantar = '';
      }
    } catch (error) {
      this.classButtonAdelantar = 'd-none';
    }
  }

  ngOnInit(): void {
    console.log('Slider Cargado');
    try {
      if (this.config[this.imagenPosition - 1] == null) {
        this.classButtonAtras = 'd-none';
      }else{
        this.classButtonAdelantar = '';
      }
    } catch (error) {
      this.classButtonAtras = 'd-none';
    }
    try {
      if (this.config[this.imagenPosition + 1].img.imagen_src == '') {
        this.classButtonAdelantar = 'd-none';
      }else{
        this.classButtonAdelantar = '';
      }
    } catch (error) {
      this.classButtonAdelantar = 'd-none';
    }
  }
  public classButtonAdelantar!: string;
  cambiarImagenAdelante() {
    //Se esconde la imagen actual
    //this.config[this.imagenPosition].config.actived = false;
    //Se Cambia la posición de la imagen
    this.imagenPosition = this.imagenPosition + 1;
    //Se resetea la clase para que este oculto el boton atras
    this.classButtonAtras = '';
    //Se resetea la clase para que este oculto el boton adelante
    this.classButtonAdelantar = '';
   
    try {
      if (this.config[this.imagenPosition + 1].img.imagen_src == '') {
        this.classButtonAdelantar = 'd-none';
      }
    } catch (error) {
      this.classButtonAdelantar = 'd-none';
    }
  }

  public classButtonAtras = '';
  cambiarImagenAtras() {
    //this.config[this.imagenPosition].config.actived = false;
    this.imagenPosition = this.imagenPosition - 1;
   
    this.classButtonAdelantar = '';
    this.classButtonAtras = '';
    //this.config[this.imagenPosition].config.actived = true;
    this.configImagen = this.config[this.imagenPosition];
    try {
      if (this.config[this.imagenPosition - 1] == null) {
        this.classButtonAtras = 'd-none';
      }
    } catch (error) {
      this.classButtonAtras = 'd-none';
    }
  }
}
