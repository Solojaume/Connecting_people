import { Component, OnInit, OnDestroy } from '@angular/core';
import { Router } from '@angular/router';
import { CookieService } from 'ngx-cookie-service';
import { Subscription } from 'rxjs';
import { AuthService } from '../core/shared/services/auth/auth.service';
import { TokenStorageService } from '../core/shared/services/token-storage/token-storage.service';
import { WebSocketService } from '../core/shared/services/activate-recovery/web-socket/web-socket.service';
import { WebSocketIOService } from '../core/shared/services/activate-recovery/web-socket/socket IO/web-socket-io.service';
import { ImagenesService } from '../core/shared/services/imagenes/imagenes.service';
import { Imagen } from '../core/models/imagen';
import { ImagenClass } from '../core/models/imagenClass';
import { environment } from 'src/environments/environment';
import { AspectoService } from '../core/shared/services/hacer_review/aspecto.service';

@Component({
  selector: 'app-intranet',
  templateUrl: './intranet.component.html',
  styleUrls: ['./intranet.component.scss']
})
export class IntranetComponent implements OnInit,OnDestroy {

  constructor( 
    private token:TokenStorageService, 
    public router:Router,
    private cookieService:CookieService, 
    private apiService:AuthService,
    public webSocketService:WebSocketService,
    public socketService:WebSocketIOService,
    private imagenService:ImagenesService, 
    private aspectoS:AspectoService
  ) {

    aspectoS.obtenerAspetos();
   }
  ngOnDestroy(): void {
    //this.socketService.closeSubscription();
    //this.router.navigateByUrl("/");
  }
  subscribe!:Subscription ;
  error:string="";

  
  
  ngOnInit(): void {
    //alert(this.router.url);
    this.socketService.getNewMatches();
    this.imagenService.getImagenesDelServer().subscribe(
      (img:Imagen[])=>{
        this.imagenService.imagenes=img;
        this.imagenService.imagenes.forEach((o:Imagen)=>{
          if(o.imagen_localizacion_donde_subida=="Interno"){
            o.imagen_src = environment.imagenesBase + o.imagen_src;
          }
        });
        this.imagenService.imgSRC=img[0];
        let count = this.imagenService.imagenes.length;
        if(count<8){
          let rest = 8-count;
          for (let index = 0; index < rest; index++) {
            this.imagenService.imagenes.push(new ImagenClass(-1,undefined,"",0));
            
          }
        }

        console.log("Imagen:",this.imagenService.imagenes);
      }
    );
    if(this.token.getReload()=="false"||!this.token.getReload()) {
      this.token.setReloadTrue();
      window.location.reload();

    }
    
    //this.webSocketService.openWebSocket();  
  }
  
  logout(){
    this.socketService.close();
    this.cookieService.delete("usuario");
    this.token.signOut();
    this.token.setReloadFalse();
    this.router.navigateByUrl("/");
    console.log(this.socketService.subscription);
    this.socketService.subscription.unsubscribe();

  }
  
}
