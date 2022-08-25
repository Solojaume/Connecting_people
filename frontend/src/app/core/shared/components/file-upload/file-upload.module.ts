import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { AngularFileUploaderModule } from 'angular-file-uploader';
import { ImageUploaderComponent } from './image-uploader/image-uploader.component';
import { ServicesModule } from '../../services/services.module';



@NgModule({
  declarations: [
    ImageUploaderComponent
  ],
  imports: [
    AngularFileUploaderModule,
    CommonModule,
    ServicesModule
  ],
  exports:[
    AngularFileUploaderModule,
    ImageUploaderComponent
  ],
  providers:[]
})
export class FileUploadModule { }
