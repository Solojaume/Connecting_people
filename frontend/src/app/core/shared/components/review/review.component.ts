import { Component, Input, OnChanges, OnInit, SimpleChanges } from '@angular/core';
import { AspectoService } from '../../services/hacer_review/aspecto.service';

@Component({
  selector: 'app-review',
  templateUrl: './review.component.html',
  styleUrls: ['./review.component.scss']
})
export class ReviewComponent implements OnInit,OnChanges {
  @Input () datos:any;
  public mostrar_ver_puntuaciones_review = false;
  //Variables 
  ver_mas!:boolean;
  ver_menos!:boolean;
  constructor(public aspectos:AspectoService) { }
  ngOnChanges(changes: SimpleChanges): void {
    this.mostrar_ver_puntuaciones_review = typeof this.datos.puntuaciones_review == null|| this.datos.puntuaciones_review.length>0;
    console.log("Review:",this.datos);

  }

  ngOnInit(): void {
    this.mostrar_ver_puntuaciones_review = typeof this.datos.puntuaciones_review == null || this.datos.puntuaciones_review.length>0;
    console.log("Review:",this.datos);
    this.ver_mas=false;
    this.ver_menos=true;
  }
  
  menos():void{
    this.ver_mas=false;
    this.ver_menos=true;
  }
  mas():void{
    this.ver_mas=true;
    this.ver_menos=false;
  }
  
  
  

}
