import { Component, OnInit } from '@angular/core';
import {FormControl, FormGroup, Validators, } from '@angular/forms';
import { Router } from '@angular/router';
import { CookieService } from 'ngx-cookie-service';
import { Observable, Subscription } from 'rxjs';
import { UsuarioAPP } from 'src/app/core/models/usuario/usuario-app.model';
import { AuthService } from 'src/app/core/shared/services/auth/auth.service';
import { TokenStorageService } from 'src/app/core/shared/services/token-storage/token-storage.service';
import { WebSocketService } from 'src/app/core/shared/services/activate-recovery/web-socket/web-socket.service';
import { WebSocketIOService } from 'src/app/core/shared/services/activate-recovery/web-socket/socket IO/web-socket-io.service';


@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {
  subscribe!:Subscription ;
  error:string="";

  constructor(private apiService:AuthService,
    private token:TokenStorageService,
    private router:Router, 
    private cookieService:CookieService,
    private webSocketService:WebSocketService,
    private socketService:WebSocketIOService ) { 
  }
 
  ngOnInit(): void {
    let usuario;
    this.socketService.setAutenticadoFalse();
   
    try {
      usuario=JSON.parse(this.cookieService.get("usuario"))??"";
    } catch (error) {
      usuario={token:""};
    }
   
   
    if(usuario.token!="" && this.token.getUser()  ){
      this.subscribe = this.apiService.autenticacion(usuario.token).subscribe(
        usu => {
          if(usu.error){
            this.error=usu.error;
            this.router.navigateByUrl("/");
          }else{
           
            this.token.saveToken(usu.token);
            this.token.saveUser(usu);
            this.router.navigateByUrl("/home");
          }
        }
      ); 
    } else if(usuario.token=="" && !this.token.getUser() && !this.token.getToken() || this.token.getUser() && !this.token.getToken()) {

      this.router.navigateByUrl("/");
    }else 
    if (this.token.getToken()&&this.token.getUser()) {
      let rol = this.token.getUser().roles;
      this.router.navigateByUrl("/home");
    }else{
      this.token.setReloadFalse();
    }
    
   
   
    
  }

  formularioLogin = new FormGroup({
    mail: new FormControl(''),
    password: new FormControl(''),
    rememberMe:new FormControl(false,Validators.requiredTrue)//Sirve para guardar el usuario en cookies

  });

 /* Función que suma o resta días a una fecha, si el parámetro
   días es negativo restará los días*/
   sumarDias(fecha:Date, dias:number){
    fecha.setDate(fecha.getDate() + dias);
    return fecha;
  }

  submit() {
    this.error='';
    let mail = this.formularioLogin.value.mail;
    let password = this.formularioLogin.value.password;
    let rememberMe = this.formularioLogin.value.rememberMe;   
    if(mail!=""&&password!=""){
      this.apiService.usuarioLogin(password,mail).subscribe(usuario=> { 
        //console.log(usuario);
        if(usuario.error){
          this.error=usuario.error;
        }else{
          let now= new Date();
          let dias = 7;
          if(rememberMe==true)
            this.cookieService.set('usuario',JSON.stringify(usuario),this.sumarDias(now, dias));
          else{
            this.cookieService.set('usuario',JSON.stringify(usuario));
          }
            
          this.token.saveToken(usuario.token);
          this.token.saveUser(usuario);
          

          this.router.navigateByUrl("/home");
        }
        console.log(this.cookieService.get("usuario"));
      });
    }else{
      this.error='No existe usuario con el email: '+mail +' o se ha introducido una contraseña incorrecta';
    }
    
    
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

  ngOnDestroy(){
    this.webSocketService.setAutenticadoFalse();
  }

}
