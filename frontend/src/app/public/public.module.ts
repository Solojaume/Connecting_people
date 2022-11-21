import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { PublicComponent } from './public.component';
import { PublicRoutingModule } from './public-routing.module';
import { SharedModule } from '../core/shared/shared.module';
import { RecoveryComponent } from './recovery/recovery.component';

@NgModule({
  imports: [
    CommonModule,
    PublicRoutingModule,
    SharedModule, 
    
  ],
  exports:[
    PublicComponent,
    SharedModule
  ],
  declarations: [
    PublicComponent,
  ],
  providers:[

  ]
})
export class PublicModule { }
