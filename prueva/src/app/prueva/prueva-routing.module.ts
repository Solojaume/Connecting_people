import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

import { PruevaComponent } from './prueva.component';
import { PruevaModule } from './prueva.module';



const routes: Routes = [
  
  {
    path: '', component: PruevaComponent, children: [
      { 
        path:'',loadChildren:()=> import('./prueva-c1/prueva-c1.module').then(m => m.PruevaC1Module)
      },
      { 
        path:'prueva1',loadChildren:()=> import('./prueva-c1/prueva-c1.module').then(m => m.PruevaC1Module)
      }
  ]
  }

];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class PruevaRoutingModule { }
