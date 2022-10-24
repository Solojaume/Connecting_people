import { Component, OnInit, OnChanges, SimpleChanges,Input } from '@angular/core';

@Component({
  selector: 'app-button-circular',
  templateUrl: './button-circular.component.html',
  styleUrls: ['./button-circular.component.scss'],
})
export class ButtonCircularComponent implements OnInit, OnChanges {
  @Input ()type: string = 'like';
  espacio: string = ' ';
  icono:string="";

  constructor() {}
  ngOnChanges(changes: SimpleChanges): void {
    this.config_vars();
  }

  ngOnInit(): void {
    this.config_vars();
  }

  config_vars() {
    switch (this.type) {
      case 'like':
        this.icono = "bi bi-heart-fill";
        break;
      case 'dislike':
        this.icono = "bi bi-x";
        break;
      case 'mostrar_reviews':
        break;
      case 'ocultar_reviews':
        break;
      default:
        break;
    }
  }
}
