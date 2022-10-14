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
import { environment } from 'src/environments/environment';
import { SliderButtonService } from 'src/app/core/shared/services/slider-button/slider-button.service';

@Component({
  selector: 'app-match',
  templateUrl: './match.component.html',
  styleUrls: ['./match.component.scss'],
})
export class MatchComponent implements OnInit {
  contUser!: number;
  constructor(
    private match: MatchService,
    private token: TokenStorageService,
    private router: Router,
    private cookieService: CookieService,
    private apiService: AuthService,
    private webSocketService: WebSocketService,
    private imagenService: ImagenesService,
    private serviceButton: SliderButtonService
  ) {}
  subscribe!: Subscription;
  error: string = 'No hay más usuarios que mostrarte, vuelve más tarde';
  usuarios!: Match[];
  imagen!: any;
  nombre!: any;
  timestamp_nacimiento!: any;
  bacio: any = false;
  configSlider: IImagenesComponentConfigAvanzada[] = [];
  subscriptionNewUsers() {
    this.match.getNewMatchUsers().subscribe((u) => {
      if (u.length >= 1) {
        this.usuarios = u;
        console.log('Usuarios:', this.usuarios);
        this.contUser = 0;
        this.imagen = [
          {
            imagen_id: 0,
            imagen_src: environment.imagenesBase + 'null.png',
          },
        ];
        if (
          this.usuarios[this.contUser].hasOwnProperty('imagenes') &&
          this.usuarios[this.contUser].imagenes.length > 0
        ) {
          this.imagen = this.usuarios[this.contUser].imagenes;
          console.log('Imagen actualizada dentro del if');
          console.log('imagen:', this.imagen);
        }
        this.nombre = this.usuarios[this.contUser].nombre;
        console.log('NOMBRE WEY:', this.nombre);
        this.timestamp_nacimiento =
          this.usuarios[this.contUser].timestamp_nacimiento;
        console.log('Fecha nacimiento:', this.timestamp_nacimiento);
        this.setConfigSlider();
        this.error = '';
      } else {
        this.usuarios = [];
        this.contUser = 0;
        this.imagen = '';
        this.nombre = '';
        this.timestamp_nacimiento = '';
        this.error = 'No hay más usuarios que mostrarte, vuelve más tarde';
      }
    });
  }

  setConfigSlider() {
    this.configSlider = [];
    for (let index = 0; index < this.imagen.length; index++) {
      let imagenA = this.imagen[index];
      if (imagenA.imagen_localizacion_donde_subida == 'Interno') {
        imagenA.imagen_src = environment.imagenesBase + imagenA.imagen_src;
      }
      console.log("THIS.imagen['index']:", this.imagen[index]);
      console.log('IMAGEN:', imagenA);
      let configIm = {
        type: 'slider-imagen',
        edad: this.timestamp_nacimiento,
        username: this.nombre,
        like_dislike_button: true,
        actived: true,
      };
      let configAvanzada = {
        config: configIm,
        img: imagenA,
      };
      this.configSlider.push(configAvanzada);
    }
    console.log('ConfigSlider:', this.configSlider);
  }

  likeDislikeS(estado: number) {
    if (this.usuarios.length > 1) {
      //alert("mayor que uno y usario.length:"+this.usuarios.length );
      this.subscribe = this.match
        .likeDislike(this.usuarios[this.contUser]['id'], estado)
        .subscribe((s) => {});
      this.removeItemFromArr(this.usuarios, this.usuarios[this.contUser]);

      this.imagen = [
        {
          imagen_id: 0,
          imagen_src: environment.imagenesBase + 'null.png',
        },
      ];
      if (this.usuarios[this.contUser].hasOwnProperty('imagenes')) {
        this.imagen = this.usuarios[this.contUser].imagenes;
        console.log('Imagen actualizada dentro del if');
      }
      if (this.usuarios[this.contUser].hasOwnProperty('reviews')) {
        this.serviceButton.reviews_estan_cargadas = true;
      } else {
        this.serviceButton.reviews_estan_cargadas = false;
      }

      this.nombre = this.usuarios[this.contUser].nombre;
      this.timestamp_nacimiento =
        this.usuarios[this.contUser].timestamp_nacimiento;
      this.setConfigSlider();
      this.error = '';
      //alert("salida mayor que uno usario.length:"+this.usuarios.length );
    } else if (this.usuarios.length == 1) {
      //alert("Uno y usario.length:"+this.usuarios.length );
      this.subscribe = this.match
        .likeDislike(this.usuarios[this.contUser]['id'], estado)
        .subscribe((s) => {});
      this.removeItemFromArr(this.usuarios, this.usuarios[this.contUser]);
      if (this.usuarios[this.contUser].hasOwnProperty('imagenes')) {
        this.imagen = this.usuarios[this.contUser].imagenes;
      }
      this.imagen = [
        {
          imagen_id: 0,
          imagen_src: '',
        },
      ];
      this.nombre = this.usuarios[this.contUser].nombre;
      this.timestamp_nacimiento =
        this.usuarios[this.contUser].timestamp_nacimiento;
      this.setConfigSlider();
      // this.contUser=this.contUser+1;
      //console.log(this.contUser);
      this.error = '';
      //alert("salida Uno y usario.length:"+this.usuarios.length );
    } else {
      this.subscriptionNewUsers();
      this.contUser = 0;
      this.usuarios = [];
      this.contUser = 0;
      this.imagen = '';
      this.nombre = '';
      this.timestamp_nacimiento = '';
      this.error = 'No hay más usuarios que mostrarte, vuelve más tarde';
    }
  }

  ngOnInit(): void {
    this.subscriptionNewUsers();

    this.imagenService.getImagenes();
    this.contUser = 0;

    console.log(this.imagen);
    let to = this.token.getToken();
    let us = this.token.getUser();

    let usuario = { token: '' };
    try {
      usuario = JSON.parse(this.cookieService.get('usuario')) ?? '';
    } catch (error) {}
    if (usuario.token != '' && this.token.getUser() && this.token.getToken()) {
      this.subscribe = this.apiService
        .autenticacion(usuario.token)
        .subscribe((usu) => {
          if (usu.error) {
            this.token.signOut();
            this.cookieService.delete('usuario');
            this.token.signOut();
            this.router.navigateByUrl('/');
          }
        });
    } else if (
      usuario.token == '' ||
      (!this.token.getUser() && !this.token.getToken())
    ) {
      this.token.signOut();
      this.router.navigateByUrl('/');
    }
    if (!this.token.getUser() && !this.token.getToken()) {
      this.token.signOut();
      this.router.navigateByUrl('/');
    }
  }

  //Recive por parametro si ha sido like o no
  //Si es like recive true si no false
  likeDislike(like: number) {
    this.imagen = this.usuarios[this.contUser].imagenes;
    this.nombre = this.usuarios[this.contUser].nombre;
    this.timestamp_nacimiento =
      this.usuarios[this.contUser].timestamp_nacimiento;
    this.setConfigSlider();
    this.removeItemFromArr(this.usuarios, this.usuarios[this.contUser]);
  }

  like() {
    this.likeDislikeS(1);
  }
  dislike() {
    this.likeDislikeS(2);
  }

  con() {
    return this.error === '';
  }
  //codigo sacado de http://www.etnassoft.com/2016/09/09/eliminar-un-elemento-de-un-array-en-javascript-metodos-mutables-e-inmutables/
  removeItemFromArr(arr: Match[], item: any) {
    var i = arr.indexOf(item);

    if (i !== -1) {
      arr.splice(i, 1);
      if (arr.length <= 1) {
        this.bacio = true;
      }
      if (arr.length <= 1) {
        this.usuarios = [];
      }
    } else {
      this.usuarios = [];
    }
  }
}
