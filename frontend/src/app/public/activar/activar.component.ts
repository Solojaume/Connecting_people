import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, ParamMap } from '@angular/router';
import { ActivateRecoveryService } from 'src/app/core/shared/services/activate-recovery/activate-recovery.service';

@Component({
  selector: 'app-activar',
  templateUrl: './activar.component.html',
  styleUrls: ['./activar.component.scss']
})
export class ActivarComponent implements OnInit {
  token:any;
  mensaje!:string;
  error!:string;
  constructor(
    private activatedRoute: ActivatedRoute,
    private activateService:ActivateRecoveryService
  ) { }

  buttonIrLogin= {
    nombre: "Regresar al login",
    link: "/",
    classCSS:"btn-terciario color-white mt-2",
    type: "button"
  };
  ngOnInit(): void {
    this.activatedRoute.paramMap.subscribe((parametros: ParamMap)=>{
      this.token=parametros.get("token_activacion");
     
    });
    this.activateService.activate(this.token).subscribe(activate=>{
      if(this.token==""||this.token==null){
        this.error="Enlace invalido"
      }
      if(activate.error){
        this.error=activate.error;
      } else if(activate.mensaje){
        this.mensaje=activate.mensaje;
      }
    });
  }
}
