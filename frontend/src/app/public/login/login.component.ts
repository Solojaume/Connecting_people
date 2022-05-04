import { Component, OnInit } from '@angular/core';
import {FormControl, FormGroup, } from '@angular/forms';
import { Router } from '@angular/router';
import { UsuarioAPP } from 'src/app/core/models/usuario/usuario-app.model';
import { AuthService } from 'src/app/core/shared/services/auth.service';
import { TokenStorageService } from 'src/app/core/shared/services/token-storage.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {

  error:string="";
  constructor(private apiService:AuthService,
     private token:TokenStorageService,
    private router:Router ) { 
  }
  formularioLogin = new FormGroup({
    mail: new FormControl(''),
    password: new FormControl('')
  });

 

  submit() {
    let mail = this.formularioLogin.value.mail;
    let password = this.formularioLogin.value.password;

    this.apiService.usuarioLogin(password,mail).subscribe(usuario=> { 
      //console.log(usuario);
      if(usuario.error){
        this.error=usuario.error;
      }else{
        this.token.saveToken(usuario.token);
        this.token.saveUser(usuario);
        this.router.navigateByUrl("/home");

      }
      
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
