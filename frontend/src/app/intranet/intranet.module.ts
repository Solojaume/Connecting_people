import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { IntranetComponent } from './intranet.component';
import { IntranetRoutingModule } from './intranet-routing.module';
import { SharedModule } from '../core/shared/shared.module';
import { ServicesModule } from '../core/shared/services/services.module';
import { RouterLinkActive } from '@angular/router';

@NgModule({
  declarations: [
    IntranetComponent
  ],
  imports: [
    CommonModule,
    IntranetRoutingModule,
    SharedModule, 
    ServicesModule,
    
  ],
  exports:[
    IntranetComponent
  ], 
  providers:[
    
  ]
})
export class IntranetModule { }
