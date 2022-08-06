
/**
 * --------------------------------------
 * Importamos los paquetes necesarios "ngx-socket-io" tambien nuestro "environments" y por último
 * "ngx-cookie-service",
 * ----------------------------------------
*/
import { environment } from 'src/environments/environment';
import { CookieService } from 'ngx-cookie-service';
import { Injectable, EventEmitter, Output} from "@angular/core";
import { Socket } from 'ngx-socket-io';
import { TokenStorageService } from '../../../token-storage/token-storage.service';
import { Match } from 'src/app/core/models/chat/Match';

@Injectable({
    providedIn: 'root'
})

/**
 * Extendemos la clase "Socket" a nuestra clase
 */
export class WebSocketIOService extends Socket { 
   
/**
 * Declaramos un metodo de emitir el cual llamaremos "outEven"
 */
@Output() outEven: EventEmitter<any> = new EventEmitter(); 
public matches:Match[]=[];
public usuarios:[]=[];
public mensajes:{}={};
public mensajes_count:number=0;
/**
 * En nuestro constructor injectamos el "CookieService" para luego hacer uso de sus metodos.
 */
    constructor(private token: TokenStorageService) {

        /**
         * En nuestro "super" declaramos la configuración inicial de conexión la cual hemos declarado en nuestro
         * "environment.serverSocket",
         * tambien vemos como pasamos el "payload" dentro de options y "query"
         */

        super({
            url: environment.serverSocket,
        });
        
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
        this.ioSocket.on('connecting',()=>{console.log('connecting'); });

       

        // Conectar
        this.ioSocket.on('connect', (cookieService=this.token)=>
            { 
                let v = cookieService.getUser();
                console.log("usuario:",v);
                console.log("usuario nombre:",v.nombre);
                console.log("usuario token:",v.token);

                if(typeof(v.token)){
                    console.log("Conectado");
                    this.ioSocket.emit("new user",v.token);
                }
            }
        );


        // Inicie sesión por primera vez para recibir información de otros usuarios
        this.ioSocket.on('login',( user:{matches: Match[], mensajes: [], usuarios:[], mensajes_count:number})=>{ 
            console.log("user:",user);
            this.usuarios=user.usuarios;
            console.log("usuarios:",this.usuarios)
            this.mensajes = user.mensajes;
            this.matches = user.matches;
            this.mensajes_count = user.mensajes_count;
            this.matches.forEach(match => {
                console.log("Match:",match);
                let propiedad="id_"+match["match_id_usu2"]["id"];
                if(this.usuarios.hasOwnProperty(propiedad)){
                    match["estado_conexion_u2"]="Conectado";
                }
                else{
                    match["estado_conexion_u2"]="Desconectado";

                }
                
            });
        });
       


        // Se ha unido un nuevo usuario
        this.ioSocket.on('user joined', (tname:{usuarios:any,count:number}) =>{
            //this.usuarios.push(tname);
            //incomeHtml(tname,'src/img/head.jpg');
            console.log("user joined:",tname);
            //this.usuarios.push(0);
            this.usuarios=tname.usuarios;
            this.matches.forEach(match => {
                console.log("Match:",match);
                let propiedad="id_"+match["match_id_usu2"]["id"];
                if(this.usuarios.hasOwnProperty(propiedad)){
                    match["estado_conexion_u2"]="Conectado";
                }
                else{
                    match["estado_conexion_u2"]="Desconectado";

                }
                
            });
        });
       
        // Recibir mensajes de chat privados
        this.ioSocket.on('receive private message', (mensaje:string) =>{ 
            //this.mensajes.push(mensaje)
        });
        /*
        socket.on('receive private message', function (data) {
            $('#ding')[0].play();
            if(data.addresser == data.recipient) return;
            var head = 'src/img/head.jpg';
            $('#'+hex_md5(data.addresser)+' .chat-msg').append('<li><img src="'+head+'"><span class="speak">'+data.body+'</span></li>');
            if(document.hidden){
                showNotice(head,data.addresser,data.body);
            }
            scrollToBottom(hex_md5(data.addresser));
        });
        */
        // Miembro abandonado en medio de la supervisión
        this.ioSocket.on('user left', (data:string) => {           
            console.log(data+'se desconecto');
            if(data in this.usuarios){
               //this.usuarios.slice(this.usuarios.indexOf(data),this.usuarios.indexOf(data))
            }
        });

        

        // La conexión falló
        this.ioSocket.on('disconnect', () => { 
            this.usuarios=[];
            this.matches=[];
            console.log('you have been disconnected');
        });

       

        // reconexión
        this.ioSocket.on('reconnect', () => { 
            console.log('you have been reconnected');
        });

        // La escucha de errores de reconexión se intentará varias veces
        this.ioSocket.on('reconnect_error', () => {             
            console.log('attempt to reconnect has failed');
        });

    }

    /**
     * ---------------- EMITIR-------------------
     * Ahora solo nos falta poder emitir mensajes, para ello declaramos la funcion
     * "emitEvent" la cual va ser disparada por un "(click)" la cual emite un envento
     * con el nombre "default", y un payload de información el cual sera parseado 
     * por nuestro backend.
     */

    emitEvent = (event = 'default',payload:any= {}) => {
        console.log('emitiendo')
        this.ioSocket.emit(event, payload);
    }

    close(){
        this.emitEvent("disconnect", this.token.getToken())
    }


}