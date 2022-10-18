import { Component, OnInit } from '@angular/core';
import { NgbActiveModal } from '@ng-bootstrap/ng-bootstrap';

@Component({
  selector: 'app-modal-autofocus',
  templateUrl: './modal-autofocus.component.html',
  styleUrls: ['./modal-autofocus.component.scss']
})
export class ModalAutofocusComponent implements OnInit {

  constructor(public modal: NgbActiveModal) { }

  ngOnInit(): void {
  }

}
