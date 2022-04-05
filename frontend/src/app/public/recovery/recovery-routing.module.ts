import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { RecoveryComponent } from './recovery.component';
//redirectTo:'./recovery-screan'
const routes: Routes = [
  {path:'',component:RecoveryComponent,children:[
    {path:'',redirectTo:'/recovery/generate'},
    //{path:'',loadChildren:()=>import('./generate/generate.module').then(m=>m.GenerateModule)},//Sirve para introducir el email al que enviar la el link

    {path:'generate',loadChildren:()=>import('./generate/generate.module').then(m=>m.GenerateModule)},//Sirve para introducir el email al que enviar la el link
    {path:'recuperate',loadChildren:()=>import('./recuperate/recuperate.module').then(re=>re.RecuperateModule)}//Es al enlace al que se genera el acceso
  ]},  
 ];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class  RecoveryRoutingModule { }
