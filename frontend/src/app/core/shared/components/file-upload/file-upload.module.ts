import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { AngularFileUploaderModule } from 'angular-file-uploader';
import { ImageUploaderComponent } from './image-uploader/image-uploader.component';
import { ServicesModule } from '../../services/services.module';
import { ImagesComponent } from './images/images.component';
import { NewImageUploaderComponent } from './new-image-uploader/new-image-uploader.component';



@NgModule({
  declarations: [
    ImageUploaderComponent,
    ImagesComponent,
    NewImageUploaderComponent,
  ],
  imports: [
    AngularFileUploaderModule,
    CommonModule,
    ServicesModule
  ],
  exports:[
    AngularFileUploaderModule,
    ImageUploaderComponent,
    ImagesComponent
  ],
  providers:[]
})
export class FileUploadModule { }
