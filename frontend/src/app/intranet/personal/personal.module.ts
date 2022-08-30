import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { PersonalComponent } from './personal.component';
import { PersonalRoutingModule } from './personal-routing.module';
import { ReactiveFormsModule } from '@angular/forms';
import { SharedModule } from 'src/app/core/shared/shared.module';
import { HttpClientModule } from '@angular/common/http';
import { AngularFileUploaderModule } from "angular-file-uploader";
import { ServicesModule } from 'src/app/core/shared/services/services.module';

@NgModule({
  declarations: [
    PersonalComponent
  ],
  imports: [
    CommonModule,
    PersonalRoutingModule,
    ReactiveFormsModule, 
    SharedModule,
    ServicesModule
  ],
  exports:[
    PersonalComponent
  ]
})
export class PersonalModule { }
