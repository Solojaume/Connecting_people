import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
const routes: Routes = [
  {
    path:'',
    loadChildren: () => import('./public/public.module')
    .then(mod=>mod.PublicModule)
  },
  {
    path:'home',
    loadChildren: () => import('./intranet/intranet.module').then(mod=>mod.IntranetModule)
  },
  {
    path:'intranet',
    loadChildren: () => import('./intranet/intranet.module').then(mod=>mod.IntranetModule)
  },
  {path:'chat',redirectTo:'/intranet/chat'},
  {path:'personal',redirectTo:'/intranet/personal'}
 
  /*{
    path:'',component:PublicComponent
  }*/
];

@NgModule({
  imports: [RouterModule.forRoot(routes,{ useHash: true })],
  exports: [RouterModule]
})
export class AppRoutingModule { }
