import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ModalsComponent } from './modals.component';
import { ModalAutofocusComponent } from './modal-autofocus/modal-autofocus.component';
import { NgbModal, NgbModalModule } from '@ng-bootstrap/ng-bootstrap';



@NgModule({
  declarations: [
    ModalsComponent,
    ModalAutofocusComponent
  ],
  imports: [
    CommonModule,
    NgbModalModule
  ],exports:[
    ModalAutofocusComponent,
    NgbModalModule
  ]
})
export class ModalsModule { }
