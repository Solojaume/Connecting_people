import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { CookieService } from 'ngx-cookie-service';
import { Subscription } from 'rxjs';
import { Match } from 'src/app/core/models/match.model';
import { Review } from 'src/app/core/models/review.model';
import { AuthService } from 'src/app/core/shared/services/auth.service';
import { MatchService } from 'src/app/core/shared/services/match.service';
import { TokenStorageService } from 'src/app/core/shared/services/token-storage.service';

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
    private apiService:AuthService) { }
  subscribe!:Subscription ;
  error:string="No hay más usuarios que mostrarte, vuelve más tarde";
  usuarios!:Match[];
  imagen!:any;
  nombre!:any;
  timestamp_nacimiento!:any;
  reviews!:Review[];
  subscriptionNewUsers(){
    this.match.getNewMatchUsers().subscribe(
      u =>
      {
        if(u.length>=1){
          this.usuarios=u;
          this.contUser=0;
          this.imagen=this.usuarios[this.contUser].imagenes[0].imagen_src;
          this.nombre = this.usuarios[this.contUser].nombre;
          this.timestamp_nacimiento = this.usuarios[this.contUser].timestamp_nacimiento;
          this.reviews = this.usuarios[this.contUser].reviews;
          this.error="";
        }else{
          this.usuarios=[];
          this.contUser=0;
          this.imagen = "";
          this.nombre = "";
          this.timestamp_nacimiento = "";
          this.reviews = [];
          this.error="No hay más usuarios que mostrarte, vuelve más tarde";
        }
        
      }
    );
    
  }

  likeDislikeS(estado:number){
    this.subscribe=this.match.likeDislike(this.usuarios[this.contUser]["id"],estado).subscribe(s=>{
      if(this.usuarios.length>1){
        this.imagen=this.usuarios[this.contUser].imagenes[0].imagen_src;
        this.nombre = this.usuarios[this.contUser].nombre;
        this.timestamp_nacimiento = this.usuarios[this.contUser].timestamp_nacimiento;
        this.reviews = this.usuarios[this.contUser].reviews;
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
    });
  }

  ngOnInit(): void {
 
    this.subscriptionNewUsers();
   
    this.contUser=0;
  
    console.log(this.imagen);
    let to=this.token.getToken();
    let us=this.token.getUser();
    this.token.setReloadFalse();
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
    } else{
      this.usuarios=[];
    }
}
}
