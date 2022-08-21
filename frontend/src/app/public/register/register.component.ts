import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { AuthService } from 'src/app/core/shared/services/auth/auth.service';
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
  today!:Date;
  errors!:string[];

  passwordL=false;

  email!:string;
  password!:string;
  pass2!:string;
  nombre!:string;
  fecha_na!:string;
  aceptTerms!:boolean;

  formularioRegistro = new FormGroup ({
    email: new FormControl("",Validators.required),
    pass1: new FormControl("",Validators.required),
    pass2: new FormControl("",Validators.required),
    nombre:new FormControl("",Validators.required),
    fecha_na:new FormControl("",Validators.required),
    aceptTerms:new FormControl("",Validators.requiredTrue)
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
    this.errors=[];

    this.email = this.formularioRegistro.value.email;
    this.password = this.formularioRegistro.value.pass1;
    this.pass2 = this.formularioRegistro.value.pass2;
    this.nombre = this.formularioRegistro.value.nombre;
    this.fecha_na =this.formularioRegistro.value.fecha_na;
    this.aceptTerms=this.formularioRegistro.value.aceptTerms;
    
    this.passwordL = false;
    if(this.email==""){
      this.errors.push(
          "El email es un campo requerido"
        );
    }
    if(this.password==""){
      this.errors.push(
        "La contraseña es un campo requerido"
      );
      this.passwordL = false;
    }else if(this.password.length<=5){
      this.errors.push(
        "La contraseña necesita minimo 6 caracteres"
      );
      this.passwordL =this.password.length<=5;
      
    }

    if(this.pass2==""){
      this.errors.push(
        "La confirmación de la contraseña es un campo requerido"
      );
    }else if(this.pass2!=this.password){
      this.errors.push(
        "La confirmación de la contraseña tiene que coincidir con la contraseña"
      );
      this.errorType="password2";
    }
    if(this.nombre==""){
      this.errors.push(
        "El nombre es un campo requerido"
      );
    } 
    if(this.fecha_na == ""){
      this.errors.push(
        "La fecha es un campo requerido"
      );
    }
    if(this.aceptTerms==true&&this.errors.length==0){
      this.auth.usuarioRegistro(this.email,this.password,this.pass2,this.nombre,this.fecha_na).subscribe(usuario=> { 
        if(usuario.error){
          //let error1=JSON.parse(usuario.error);
          this.error=usuario.error;
          this.errorType=usuario.errorType;
        }else if(usuario.mensaje){
          //this.error.text = usuario.mensaje;
          this.mensaje = usuario.mensaje;
        }
      });
    }
    else if(this.aceptTerms==false){
      this.error = "Tienes que aceptar los terminos y condiciones";
      this.errorType="aceptTerms";
    }

  }

  
  constructor(private auth:AuthService) { }

  ngOnInit(): void {
    this.today=new Date();
  }

}
