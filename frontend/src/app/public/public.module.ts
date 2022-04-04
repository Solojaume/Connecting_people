import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { PublicComponent } from './public.component';
import { PublicRoutingModule } from './public-routing.module';
import { SharedModule } from '../core/shared/shared.module';
import { ReactiveFormsModule } from '@angular/forms';

@NgModule({
  imports: [
    CommonModule,
    PublicRoutingModule,
    SharedModule, 
    ReactiveFormsModule
  ],
  exports:[
    PublicComponent,
    SharedModule
  ],
  declarations: [
    PublicComponent
  ],
  providers:[

  ]
})
export class PublicModule { }
