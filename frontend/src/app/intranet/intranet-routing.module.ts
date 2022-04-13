import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { IntranetComponent } from './intranet.component';

const routes: Routes = [
  {
    path:'', component:IntranetComponent, children:[
      {
        path:'', loadChildren: () => import('./match/match.module')
        .then(mod=>mod.MatchModule),
      },
      {
        path:'chat',loadChildren: () => import('./chat/chat.module')
        .then(mod=>mod.ChatModule),
      }
    ]
  }                         
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class IntranetRoutingModule { }
