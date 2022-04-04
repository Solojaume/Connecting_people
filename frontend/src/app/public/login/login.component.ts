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

  submit() {/*'
  Nombre=${this.formularioContacto.value.nombre}
                Mail=${this.formularioContacto.value.mail}
                Mensaje=${this.formularioContacto.value.mensaje}'
  */
    /*
    this.datos=
    [['mail',${this.formularioContacto.value.nombre}],
    ['password',${this.formularioContacto.value.nombre}]];*/
    this.datos=`Mail=${this.formularioLogin.value.mail}
    Password=${this.formularioLogin.value.password}
    `;
    console.log(this.formularioLogin.value.nombre);
  }
 

  ngOnInit(): void {
  }

}
