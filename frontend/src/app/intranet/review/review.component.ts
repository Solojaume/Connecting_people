import { Component, OnDestroy, OnInit } from '@angular/core';
import { FormControl, FormGroup } from '@angular/forms';
import { Review } from 'src/app/core/models/review.model';
import { WebSocketIOService } from 'src/app/core/shared/services/activate-recovery/web-socket/socket IO/web-socket-io.service';
import { AspectoService } from 'src/app/core/shared/services/hacer_review/aspecto.service';
import { ReviewService } from 'src/app/core/shared/services/hacer_review/review.service';
import { TokenStorageService } from 'src/app/core/shared/services/token-storage/token-storage.service';

@Component({
  selector: 'app-review',
  templateUrl: './review.component.html',
  styleUrls: ['./review.component.scss']
})
export class ReviewComponent implements OnInit, OnDestroy {
  public claseQueUsaImput: string = 'form-control';
  public mensajeVacio:boolean =false;
  constructor(
    public aspecto: AspectoService,
    private reviewService:ReviewService, 
    private websocket:WebSocketIOService,
    private token:TokenStorageService
    ) { }
    
  ngOnInit(): void {
    this.formularioEnvio.valueChanges.subscribe((x) => {
      // console.log('x:', x.message);
      let y = '' + x.comentario;
      //alert(y);
      if (y.length <= 240 && y.length > 0) {
        this.claseQueUsaImput = 'form-control';
      }else if( y.length==0){
        this.mensajeVacio = true;
        this.claseQueUsaImput = 'form-control form-control-error';
      } else {
        this.claseQueUsaImput = 'form-control form-control-error';
      }
    });
  }
  ngOnDestroy(): void {
    this.websocket.emitEvent('update lista match', this.token.getUser());
  }
  tipo_review = 'simple';
  currentRate: Array<atributo> = [{ puntuacion: 1, max: 5 }, { puntuacion: 1, max: 1 }];
  readonly: boolean = false;
  formularioEnvio = new FormGroup({
    comentario: new FormControl(''),
  });
  
  cambiar(tipo: string) {
    this.tipo_review = tipo;
    switch (tipo) {
      case 'avanzado':
        this.readonly = true;
        break;

      default:
        this.readonly = false;
        break;
    }
  }

  calcularMedia() {
    let suma_puntuaciones = 0;
    let contador = this.aspecto.puntuaciones_review.length - 1;
    let aspectoGeneral = this.aspecto.aspectos[0];
    for (let index = 1; index < this.aspecto.puntuaciones_review.length; index++) {
      const puntuacion_r = this.aspecto.puntuaciones_review[index];
      const aspecto = this.aspecto.aspectos[index];
      let puntuacion = puntuacion_r.puntuaciones_review_puntuacion;
      puntuacion = (puntuacion * aspectoGeneral.puntuacion_maxima) / aspecto.puntuacion_maxima;
      suma_puntuaciones = suma_puntuaciones + puntuacion;
    }
    this.aspecto.puntuaciones_review[0].puntuaciones_review_puntuacion = suma_puntuaciones / contador;
  }

  modificarPuntuacionesAvanzadas() {
    let puntuacion_gen = this.aspecto.puntuaciones_review[0].puntuaciones_review_puntuacion;
    let aspectoGeneral = this.aspecto.aspectos[0];
    for (let index = 1; index < this.aspecto.puntuaciones_review.length; index++) {
      const aspecto = this.aspecto.aspectos[index];
      let puntuacion = (puntuacion_gen * aspecto.puntuacion_maxima) / aspectoGeneral.puntuacion_maxima;
      this.aspecto.puntuaciones_review[index].puntuaciones_review_puntuacion = puntuacion;
    }

  }
 
  guardar(){  
    let review:Review={
      review_id:0,
      review_descripcion:this.formularioEnvio.value.comentario,
      review_usuario_id:this.websocket.chatUsar.match_id_usu2.id,
      puntuaciones_review:this.aspecto.puntuaciones_review
    }
    this.aspecto.generarPuntuacionesReview();
    this.reviewService.crearReview(review).subscribe((response)=>{
     console.log(response)
    });
  }
}

interface atributo {
  puntuacion: number,
  max: number,
  min?: number
}