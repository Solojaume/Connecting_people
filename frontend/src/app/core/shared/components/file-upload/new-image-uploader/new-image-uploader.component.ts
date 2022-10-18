import { Component, Input, OnChanges, Type } from '@angular/core';
import { AngularFileUploaderConfig } from 'angular-file-uploader';
import { Imagen } from 'src/app/core/models/imagen';
import { environment } from 'src/environments/environment';
import { ImagenesService } from '../../../services/imagenes/imagenes.service';
import {
  NgbActiveModal,
  NgbModal,
  NgbModalRef,
} from '@ng-bootstrap/ng-bootstrap';
import { ModalAutofocusComponent } from '../../modals/modal-autofocus/modal-autofocus.component';

@Component({
  selector: 'app-new-image-uploader',
  templateUrl: './new-image-uploader.component.html',
  styleUrls: ['./new-image-uploader.component.scss'],
})
export class NewImageUploaderComponent implements OnChanges {
  @Input() config!: AngularFileUploaderConfig;
  @Input() imagen!: Imagen;
  cond!: boolean;
  openedModal!: NgbModalRef;
  constructor(
    public imgService: ImagenesService,
    private _modalService: NgbModal
  ) {}
  withAutofocus = `<button type="button" ngbAutofocus class="btn btn-danger"
    (click)="modal.close('Ok click')">Ok</button>`;
  ngOnChanges() {
    this.cond = typeof this.imagen.imagen_src !== 'undefined';
  }

  updateImage(event: any) {
    this.imagen = event.body.imagen;
    this.cond = typeof this.imagen.imagen_src !== 'undefined';
    this.imagen.imagen_src = environment.imagenesBase + this.imagen.imagen_src;
  }

  deleteI() {
    this.imagen.imagen_src = undefined;
    this.cond = typeof this.imagen.imagen_src !== 'undefined';
    console.log('typeof imagen_src:', typeof this.imagen.imagen_src);
    this.imgService.deleteImagen(this.imagen.imagen_id);
  }
  open(name: string) {
    let modal = this._modalService.open(MODALS[name]);
    console.log('let Modal', modal);
    modal.closed.subscribe((closed)=>{
      console.log('CLOSED modal:', closed);
      this.deleteI();
    });
    modal.dismissed.subscribe((dismis)=>{
      console.log('Dismis modal:', dismis);
    });

  }
}

const MODALS: { [name: string]: Type<any> } = {
  autofocus: ModalAutofocusComponent,
};
