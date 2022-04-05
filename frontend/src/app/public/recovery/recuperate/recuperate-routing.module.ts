import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { RecuperateComponent } from './recuperate.component';
//redirectTo:'./recovery-screan'
const routes: Routes = [
  {path:'',component:RecuperateComponent},

];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class  RecuperateRoutingModule { }
