import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup } from '@angular/forms';

@Component({
  selector: 'app-generate',
  templateUrl: './generate.component.html',
  styleUrls: ['./generate.component.scss']
})
export class GenerateComponent implements OnInit {

  constructor() { }

  ngOnInit(): void {
  }
  formularioRecovery = new FormGroup ({
    email: new FormControl(''),
  });
  submit(){

  }

}
