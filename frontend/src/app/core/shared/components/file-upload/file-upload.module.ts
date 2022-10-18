import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { AngularFileUploaderModule } from 'angular-file-uploader';
import { ServicesModule } from '../../services/services.module';
import { ImagesComponent } from './images/images.component';
import { NewImageUploaderComponent } from './new-image-uploader/new-image-uploader.component';
import { ModalsModule } from '../modals/modals.module';





@NgModule({
  declarations: [
    ImagesComponent,
    NewImageUploaderComponent,
  ],
  imports: [
    AngularFileUploaderModule,
    CommonModule,
    ServicesModule,
    ModalsModule,
  ],
  exports:[
    AngularFileUploaderModule,
 
    ImagesComponent
  ],
  providers:[
  ]
})
export class FileUploadModule { }
