import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { LoginComponent } from './login/login.component';
import { PublicComponent } from './public.component';
const routes: Routes = [
  {
    path: '', component:PublicComponent,children:[
      {
      path:'',loadChildren:()=>import('./login/login.module').then(m=>m.LoginModule)
      },  
      {
        path:'login',loadChildren:()=>import('./login/login.module').then(m=>m.LoginModule)
      },
      {
        path:'register',loadChildren:()=>import('./register/register.module').then(m=>m.RegisterModule),
      },
      {
        path:'recovery', 
        loadChildren:  () => import('./recovery/recovery.module').then(m=>m.RecoveryModule) 
      },
      {
        path:'activate',
        loadChildren: () => import('./activar/activar.module').then(m=>m.ActivarModule)
      }
    ]
  },
  

];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class PublicRoutingModule { }
