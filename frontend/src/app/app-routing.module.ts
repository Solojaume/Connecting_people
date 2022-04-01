import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { PublicComponent } from './public/public.component';
const routes: Routes = [
  {
    path:'',
    loadChildren: () => import('./public/public.module')
    .then(mod=>mod.PublicModule)
  }
  /*{
    path:'',component:PublicComponent
  }*/
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
