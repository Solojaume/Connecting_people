<?php

namespace app\controllers;
use app\models\Usuario;
use yii\console\Controller;
use yii\console\ExitCode;

class   CommandsUsuarioController extends WebsocketController
{
     /**
     * Este metodo devuelve el usuario si el token es correcto
     * @param string $token esta es la variable que tiene el tpken
     * @param string $ip Esta es la ip local del servidor
     * @param string $puerto
     * @param soket $soket
     * @return usuario 
     */
    public static function auth($token,$socket=null )
    {
        $u=self::getUserWhithAuthToken($token);
		if(isset($socket)){
            //Obtenemos ip remota y su puerto
            socket_getpeername($socket,$ip_cliente, $puerto_cliente);

            //Obtenemos la ip local y su puerto
            socket_getpeername($socket,$ip_servidor,$puerto_servidor);
            $u->ip_cliente = $ip_cliente;
            $u->puerto_cliente = "".$puerto_cliente;
            $u->ip_servidor = $ip_servidor;
            $u->puerto_servidor = "".$puerto_servidor;
        }
		//echo "\n ip ser";
       // var_dump($ip_cliente);
       
        /*
        echo"\n var dump usu  u->save()";
        var_dump($u->save());
        echo"\n var dump usu==true ";
        var_dump($u==true);
        */
        if($u==true){
            if($u->save());
                return $u;
            echo "primer if";
            return false;
        }else{
            return false;
            echo "O hay un else";
        }
       
    }
    /*
    *Este metodo obtiene un usuario por su id
    */
    public static function findUserWhithID( $id = null)
    {
        return Usuario::findIdentity($id);
    }

    /*
    *
    *
    */
    public static function getUserWhithAuthToken($token)
    {
        $u=Usuario::findIdentityByAccessToken($token);
        $con=$u->token==$token;
        $con2=$u->validateCaducityDateAuthToken()==true;
        if($con&&$con2){
            return $u;
        }
        return false;
    }

    public static function DesconectarPorToken($token,&$chathandler)
    {
        $u = self::getUserWhithAuthToken($token);
        $u->ip_cliente = "";
        $u->puerto_cliente = "";
        $u->ip_servidor = "";
        $u->puerto_servidor = "";
        if($u->save()){
            return $chathandler->seal(json_encode(["chat_user"=>"system",'chat_message'=>"cerrada correctamente",'message_type'=>'auth_error']));
        }
        return false;
    }

    /*
    *Este metodo devuelve el objeto socket al que esta conectado un usuario
    @params $arraySocket:array
    @params $id: number
    */
    public static function findSocketById($arraySocket,$id)
    {
        $u = Usuario::findIdentity($id);
        return self::findSocketByUsuario($arraySocket,$u);
        
    }


    public static function findSocketByUsuario(&$arraySocket,$u,&$newArraySocket=null)
    {
        echo"\n findSocketByUsuario";
        echo"\nVar_dump arraySocket";
        var_dump($arraySocket);
         
        
        foreach ($arraySocket as $arraySocketResource) {
            var_dump($arraySocketResource);
            echo "\nEntra foreach";
            try {
                socket_getpeername($arraySocketResource,$ip_c, $p_c);
                echo "\nIP Cliente:$ip_c ";
                var_dump($ip_c);
                echo"\nPuerto Cliente:$p_c";
                $p_c="".$p_c;
                var_dump($p_c);
                //Obtenemos la ip local y su puerto
                socket_getpeername($arraySocketResource,$ip_s,$p_s);
                echo "\nIP Servidor:$ip_s";
                $p_s="".$p_s;
                var_dump($ip_s);
                echo"\nPuerto Servidor:$p_s";
                var_dump($p_s);

                if($u->ip_servidor==$ip_s && $u->ip_client==$ip_c && $u->puerto_cliente=$p_c && $u->puerto_servidor==$p_s){
                    echo"\n Entra en el if";
                    return $arraySocketResource;
                }
               
            } catch (\Throwable $th) {
                echo"\nPeta elsocket\n\n";
                echo "falló socket_select(), razón: " .
                socket_strerror(socket_last_error()) . "\n";
                
            }
        }

        foreach ($newArraySocket as $arraySocketResource) {
            var_dump($arraySocketResource);
            echo "\nEntra foreach segundo";
            try {
                socket_getpeername($arraySocketResource,$ip_c, $p_c);
                echo "\nIP Cliente:$ip_c ";
                var_dump($ip_c);
                echo"\nPuerto Cliente:$p_c";
                $p_c="".$p_c;
                var_dump($p_c);
                //Obtenemos la ip local y su puerto
                socket_getpeername($arraySocketResource,$ip_s,$p_s);
                echo "\nIP Servidor:$ip_s";
                $p_s="".$p_s;
                var_dump($ip_s);
                echo"\nPuerto Servidor:$p_s";
                var_dump($p_s);

                if($u->ip_servidor==$ip_s && $u->ip_client==$ip_c && $u->puerto_cliente=$p_c && $u->puerto_servidor==$p_s){
                    echo"\n Entra en el if";
                    return $arraySocketResource;
                }
               
            } catch (\Throwable $th) {
                echo"\nPeta elsocket\n\n";
                echo "falló socket_select(), razón: " .
                socket_strerror(socket_last_error()) . "\n";
                
            }
        }
        return false;
    }

    /*
    *Este es el metodo sirve para obtener el usuario con el socket
    */
    public static function findUsuarioBySocket($socket = null)
    {
        echo "\nEntramos en findUsuarioBySocket";
        socket_getpeername($socket,$ip_c, $p_c);

		//Obtenemos la ip local y su puerto
		socket_getpeername($socket,$ip_s,$p_s);
        echo "\nPre findBySocket";
        $u=Usuario::findIdentityBySocket("'$ip_c'","'$ip_s'","'$p_c'","'$p_s'");
      //  $u = Usuario::findIdentityByAccessToken($u["token"]);
        return $u;
    }

    
}
