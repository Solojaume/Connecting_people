/**
 * --------------------------------------
 * Importamos los paquetes necesarios "ngx-socket-io" tambien nuestro "environments" y por último
 * "ngx-cookie-service",
 * ----------------------------------------
 */
import { environment } from 'src/environments/environment';
import { Injectable, EventEmitter, Output } from '@angular/core';
import { Socket, SocketIoConfig } from 'ngx-socket-io';
import { TokenStorageService } from '../../../token-storage/token-storage.service';
import { Match } from 'src/app/core/models/chat/Match';
import { UsuarioChat } from 'src/app/core/models/chat/usuario_chat';
import { MensajeModel } from 'src/app/core/models/mensaje.model';
import { Observable } from 'rxjs';
import { interval, } from 'rxjs';


const config: SocketIoConfig = {
  url: environment.serverSocket,
  options: {
    // reconnectionDelay:1500,
    reconnectionDelayMax: 15000,
    reconnection: true,
    //autoConnect:false
  },
};
const AUTH_KEY = 'autenticacion';

@Injectable({
  providedIn: 'root',
})

/**
 * Extendemos la clase "Socket" a nuestra clase
 */
export class WebSocketIOService extends Socket {
  /**
   * Declaramos un metodo de emitir el cual llamaremos "outEven"
   */
  @Output() outEven: EventEmitter<any> = new EventEmitter();
  public matches: Match[] = [];
  private usuarios: UsuarioChat[] = [];
  public mensajes: [MensajeModel[]] = [
    [new MensajeModel(0, 'mi ', 0, 0, 0, 'putita', '20-00-20000')],
  ];
  public mensajes_public: MensajeModel[] = [];
  public mensajes_count: number = 0;
  public matches_public: Match[] = [];
  public chats: Match[] = [];
  public chatUsar: any = 'blanco';
  public subscription!: any;
  public pagina_Actual: string = 'match';
  public hay_cambios: boolean = false;
  private logueado: boolean = false;
  /**
   * En nuestro constructor injectamos el "CookieService" para luego hacer uso de sus metodos.
   */
  constructor(private token: TokenStorageService) {
    /**
     *  En nuestro "super" declaramos la configuración inicial de conexión la cual hemos declarado en nuestro
     *  "environment.serverSocket",
     *  tambien vemos como pasamos el "payload" dentro de options y "query"
     */

    super(config);

    //Mostramos url a la que nos conectamos
    console.log(environment.serverSocket);

    /**
     * ---------------- ESCUCHAMOS----------------
     * En este punto nuestro socket.io-client esta listo para recibir los eventos.
     *
     * En esta funcion vemos como esta preparado para recibir un evento llamado "message" el cual
     * una vez sea recibido va a emitir por nuestro "outEven"
     */
    //EJEMPLO
    //this.ioSocket.on('connecting', res =>function(){ this.outEven.emit(res)});

    // Conectando
    this.ioSocket.on('connecting', () => {
      console.log('connecting');
    });

    // Conectar
    this.ioSocket.on('connect', (cookieService = this.token) => {
      let v = cookieService.getUser();
      if (typeof v.token) {
        console.log('Conectado');
        this.ioSocket.emit('new user', v.token);
      }
    });

    // Inicie sesión por primera vez para recibir información de otros usuarios
    this.ioSocket.on(
      'login',
      (user: {
        matches: Match[];
        mensajes: [MensajeModel[]];
        usuarios: UsuarioChat[];
        mensajes_count: number;
      }) => {
        console.log('user:', user);
        this.usuarios = user.usuarios;
        console.log('usuarios:', this.usuarios);
        this.mensajes = user.mensajes;
        this.matches = user.matches;
        this.mensajes_count = user.mensajes_count;
        this.logueado = true;
        this.modify_conection_status();
        //this.getNewMatches();
      }
    );

    // Esta escriviendo otro usuario
    this.ioSocket.on(
      'typing',
      (data: { match_id: number; id_usu_send: number; id_usu2: number }) => {
        this.updateTyping(data);
      }
    );

    // Deja de escrivir otro usuario
    this.ioSocket.on(
      'stop typing',
      (data: { match_id: number; id_usu_send: number; id_usu2: number }) => {
        this.updateTyping(data, 'Conectado');
      }
    );

    // Se ha unido un nuevo usuario
    this.ioSocket.on(
      'user joined',
      (tname: { usuarios: any; count: number }) => {
        //this.usuarios.push(tname);
        //incomeHtml(tname,'src/img/head.jpg');
        console.log('user joined:', tname);
        this.usuarios = tname.usuarios;

        this.modify_conection_status();
      }
    );

    // Recibir mensajes de chat privados
    this.ioSocket.on('receive private message', (mensaje: any) => {
      console.log('Mensaje recivido:', mensaje);
      let u = this.token.getToken();

      let pos = this.findMatch(new Match(mensaje.match_id, 'e', '2', u, u, ''));

      if (this.chatUsar.match_id != this.matches[pos].match_id) {
        this.matches[pos].match_count_no_leidos =
          this.matches[pos].match_count_no_leidos + 1;
      }
      this.mensajes[pos].push(mensaje);
      if (this.pagina_Actual != 'chat') {
        this.hay_cambios = true;
      }
    });

    // Miembro abandonado en medio de la supervisión
    this.ioSocket.on('user left', (tname: UsuarioChat[]) => {
      console.log('se desconecto:', tname);
      this.usuarios = tname;

      this.modify_conection_status();
    });

    this.ioSocket.on(
      'update chats',
      (user: {
        matches: Match[];
        mensajes: [MensajeModel[]];
        mensajes_count: number;
      }) => {
        let oldMatches: Match[] = this.matches;
        this.matches = user.matches;
        this.mensajes = user.mensajes;
        let ultimoMatchIdAntiguo = 0;
        let ultimoMatchIdNuevo = 0;
        try {
          ultimoMatchIdAntiguo = oldMatches[oldMatches.length - 1].match_id;
          ultimoMatchIdNuevo = this.matches[this.matches.length - 1].match_id;
        } catch (error) { }

        if (oldMatches.length === this.matches.length) {
          for (let index = 0; index < oldMatches.length; index++) {
            const old = oldMatches[index];
            const newM = this.matches[index];
            //______________ Debug ________________________
            /*
            console.log("Old:",old);
            console.log("NEW:",newM);
            */
            if (old.match_count_no_leidos > 0) {
              newM.match_count_no_leidos = old.match_count_no_leidos;
            }
            this.matches[index] = newM;
          }
        } else if (
          this.matches.length > oldMatches.length &&
          ultimoMatchIdNuevo > ultimoMatchIdAntiguo
        ) {
          if (this.pagina_Actual != 'chat') {
            this.hay_cambios = true;
          }
          for (let index = 0; index < oldMatches.length; index++) {
            const old = oldMatches[index];
            const newM = this.matches[index];
            //______________ Debug ________________________
            /*
            console.log("Old:",old);
            console.log("NEW:",newM);
            */
            if (
              old.match_id === newM.match_id &&
              old.match_count_no_leidos > 0
            ) {
              console.log('NEW:', newM);

              newM.match_count_no_leidos = old.match_count_no_leidos;
              this.matches[index] = newM;
            }
          }
        } else {
          this.matches = user.matches;
          this.mensajes = user.mensajes;
          this.chatUsar = this.matches[0];
          this.chatUsar.match_position = 0;
        }

        this.mensajes_count = user.mensajes_count;

        this.modify_conection_status();
      }
    );

    // La conexión falló
    this.ioSocket.on('disconnect', () => {
      this.usuarios = [];
      this.matches = [];
      this.setAutenticadoFalse();
      this.logueado = false;
      this.usuarios = [];
     
      //alert("se desconecto");
      console.log('you have been disconnected');
      this.modify_conection_status();
    });

    // reconexión
    this.ioSocket.on('reconnect', (cookieService = this.token) => {
      if (this.logueado === false) {
        let v = token.getUser();
        if (typeof v.token) {
          console.log('Conectado');
          this.ioSocket.emit('new user', v.token);
        }
      }
    });

    // La escucha de errores de reconexión se intentará varias veces
    this.ioSocket.on('reconnect_error', () => {
      console.log('attempt to reconnect has failed');
    });

    this.ioSocket.on('connect_error', (err: any) => {
      console.log(err instanceof Error); // true
      console.log(err.message); // not authorized
      console.log(err.data); // { content: "Please retry later" }
      //this.token.signOut();
      // this.token.setReloadFalse();
      //this.router.navigateByUrl('/');
    });

    this.ioSocket.on('', (err: any) => { });
  }

  /**
   * ---------------- EMITIR-------------------
   * Ahora solo nos falta poder emitir mensajes, para ello declaramos la funcion
   * "emitEvent" la cual va ser disparada por un "(click)" la cual emite un envento
   * con el nombre "default", y un payload de información el cual sera parseado
   * por nuestro backend.
   */

  emitEvent = (event = 'default', payload: any = {}) => {
    console.log('Event:', event);
    console.log('emitiendo:', payload);
    this.ioSocket.emit(event, payload);
  };

  /*
   * ---------------- CERRAR CONEXION -----------------
   * Este metodo emitira el evento "disconnect-by-token", una vez recivido este por el servidor nos desconectará.
   * Se utilizara principalmente para cerrar sesion cuando le damos al boton logout.
   */
  close() {
    this.emitEvent('disconnect-by-token', this.token.getToken());
  }

  /**
   * ---------------- Conectarse ------------------------
   * Dado que he configurado el socket para que no se conecte nada más se genere,
   * tenemos que crear un metodo que conecte el socket y que podremos llamar en cualquier
   * lugar donde este importado este servicio
   */
  conectase_a_websocket() {
    this.connect();
    this.setAutenticadoTrue();
  }

  /*
   *Este metodo modifica  el estado de conexion de los matches
   */
  modify_conection_status() {
    //Ante for - parte1
    this.matches_public = [];
    this.chats = [];

    //Parte 2 - For 1
    for (let index = 0; index < this.matches.length; index++) {
      const match = this.matches[index];

      console.log('Match sin modificar:', match);
      let match_usu2 = match['match_id_usu2'];
      console.log("Match2", match_usu2);
      //Parte 3
      if (this.get_if_user_is_conected(match_usu2)) {
        match['estado_conexion_u2'] = 'Conectado';
      } else {
        match['estado_conexion_u2'] = 'Desconectado';
      }

      this.matches[index].match_position = index;
      if (this.matches[index].match_count_no_leidos > 0) {
        this.matches[index].match_count_no_leidos =
          this.matches[index].match_count_no_leidos;
      } else {
        this.matches[index].match_count_no_leidos = 0;
      }

      //Parte 4 - Pre for 2 y For2

      const lista_mensajes_por_match = this.mensajes[index];
      if (lista_mensajes_por_match.length > 0) {
        this.chats.push(match);
      } else {
        this.matches_public.push(match);
      }

      console.log('Match modificado:', match);
    }
  }

  /**
   * ------ Find encontrar match ------
   *  @param match
   *  @returns num
   */
  findMatch(match: Match) {
    let count = this.matches.length;
    for (let index = 0; index < count; index++) {
      const m2 = this.matches[index].match_id;
      if (match.match_id == m2) {
        return index;
      }
    }
    return -1;
  }

  /**
   * ------ Cambiar estado match ------
   *  @param match
   *  @returns
   */
  updateTyping(
    data: {
      match_id: number;
      id_usu_send: number;
      id_usu2: number;
    },
    status = 'Escriviendo'
  ) {
    let u = this.token.getToken();
    console.log('user typing:', data);

    let mp = this.findMatch(new Match(data.match_id, 'e', '2', u, u, ''));
    console.log('mp:', mp);
    this.matches[mp].estado_conexion_u2 = status;
    console.log('Matches:', this.matches);
  }

  /**
   *Este metodo sirve para consultar en la lista usuarios si el usuario pasado por parametros existe en dicha lista
   * @param usu *
   * @returns
   */
  get_if_user_is_conected(usu: UsuarioChat) {
    console.log("USUARIOS:::::", this.usuarios)
    for (let index = 0; index < this.usuarios.length; index++) {
      let usuario = this.usuarios[index];
      if (usu.id == usuario.id && usu.edad == usuario.edad) {
        return true;
      }
    }
    return false;
  }

  obtenerNuevosMatch: Observable<any> = interval(
    environment.intervalo_tiempo_reescaneo_chat_match
  );

  public setPage(pagina_ActualParam: string = 'match') {
    this.pagina_Actual = pagina_ActualParam;
    if (pagina_ActualParam == 'chat') {
      this.hay_cambios = false;
    }
  }

  public escriviendo: boolean = false;
  //SIrve para empezar a preguntarle al servidor si hay nuevos matches
  public getNewMatches() {
    if (this.subscription == null) {

      this.subscription = this.obtenerNuevosMatch.subscribe(() => {
        if (this.escriviendo === false && this.logueado === true) {
          this.emitEvent('update lista match', this.token.getUser());
        } else {
          let v = this.token.getUser();
          if (typeof v.token) {
            this.ioSocket.emit('new user', v.token);
          }
        }
      });
    } else {
      console.log('Ya existe suscripcion');
    }
  }

  private setAutenticadoTrue() {
    window.sessionStorage.removeItem(AUTH_KEY);
    window.sessionStorage.setItem(AUTH_KEY, 'true');
  }

  public setAutenticadoFalse() {
    window.sessionStorage.removeItem(AUTH_KEY);
    window.sessionStorage.setItem(AUTH_KEY, 'false');
  }

  public getAutenticado() {
    return window.sessionStorage.getItem(AUTH_KEY);
  }

  marcadoParaCerrar = false;

  /**
   * ___________________ Close Subscrition _______________________
   * Sirve para cerrar la subscripción encargada de consultar los nuevos matches
   */
  public closeSubscription() {
    if (this.marcadoParaCerrar === true) {
      this.subscription.unsubscribe();
      this.marcadoParaCerrar = false;
    } else {
      this.marcadoParaCerrar = true;
    }
  }
}
