import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { TerminosCondicionesComponent } from './terminos-condiciones.component';
import { TerminosCondicionesRoutingModule } from './terminos-condiciones-routing.module';



@NgModule({
  declarations: [
    TerminosCondicionesComponent,
  ],
  imports: [
    CommonModule,
    TerminosCondicionesRoutingModule
  ],
  exports:[
    TerminosCondicionesComponent,
    
  ]
})
export class TerminosCondicionesModule { }
