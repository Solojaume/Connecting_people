import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RecoveryComponent } from './recovery.component';
import { RecoveryRoutingModule } from './recovery-routing.module';
import { SharedModule } from 'src/app/core/shared/shared.module';


@NgModule({
  declarations: [
    RecoveryComponent,
  ],
  imports: [
    CommonModule, 
    RecoveryRoutingModule,
    SharedModule
  ],
  exports:[
    RecoveryComponent
  ]
})
export class RecoveryModule { }
