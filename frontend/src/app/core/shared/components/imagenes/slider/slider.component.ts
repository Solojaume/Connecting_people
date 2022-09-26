import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
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

  likeDislikeM(l_d: string) {
    switch (l_d) {
      case 'dilike':
        this.dislike.emit();
        break;
      case 'like':
        this.like.emit();
        break;
      default:
        break;
    }
  }

  constructor(public sliderService: SliderService) {}

  ngOnInit(): void {
    this.configImagen = this.config[this.imagenPosition];
    this.sliderService.setSliderImagen(this.config[this.imagenPosition]);
  }

  cambiarImagen() {
    this.config[this.imagenPosition].config.actived = false;
    this.configImagen = this.config[this.imagenPosition];
    this.imagenPosition = this.imagenPosition + 1;
    this.sliderService.setSliderImagen(this.config[this.imagenPosition]);
  }

  ngOnChange(): void {}
}
