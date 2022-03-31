import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { HomeComponent } from './public/home/home.component';
import { LoginComponent } from './public/login/login.component';


const routes: Routes = [
  { path: 'pablo', component: HomeComponent, },
  {
    path: 'login', component:LoginComponent
  },
  {
    path:'prueva',
    loadChildren: () => import('./prueva/prueva.module')
    .then(mod=>mod.PruevaModule)
  },
  {
    path:'',
    loadChildren: () => import('./pablo/pablo.module')
    .then(mod=>mod.PabloModule)
  },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
