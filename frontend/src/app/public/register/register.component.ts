import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup } from '@angular/forms';
import { AuthService } from 'src/app/core/shared/services/auth.service';
@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.scss']
})
export class RegisterComponent implements OnInit {
  datos!:[any[],any[],any[],any[],any[]];
  error!:string;
  mensaje!:string;

  formularioRegistro = new FormGroup ({
    email: new FormControl(''),
    pass1: new FormControl(''),
    pass2: new FormControl(''),
    nombre:new FormControl(''),
    fecha_na:new FormControl(''),
  });

  //Objetos Button
  buttonRegistrame={
    nombre: "Registrarme",
    link: " ",
    classCSS:"btn-terciario",
    type: "submit"
  };  

  buttonIrLogin={
    nombre: "Ir a login",
    link: "/",
    classCSS:"btn-vacio-primary color-secondary mt-2",
    type: "button"
  }

  submit(){
    let email = this.formularioRegistro.value.email;
    let password = this.formularioRegistro.value.pass1;
    let pass2 = this.formularioRegistro.value.pass2;
    let nombre = this.formularioRegistro.value.nombre;
    let fecha_na =this.formularioRegistro.value.fecha_na;
    this.auth.usuarioRegistro(email,password,pass2,nombre,fecha_na).subscribe(usuario=> { 
      //console.log(usuario);
      if(usuario.error){
        this.error=usuario.error;
      }else if(usuario.mensaje){
        this.error = usuario.mensaje;
      }
    });
  }

  
  constructor(private auth:AuthService) { }

  ngOnInit(): void {
  }

}
