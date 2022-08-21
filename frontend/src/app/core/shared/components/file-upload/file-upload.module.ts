import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule } from '@angular/forms';

import { HttpClientModule } from '@angular/common/http';
import { AngularFileUploaderModule } from 'angular-file-uploader';



@NgModule({
  declarations: [
   
  ],
  imports: [
    AngularFileUploaderModule,
  ],
  exports:[
    AngularFileUploaderModule
  ],
  providers:[]
})
export class FileUploadModule { }
