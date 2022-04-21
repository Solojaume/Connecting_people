import { Component, OnInit } from '@angular/core';
import {FormControl, FormGroup, } from '@angular/forms';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {
  datos!:String;
  constructor() { 
  }
  formularioLogin = new FormGroup({
    mail: new FormControl(''),
    password: new FormControl('')
  });

  submit() {
    this.datos=`
    Mail=${this.formularioLogin.value.mail}
    Password=${this.formularioLogin.value.password}
    `;
    console.log(this.formularioLogin.value.nombre);
  }
  buttonLogueame={
    nombre: "Logueame",
    link: " ",
    classCSS:"btn-terciario",
    type: "submit"
  };
  
  buttonRegistrame= {
    nombre: "Registrame",
    link: "/register",
    classCSS:"btn-vacio-primary",
    type: "button"
  };

  buttoneRecuperar= {
    nombre: "Recuperar",
    link: "/recovery",
    classCSS:"btn-vacio-primary color-quintal",
    type: "button"
  };
  ngOnInit(): void {
  }

}
