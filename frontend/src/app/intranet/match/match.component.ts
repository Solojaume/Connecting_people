import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { CookieService } from 'ngx-cookie-service';
import { Subscription } from 'rxjs';
import { Match } from 'src/app/core/models/match.model';
import { AuthService } from 'src/app/core/shared/services/auth/auth.service';
import { MatchService } from 'src/app/core/shared/services/match/match.service';
import { TokenStorageService } from 'src/app/core/shared/services/token-storage/token-storage.service';
import { WebSocketService } from 'src/app/core/shared/services/activate-recovery/web-socket/web-socket.service';
import { WebSocketIOService } from 'src/app/core/shared/services/activate-recovery/web-socket/socket IO/web-socket-io.service';
import { ImagenesService } from 'src/app/core/shared/services/imagenes/imagenes.service';
import { Imagen } from 'src/app/core/models/imagen';
import { IImagenesComponentConfigAvanzada } from 'src/app/core/models/Interfaces/IImagenesComponentConfigAvanzada';

@Component({
  selector: 'app-match',
  templateUrl: './match.component.html',
  styleUrls: ['./match.component.scss']
})
export class MatchComponent implements OnInit {
 
  contUser!:number;
  constructor( private match:MatchService,
    private token:TokenStorageService,
    private router:Router,
    private cookieService:CookieService, 
    private apiService:AuthService,
    private webSocketService:WebSocketService,
    private imagenService: ImagenesService
    ) { }
  subscribe!:Subscription ;
  error:string="No hay más usuarios que mostrarte, vuelve más tarde";
  usuarios!:Match[];
  imagen!:any;
  nombre!:any;
  timestamp_nacimiento!:any;
  bacio:any=false;
  configSlider:IImagenesComponentConfigAvanzada[]=[];
  subscriptionNewUsers(){
    this.match.getNewMatchUsers().subscribe(
      u =>
      {
        if(u.length>=1){
          this.usuarios=u;
          console.log("Usuarios:",this.usuarios);
          this.contUser=0;
          this.imagen = this.usuarios[this.contUser].imagenes;
          this.nombre = this.usuarios[this.contUser].nombre;
          this.timestamp_nacimiento = this.usuarios[this.contUser].timestamp_nacimiento;
          for (let index = 0; index < this.imagen.length; index++) {
            const imagen = this.imagen[index];
            console.log( "IMAGEN:",imagen);
            let configIm={
              type:"slider-imagen",
              edad:this.timestamp_nacimiento,
              username:this.nombre,
              like_dislike_button:true,
              actived:true
            };
            let configAvanzada={
              config:configIm,
              img:imagen
            }
            this.configSlider.push(configAvanzada);
          }
          console.log("configSlider:",this.configSlider)
          this.error="";
        }else{
          this.usuarios = [];
          this.contUser = 0;
          this.imagen = "";
          this.nombre = "";
          this.timestamp_nacimiento = "";
          this.error="No hay más usuarios que mostrarte, vuelve más tarde";
        }
        
      }
    );
  }

  likeDislikeS(estado:number){
    if(this.usuarios.length>1){
      this.imagen=this.usuarios[this.contUser].imagenes[0].imagen_src;
      this.nombre = this.usuarios[this.contUser].nombre;
      this.timestamp_nacimiento = this.usuarios[this.contUser].timestamp_nacimiento;
      this.removeItemFromArr(this.usuarios,this.usuarios[this.contUser]);
     // this.contUser=this.contUser+1;
      //console.log(this.contUser);
      this.error="";
    }else if(this.usuarios.length<=1){
      this.subscriptionNewUsers();
      this.contUser=0;
      this.usuarios=[];
        this.contUser=0;
        this.imagen = "";
        this.nombre = "";
        this.timestamp_nacimiento = "";
        this.error="No hay más usuarios que mostrarte, vuelve más tarde";
    }
    else{
       this.contUser=0;
       this.error="No hay más usuarios que mostrarte, vuelve más tarde";
    }
    this.subscribe=this.match.likeDislike(this.usuarios[this.contUser]["id"],estado).subscribe(s=>{
    
    });
  }

  ngOnInit(): void {
  
    this.subscriptionNewUsers();
  
    this.imagenService.getImagenes();
    this.contUser=0;
  
    console.log(this.imagen);
    let to=this.token.getToken();
    let us=this.token.getUser();
    
    let usuario={token:""};
    try {
      usuario=JSON.parse(this.cookieService.get("usuario"))??"";
    } catch (error) {
      
    }
    if(usuario.token!="" && this.token.getUser() &&this.token.getToken()){
      this.subscribe = this.apiService.autenticacion(usuario.token).subscribe(
        usu => {
          if(usu.error){
            this.token.signOut();
            this.cookieService.delete("usuario");
            this.token.signOut();
            this.router.navigateByUrl("/");
          }
        }
      );
    } else if(usuario.token==""||!this.token.getUser() && !this.token.getToken()) {
      this.token.signOut();
      this.router.navigateByUrl("/");
    }
    if(!this.token.getUser() && !this.token.getToken()) {
      this.token.signOut();
      this.router.navigateByUrl("/");
    }
  }

 //Recive por parametro si ha sido like o no 
 //Si es like recive true si no false
  likedislike(like:number){
    if(this.usuarios.length==1){
      this.subscriptionNewUsers();
    }
    this.removeItemFromArr(this.usuarios,this.usuarios[this.contUser]);
    
    console.log("ContUser:"+this.contUser);
    this.likeDislikeS(like);
    //this.subscribe.unsubscribe();
  }
  
  like(){
    this.likeDislikeS(1);
  }
  dislike(){
    this.likeDislikeS(2);
  }
  
  con(){
    return this.error==="";
  }
  //codigo sacado de http://www.etnassoft.com/2016/09/09/eliminar-un-elemento-de-un-array-en-javascript-metodos-mutables-e-inmutables/
  removeItemFromArr ( arr:Match[], item:any ) {
    var i = arr.indexOf( item );
 
    if ( i !== -1 ) {
        arr.splice( i, 1 );
        if (arr.length<=1){
          this.bacio=true;
        }
        if (arr.length<=1){
          this.usuarios=[];
        }
    } else{
      this.usuarios=[];
    }
  }
}
