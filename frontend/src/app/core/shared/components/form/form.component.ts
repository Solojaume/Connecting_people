import { tokenize } from '@angular/compiler/src/ml_parser/lexer';
import { Component, OnInit, ViewChild } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { CarmbiarService } from '../../services/cambiar/carmbiar.service';
import { TokenStorageService } from '../../services/token-storage/token-storage.service';
import { ImputTextComponent } from './imputs/imput-text/imput-text.component';

@Component({
  selector: 'app-form',
  templateUrl: './form.component.html',
  styleUrls: ['./form.component.scss']
})
export class FormComponent implements OnInit {
   constructor(private token:TokenStorageService,private cambiar:CarmbiarService) { }
  //@ViewChild(ImputTextComponent) child: ImputTextComponent;
  datos!:[any[],any[],any[],any[],any[]];
  //error:{text:any,errorType:any}={text:"",errorType:""};
  error!:string;
  errorType!:string;
  mensaje!:string;

  errors!:string[];

  passwordL=false;

  email!:string;
  passwordOriginal!:string;
  password!:string;
  pass2!:string;
  mostraCambiarEmail!:boolean;
  mostraCambiarContrasenya!:boolean;
  formularioRegistro = new FormGroup ({
    email: new FormControl("",Validators.required),
    pass1: new FormControl("",Validators.required),
    pass2: new FormControl("",Validators.required),
    passO: new FormControl("",Validators.required),
  });
  //Objetos Button
  buttonGuardar={
    nombre: "Guardar cambios",
    link: " ",
    classCSS:"btn btn-success",
    type: "submit"
  };  
  buttonCambiarContrasenya={
    nombre: "Cambiar Contraseña",
    link: " ",
    classCSS:" btn  btn-outline-terciario mt-1",
    type: "button"
  };
  buttonCambiarEmail={
    nombre: "Cambiar Email",
    link: " ",
    classCSS:"btn  btn-outline-dark mt-1",
    type: "button"
  };

  cambiarContrasenya(){
    if(this.mostraCambiarContrasenya==true){
      this.buttonCambiarContrasenya.nombre="Cambiar Contraseña";
      this.mostraCambiarContrasenya=false;
    }else{
      this.buttonCambiarContrasenya.nombre="No Cambiar Contraseña";
      this.mostraCambiarContrasenya=true;
    }
    console.log("MostrarContraseña",this.mostraCambiarContrasenya);
  }
  cambiarEmail(){
    if(this.mostraCambiarEmail==true){
      this.buttonCambiarEmail.nombre="Cambiar Email";
      this.mostraCambiarEmail=false;
    }else{
      this.buttonCambiarEmail.nombre="No Cambiar Email";

      this.mostraCambiarEmail=true;
    }
  }

  ngOnInit(): void {
    this.email=this.token.getUser().email;
    this.formularioRegistro.value.email=this.token.getUser().email;
  }
  submit(){
    this.error="";
    this.errorType="";
    this.mensaje = "";
    this.errors=[];

    this.email = this.formularioRegistro.value.email;
    this.password = this.formularioRegistro.value.pass1;
    this.pass2 = this.formularioRegistro.value.pass2;
    this.passwordOriginal = this.formularioRegistro.value.passO;
    
    this.passwordL = false;
    if(this.email=="" && this.mostraCambiarEmail==true){
      this.errors.push(
          "El email es un campo requerido"
        );
    }
    if(this.passwordOriginal==""&& this.mostraCambiarContrasenya==true){
      this.errors.push(
        "La contraseña antigua es un campo requerido"
      );
      this.passwordL = false;
    }
    if(this.password==""&& this.mostraCambiarContrasenya==true){
      this.errors.push(
        "La contraseña es un campo requerido"
      );
      this.passwordL = false;
    }else if(this.password.length<=5 && this.mostraCambiarContrasenya==true){
      this.errors.push(
        "La contraseña necesita minimo 6 caracteres"
      );
      this.passwordL =this.password.length<=5;
      
    }

    if(this.pass2==""&& this.mostraCambiarContrasenya==true){
      this.errors.push(
        "La confirmación de la contraseña es un campo requerido"
      );
    }else if(this.pass2!=this.password){
      this.errors.push(
        "La confirmación de la contraseña tiene que coincidir con la contraseña"
      );
      this.errorType="password2";
    }
    if(this.errors.length==0){
      this.cambiar.usuarioCambiar(this.email,this.mostraCambiarEmail,this.password,this.pass2,this.passwordOriginal,this.mostraCambiarContrasenya).subscribe(usuario=> { 
        if(usuario.error){
          //let error1=JSON.parse(usuario.error);
          this.error=usuario.error;
          this.errorType=usuario.errorType;
          alert(this.error);
        }else if(usuario.mensaje){
          //this.error.text = usuario.mensaje;
          this.mensaje = usuario.mensaje;
          this.mostraCambiarContrasenya==false;
          console.log("mensaje:",  this.mensaje);
        }
      });
    }
    console.log("Error Fuera del:",this.error);
    console.log("mensaje fuera:",  this.mensaje);
  }
}
