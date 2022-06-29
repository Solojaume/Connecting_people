import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { TerminosCondicionesComponent } from './terminos-condiciones/terminos-condiciones.component';
import { PoliticasRoutingModule } from './politicas-routing.module';
import { PoliticasComponent } from './politicas.component';



@NgModule({
  declarations: [
    PoliticasComponent
  ],
  imports: [
    CommonModule,
    PoliticasRoutingModule
  ],
  exports:[
    PoliticasComponent
  ]
})
export class PoliticasModule { }
