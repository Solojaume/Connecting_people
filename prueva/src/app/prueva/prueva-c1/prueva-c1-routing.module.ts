import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { PruevaC1Component } from './prueva-c1.component';




const routes: Routes = [
  
  {
    path: '', component: PruevaC1Component,children:[]
  }

];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class PruevaC1RoutingModule { }
