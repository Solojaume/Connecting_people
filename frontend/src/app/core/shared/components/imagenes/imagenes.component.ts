import {
  Component,
  EventEmitter,
  Input,
  OnChanges,
  OnInit,
  Output,
  SimpleChanges,
} from '@angular/core';
import { Imagen } from 'src/app/core/models/imagen';
import { IImagenesComponentConfig } from 'src/app/core/models/Interfaces/IImagenesComponentConfig';
import { IImagenesComponentConfigAvanzada } from 'src/app/core/models/Interfaces/IImagenesComponentConfigAvanzada';
import { environment } from 'src/environments/environment';
import { SliderButtonService } from '../../services/slider-button/slider-button.service';

@Component({
  selector: 'app-imagenes',
  templateUrl: './imagenes.component.html',
  styleUrls: ['./imagenes.component.scss'],
})
export class ImagenesComponent implements OnInit, OnChanges {
  @Input() config: IImagenesComponentConfig = {
    type: '',
  };
  @Input() imagenes: Imagen[] = [];
  @Input() configAvanzada!: IImagenesComponentConfigAvanzada;
  @Output() likeDislike: EventEmitter<string> = new EventEmitter<string>();

  imagen_src: string = 'https://bootdey.com/img/Content/avatar/avatar5.png';
  actived = 'active';
  avanzadaNull: boolean = false;
  constructor(public reviewsButtonsService: SliderButtonService) {}

  ngOnChanges(): void {
    console.log('Algo cambio aquí tienes las imagenes', this.imagenes);
    console.log('CONFIG AVANZADA en imagen component:', this.configAvanzada);
    if (
      this.configAvanzada != null &&
      this.configAvanzada.config.actived === false
    ) {
      this.actived = '';
    } else {
      this.actived = 'active';
    }
  }

  ngOnInit(): void {
    console.log('imagen_src:', this.imagen_src);
    console.log(
      'CONFIG AVANZADA en imagen component onInit:',
      this.configAvanzada
    );
    if (this.configAvanzada == null) {
      this.avanzadaNull = true;
    }
  }

  desplegar() {
    this.reviewsButtonsService.reviews_visibles = true;
    this.reviewsButtonsService.set_reviews_visibles(true);
  }

  ocultar() {
    this.reviewsButtonsService.reviews_visibles = false;
    this.reviewsButtonsService.set_reviews_visibles(false);
  }
  dislikeM() {
    this.likeDislike.emit('dislike');
  }
  likeM() {
    this.likeDislike.emit('like');
  }
  existFotosEnArray() {
    try {
      //console.log("Entra en try");
      //console.log("this.imagenes[0]",this.imagenes[0]);

      if (this.imagenes[0]) {
        // console.log("En el if");

        return true;
      }
    } catch (error) {
      //console.log("errors",error);
      return false;
    }
    return false;
  }
}
