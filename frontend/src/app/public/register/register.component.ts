import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup } from '@angular/forms';
@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.scss']
})
export class RegisterComponent implements OnInit {
  datos!:[any[],any[],any[],any[],any[]];

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
    this.datos=[['email',this.formularioRegistro.value.email],
    ['pass1',this.formularioRegistro.value.pass1],
    ['pass2',this.formularioRegistro.value.pass2],  
    ['nombre',this.formularioRegistro.value.nombre],
    ['fecha_na',this.formularioRegistro.value.pass1],
  ];
     
   
  }

  
  constructor() { }

  ngOnInit(): void {
  }

}
