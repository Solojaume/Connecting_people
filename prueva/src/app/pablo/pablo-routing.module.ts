import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { PabloComponent } from './pablo.component';

const routes: Routes = [
  { path: '', component: PabloComponent,children: [
    {
      path: 'martinez',
      loadChildren: () => import(`./martinez/martinez.module`)
        .then(i=> i.MartinezModule)
    }
  ]},
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class PabloRoutingModule { }