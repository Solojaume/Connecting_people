import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { LoginComponent } from './login/login.component';
import { PublicComponent } from './public.component';
const routes: Routes = [
  //{path: '', component:LoginComponent},
  {path:'',loadChildren:()=>import('./login/login.module').then(m=>m.LoginModule)},
  {path:'login',loadChildren:()=>import('./login/login.module').then(m=>m.LoginModule)}
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class PublicRoutingModule { }
