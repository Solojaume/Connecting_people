import { Component, OnInit } from '@angular/core';
import {FormControl, FormGroup, } from '@angular/forms';
import { UsuarioAPP } from 'src/app/core/models/usuario/usuario-app.model';
import { ApiService } from 'src/app/core/shared/services/api.service';
import { AuthService } from 'src/app/core/shared/services/auth.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {
  datos!:any;

  error:{error:string}={error:""};
  constructor(private authService:AuthService) { 
  }
  formularioLogin = new FormGroup({
    mail: new FormControl(''),
    password: new FormControl('')
  });


  submit() {
    let mail = this.formularioLogin.value.mail;
    let password = this.formularioLogin.value.password;

    this.authService.login(password,mail).subscribe(usuario=> { 
      //console.log(usuario);
      //this.usuario=usuario;
      console.log(usuario);
      });
    //this.datos=JSON.stringify(this.us);
    //console.log(this.us); 
    
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
