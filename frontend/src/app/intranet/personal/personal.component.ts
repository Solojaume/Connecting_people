import {
  HttpClient,
  HttpEvent,
  HttpEventType,
  HttpResponse,
} from '@angular/common/http';
import { Component, OnInit, OnDestroy } from '@angular/core';

import { Imagen } from 'src/app/core/models/imagen';
import { ImagenClass } from 'src/app/core/models/imagenClass';
import { WebSocketIOService } from 'src/app/core/shared/services/activate-recovery/web-socket/socket IO/web-socket-io.service';
import { ImagenesService } from 'src/app/core/shared/services/imagenes/imagenes.service';
import { TokenStorageService } from 'src/app/core/shared/services/token-storage/token-storage.service';
import { environment } from 'src/environments/environment';

@Component({
  selector: 'app-personal',
  templateUrl: './personal.component.html',
  styleUrls: ['./personal.component.scss'],
})
export class PersonalComponent implements OnInit, OnDestroy {
  progress = 0;
  img: ImagenClass[] = [];
  constructor(
    private token: TokenStorageService,
    public imgService: ImagenesService,
    private socketService: WebSocketIOService
  ) {
    this.img = imgService.imagenes;
  }

  ngOnInit(): void {
    this.socketService.setPage('personal');
  }

  ngOnDestroy(): void {
    
    this.socketService.emitEvent('update lista match', this.token.getUser());  
  }
  // @ts-nocheck

  /*
  afuConfig = {
    uploadAPI:  {
      url:"https://example-file-upload-api",
      //method:'POST',
      headers: {
        "Content-Type" : "text/plain;charset=UTF-8",
        "Authorization" : `Bearer ${this.token.getToken()}`
      },
      params: {
        'page': '1'
      },
      responseType: 'blob',
      withCredentials: false,
    },
    theme: "dragNDrop",
      hideProgressBar: true,
    hideResetBtn: true,
    hideSelectBtn: true,
    fileNameIndex: true,
    autoUpload: false,
    formatsAllowed: ".jpg,.png",

    multiple: false,
    maxSize: "1",
   
    replaceTexts: {
      selectFileBtn: 'Select Files',
      resetBtn: 'Reset',
      uploadBtn: 'Upload',
      dragNDropBox: 'Drag N Drop',
      attachPinBtn: 'Attach Files...',
      afterUploadMsg_success: 'Successfully Uploaded !',
      afterUploadMsg_error: 'Upload Failed !',
      sizeLimit: 'Size Limit'
    }
  };*/

  afuConfig = {
    uploadAPI: {
      url: environment.apiBase + 'imagen/subir-imagen',
    },
    autoUpload: true,
    hideResetBtn: true,
    formatsAllowed: 'images/*',
  };
}
