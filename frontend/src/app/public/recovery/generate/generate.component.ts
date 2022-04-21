import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup } from '@angular/forms';

@Component({
  selector: 'app-generate',
  templateUrl: './generate.component.html',
  styleUrls: ['./generate.component.scss']
})
export class GenerateComponent implements OnInit {
    //Objetos Button
  buttonRecuperar={
    nombre: "Recuperar",
    link: " ",
    classCSS:"btn-terciario",
    type: "submit"
  };  

  buttonIrLogin={
    nombre: "Ir a login",
    link: "/",
    classCSS:"btn-vacio-primary color-quintal",
    type: "button"
  }
  constructor() { }

  ngOnInit(): void {
  }
  formularioRecovery = new FormGroup ({
    email: new FormControl(''),
  });
  submit(){

  }

}
