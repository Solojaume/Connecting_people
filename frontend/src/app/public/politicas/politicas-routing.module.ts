import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { PoliticasComponent } from './politicas.component';

const routes: Routes = [
  {path:'',component:PoliticasComponent, children:[
    {path:'',loadChildren:()=>import('./terminos-condiciones/terminos-condiciones.module').then(m=>m.TerminosCondicionesModule)}
  ]},
  
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class PoliticasRoutingModule { }
