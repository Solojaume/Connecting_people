import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { AuthService } from 'src/app/core/shared/services/auth.service';


@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.scss']
})
export class RegisterComponent implements OnInit {
  datos!:[any[],any[],any[],any[],any[]];
  //error:{text:any,errorType:any}={text:"",errorType:""};
  error!:string;
  errorType!:string;
  mensaje!:string;

  formularioRegistro = new FormGroup ({
    email: new FormControl(null,Validators.required),
    pass1: new FormControl(null,Validators.required),
    pass2: new FormControl(null,Validators.required),
    nombre:new FormControl(null,Validators.required),
    fecha_na:new FormControl(null,Validators.required),
    aceptTerms:new FormControl(false,Validators.requiredTrue)
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
    this.error="";
    this.errorType="";
    this.mensaje = "";
    let email = this.formularioRegistro.value.email;
    let password = this.formularioRegistro.value.pass1;
    let pass2 = this.formularioRegistro.value.pass2;
    let nombre = this.formularioRegistro.value.nombre;
    let fecha_na =this.formularioRegistro.value.fecha_na;
    let aceptTerms=this.formularioRegistro.value.aceptTerms;
    if(aceptTerms==true){
      this.auth.usuarioRegistro(email,password,pass2,nombre,fecha_na).subscribe(usuario=> { 

        console.log(usuario);
        if(usuario.error){
          //let error1=JSON.parse(usuario.error);
          this.error=usuario.error;
          this.errorType=usuario.errorType;
        }else if(usuario.mensaje){
          //this.error.text = usuario.mensaje;
          this.mensaje = usuario.mensaje;
        }
        console.log(usuario.error);
      });
    }
    else{
      this.error= "Tienes que aceptar los terminos y condiciones";
      this.errorType="aceptTerms";
    }

  }

  
  constructor(private auth:AuthService) { }

  ngOnInit(): void {
  }

}
