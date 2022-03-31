import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { MartinezComponent } from './martinez.component';

const routes: Routes = [
  { path: '', component: MartinezComponent },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class MartinezRoutingModule { }