import { Component, OnInit } from '@angular/core';
import { AspectoService } from 'src/app/core/shared/services/hacer_review/aspecto.service';

@Component({
  selector: 'app-review',
  templateUrl: './review.component.html',
  styleUrls: ['./review.component.scss']
})
export class ReviewComponent implements OnInit {

  constructor(public aspecto: AspectoService) { }
  tipo_review ='simple';
  currentRate:Array<atributo>=[{puntuacion:1,max:5},{puntuacion:1,max:1}];
  readonly:boolean=false;
  ngOnInit(): void {
    
  }
  cambiar(tipo:string){
    this.tipo_review = tipo;
    switch (tipo) {
      case 'avanzado':
        this.readonly=true;
        break;
    
      default:
        this.readonly=false;
        break;
    }
  }
  
  calcularMedia(){
    let suma_puntuaciones=0;
    let contador=this.aspecto.puntuaciones_review.length-1;
    let aspectoGeneral = this.aspecto.aspectos[0];
    for (let index = 1; index < this.aspecto.puntuaciones_review.length; index++) {
      const puntuacion_r = this.aspecto.puntuaciones_review[index];
      const aspecto = this.aspecto.aspectos[index];
      let puntuacion = puntuacion_r.puntuaciones_review_puntuacion;
      puntuacion = (puntuacion*aspectoGeneral.puntuacion_maxima)/aspecto.puntuacion_maxima;
      suma_puntuaciones= suma_puntuaciones+puntuacion;
    }
    this.aspecto.puntuaciones_review[0].puntuaciones_review_puntuacion = suma_puntuaciones/contador;
    
  }

}

interface atributo{
  puntuacion:number,
  max:number,
  min?:number
}