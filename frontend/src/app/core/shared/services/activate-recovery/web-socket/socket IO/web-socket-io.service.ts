
/**
 * --------------------------------------
 * Importamos los paquetes necesarios "ngx-socket-io" tambien nuestro "environments" y por último
 * "ngx-cookie-service",
 * ----------------------------------------
*/
import { environment } from 'src/environments/environment';
import { CookieService } from 'ngx-cookie-service';
import { Injectable, EventEmitter, Output} from "@angular/core";
import { Socket, SocketIoConfig } from 'ngx-socket-io';
import { TokenStorageService } from '../../../token-storage/token-storage.service';
import { Match } from 'src/app/core/models/chat/Match';
import { UsuarioChat } from 'src/app/core/models/chat/usuario_chat';
import { MensajeModel } from 'src/app/core/models/mensaje.model';

const config: SocketIoConfig = { 
    url: environment.serverSocket, 
    options: {
       // reconnectionDelay:1500,
        reconnectionDelayMax:15000,
        reconnection:true,
        //autoConnect:false
    } 
};
const AUTH_KEY = 'autenticacion';

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
    private matches:Match[]=[];
    private usuarios:UsuarioChat[]=[];
    private mensajes:[MensajeModel[]]=[[new MensajeModel(0,"mi ",0,0,0,"putita","20-00-20000")]];
    public mensajes_public:MensajeModel[] = [];
    public mensajes_count:number=0;
    public matches_public:Match[]=[];
    public chats:Match[]=[];
    public chatUsar!:any;
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
        this.ioSocket.on('login',( user:{matches: Match[], mensajes: [MensajeModel[]], usuarios:UsuarioChat[], mensajes_count:number})=>{ 
            console.log("user:",user);
            this.usuarios=user.usuarios;
            console.log("usuarios:",this.usuarios)
            this.mensajes = user.mensajes;
            this.matches = user.matches;
            this.mensajes_count = user.mensajes_count;
           
            this.modify_conection_status();
        });
       


        // Se ha unido un nuevo usuario
        this.ioSocket.on('user joined', (tname:{usuarios:any,count:number}) =>{
            //this.usuarios.push(tname);
            //incomeHtml(tname,'src/img/head.jpg');
            console.log("user joined:",tname);
            this.usuarios=tname.usuarios;
            
            this.modify_conection_status();
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
        this.ioSocket.on('user left', (tname:UsuarioChat[]) => {           
            console.log('se desconecto:',tname);
            this.usuarios=tname;
            
            this.modify_conection_status();
        });

        

        // La conexión falló
        this.ioSocket.on('disconnect', () => { 
            this.usuarios=[];
            this.matches=[];
            this.setAutenticadoFalse();
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

    /*
    * ---------------- CERRAR CONEXION -----------------
    * Este metodo emitira el evento "disconnect-by-token", una vez recivido este por el servidor nos desconectará.
    * Se utilizara principalmente para cerrar sesion cuando le damos al boton logout.
     */
    close(){
        this.emitEvent("disconnect-by-token", this.token.getToken())
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
    modify_conection_status(){
        this.matches_public=[];
        this.chats=[];
        this.matches.forEach(match => {
            console.log("Match sin modificar:",match);
            let match_usu2=match["match_id_usu2"];
            
            if(this.get_if_user_is_conected(match_usu2)){
                match["estado_conexion_u2"]="Conectado";
            }
            else{
                match["estado_conexion_u2"]="Desconectado";

            }
            let count=0;

            for (let index = 0; index < this.mensajes.length; index++) {
                const lista_mensajes_por_match=this.mensajes[index];
                for (let index2 = 0; index2 < lista_mensajes_por_match.length; index2++) {
                    const mensaje2 = lista_mensajes_por_match[index2];
                    console.log("MENSAJE2",mensaje2);
                    if (mensaje2.match_id==match["match_id"]) {
                        count++;  
                        this.mensajes_public.push(mensaje2);  
                    }
                    
                }
                
            }
          
            if(count>0){
                this.chats.push(match);
            } else{
                this.matches_public.push(match);
            }
            console.log("Match modificado:",match);
        });
    }
    /*
    *Este metodo sirve para consultar en la lista usuarios si el usuario pasado por parametros existe en dicha lista
    */
    get_if_user_is_conected(usu:UsuarioChat){
        for (let index = 0; index < this.usuarios.length; index++) {
            let usuario = this.usuarios[index];
            if(usu.id == usuario.id && usu.edad == usuario.edad ){
                return true;
            }
            
        }
        return false;
    }

    private setAutenticadoTrue() {
        window.sessionStorage.removeItem(AUTH_KEY);
        window.sessionStorage.setItem(AUTH_KEY, "true");
    }
    
    public setAutenticadoFalse(){
        window.sessionStorage.removeItem(AUTH_KEY);
        window.sessionStorage.setItem(AUTH_KEY, "false");
    }
      
    public getAutenticado(){
        return window.sessionStorage.getItem(AUTH_KEY);
    }
}