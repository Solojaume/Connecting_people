<?php

namespace app\commands;

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
    public static function auth($token,$ip_cliente="",$puerto_cliente="",$ip_servidor="",$puerto_servidor="",$socket=null )
    {
       
		if(isset($socket)){

        }
		//echo "\n ip ser";
       // var_dump($ip_cliente);
        $u=self::getUserWhithAuthToken($token);
        $u->ip_cliente = $ip_cliente;
        $u->puerto_cliente = "".$puerto_cliente;
        $u->ip_servidor = $ip_servidor;
        $u->puerto_servidor = "".$puerto_servidor;
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
        }else{

        }
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
    */
    public static function findSocketById($arraySocket,$id)
    {
        $u = Usuario::findIdentity($id);
        foreach ($arraySocket as $arraySocketResource) {
            socket_getpeername($arraySocketResource,$ip_c, $p_c);

            //Obtenemos la ip local y su puerto
            socket_getpeername($arraySocketResource,$ip_s,$p_s);
            if($u->ip_servidor==$ip_s && $u->ip_client==$ip_c && $u->puerto_cliente="".$p_c && $u->puerto_servidor=="".$p_s){
                return $arraySocketResource;
            }
        }
        return false;
    }
    /*
    * Este metodo sirve para borrar el socket de la base de datos
    */
    public static function CerrarConexion($socket)
    {
        //Obtenemos ip remota y su puerto
		socket_getpeername($socket,$ip_c, $p_c);

		//Obtenemos la ip local y su puerto
		socket_getpeername($socket,$ip_s,$p_s);

        $u=Usuario::findIdentityBySocket("'$ip_c'","'$ip_s'","'$p_c'","'$p_s'");
        
        //$u=Usuario::findIdentity($u[0]["id"]);
        echo"\n FindIdentityBySocket";
        var_dump($u);
        var_dump($ip_c);
        var_dump($ip_s);
        var_dump($p_c);
        var_dump($p_s);
        

        /*
        $u->ip_cliente = "";
        $u->puerto_cliente = "";
        $u->ip_servidor = "";
        $u->puerto_servidor = "";
        $u->save();
        */
    }
}
