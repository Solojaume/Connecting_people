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
      },
      {
        path:'personal',loadChildren: () => import('./personal/personal.module')
        .then(mod=>mod.PersonalModule),
      },
      {
        path:'review',loadChildren: () => import('./review/review.module')
        .then(mod=>mod.ReviewModule),
      },
    ]
  }                         
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class IntranetRoutingModule { }
