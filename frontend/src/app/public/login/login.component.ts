import { Component, OnInit } from '@angular/core';
import {FormControl, FormGroup, } from '@angular/forms';
import { UsuarioAPP } from 'src/app/core/models/usuario/usuario-app.model';
import { ApiService } from 'src/app/core/shared/services/api.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {
  datos!:any;
  usuario:UsuarioAPP= <UsuarioAPP>{id:-1,nombre:"", token:"",rol:0};
  us!:UsuarioAPP;
  error:{error:string}={error:""};
  constructor(private apiService:ApiService) { 
  }
  formularioLogin = new FormGroup({
    mail: new FormControl(''),
    password: new FormControl('')
  });

  usuarioApp(usuario:UsuarioAPP){
    this.usuario=usuario;

  }

  submit() {
    let mail = this.formularioLogin.value.mail;
    let password = this.formularioLogin.value.password;

    this.apiService.usuarioLogin(password,mail).subscribe(usuario=> { 
      //console.log(usuario);
      this.usuario=usuario;
      });
    //this.datos=JSON.stringify(this.us);
    //console.log(this.us); 
    console.log(this.usuario);
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
    classCSS:"btn-vacio-terciario ",
    type: "button"
  };

  buttoneRecuperar= {
    nombre: "Recuperar cuenta",
    link: "/recovery",
    classCSS:"btn-vacio-primary color-secondary mt-2",
    type: "button"
  };
  ngOnInit(): void {
  }

}
