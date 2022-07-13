<?php
namespace app\commands;

use app\models\Helper;
use app\models\Mach;
use app\models\Mensajes;
use app\models\Usuario;
use yii\console\Controller;
use yii\console\ExitCode;

class CommandsMatchController extends WebsocketController
{
   public static function findMatchById($id)
   {
        return Mach::find($id);
   }
    public static function actionGet_new_match_users_list($token){
        if($u=CommandsUsuarioController::getUserWhithAuthToken($token)){
            $m= new Mach();
            $m= $m->getUsersNoMostrados($u->id);
            $c=0;
      
            return $m;
        }
        return false;
    }
    
    /*
    *Este metodo devuelve  los matches de un usuario con  el token
     */
    public static function getMatches($token){
        $u=CommandsUsuarioController::getUserWhithAuthToken($token);
        if($u){
            return ["autenticacion"=>$u,"matches"=>Mach::getUserMatches($u->id)];
        }
        return ["autenticacion"=>false,"matches"=>null];;
    }

    /*
    *  Este metodo obtiene los matches del id de usuario que se haya pasado por parametro
    * @Params id:int
    */
    public static function getMatchesById($id){
        $u=CommandsUsuarioController::findUserWhithID($id);
        if($u){
            return ["autenticacion"=>$u,"matches"=>Mach::getUserMatches($u->id)];
        }
        return ["autenticacion"=>false,"matches"=>null];;
    }

    public static function getChatsYMatchesById($id){
        $matchesBd = self::getMatchesById($id);
        echo "\nMatches obtenidos";
        $u = $matchesBd["autenticacion"];
        $matchesBd = $matchesBd["matches"];
        $matchesDevolver = [];
        $chatsDevolver = [];
        if ($u && isset($matchesBd)){
            echo "\nDentro del if";
            foreach ($matchesBd as $match) {
                echo "\nEmpieza foreach";
             
                $mensajes=Mensajes::getMensajesByMatch($match["match_id"]);
                if($match["match_id_usu1"] == $u->id){
                    echo "\nEntra en el primer if";
                    $u2=Usuario::findIdentity($match["match_id_usu2"]);
                    $match["match_id_usu1"] = ["id"=>$u->id,"nombre"=>$u->nombre,"edad"=>Helper::calcularEdad($u->timestamp_nacimiento)];
                    $match["match_id_usu2"] = ["id"=>$u2->id,"nombre" => $u2->nombre,"edad"=>Helper::calcularEdad($u2->timestamp_nacimiento)];
                }else if($match["match_id_usu2"] == $u->id){
                    echo "\nEntra en el else if";
                    $u2=Usuario::findIdentity($match["match_id_usu1"]);
                    $match["match_id_usu1"] = ["id"=>$u->id,"nombre"=>$u->nombre,"edad"=>Helper::calcularEdad($u->timestamp_nacimiento)];
                    $match["match_id_usu2"] = ["id"=>$u2->id,"nombre" => $u2->nombre,"edad"=>Helper::calcularEdad($u2->timestamp_nacimiento)];
                    $estado_conexion = $match["estado_conexion_u1"];
                    $match["estado_conexion_u1"] = $match["estado_conexion_u2"];
                    $match["estado_conexion_u2"] = $estado_conexion;
                }
                
                //return ["Autentication"=>$u,"Matches"=>$matchesDevolver,"Chats"=>$chatsDevolver];
                if(sizeof($mensajes)>0){
                    echo "\nCHAT DEVOLVER AÑADIDO";
                   $match["mensajes"]=$mensajes;
                   $chatsDevolver[]=$match;
    
                }else{
                    echo "\nMatch DEVOLVER AÑADIDO";
                    $matchesDevolver[]=$match;
                }
            }
        }
  
        return["Autenticacion"=>$u,"Matches"=>$matchesDevolver,"Chats"=>$chatsDevolver];
    }

    public static function getChatsYMatches($token){
        $matchesBd = self::getMatches($token);
        echo "\nMatches obtenidos";
        $u = $matchesBd["autenticacion"];
        $matchesBd = $matchesBd["matches"];
        $matchesDevolver = [];
        $chatsDevolver = [];
        if ($u && isset($matchesBd)){
            echo "\nDentro del if";
            foreach ($matchesBd as $match) {
                echo "\nEmpieza foreach";

              
                $mensajes=CommandsMensajesController::getByMatch($match["match_id"],$u->id);
                //unset($match["match_id"]);
                if($match["match_id_usu1"] == $u->id){
                    echo "\nEntra en el primer if";
                    $u2=Usuario::findIdentity($match["match_id_usu2"]);
                    $match["match_id_usu1"] = ["id"=>$u->id,"nombre"=>$u->nombre,"edad"=>Helper::calcularEdad($u->timestamp_nacimiento)];
                    $match["match_id_usu2"] = ["id"=>$u2->id,"nombre" => $u2->nombre,"edad"=>Helper::calcularEdad($u2->timestamp_nacimiento)];
                }else if($match["match_id_usu2"] == $u->id){
                    echo "\nEntra en el else if";
                    $u2=Usuario::findIdentity($match["match_id_usu1"]);
                    $match["match_id_usu1"] = ["id"=>$u->id,"nombre"=>$u->nombre,"edad"=>Helper::calcularEdad($u->timestamp_nacimiento)];
                    $match["match_id_usu2"] = ["id"=>$u2->id,"nombre" => $u2->nombre,"edad"=>Helper::calcularEdad($u2->timestamp_nacimiento)];
                    $estado_conexion = $match["estado_conexion_u1"];
                    $match["estado_conexion_u1"] = $match["estado_conexion_u2"];
                    $match["estado_conexion_u2"] = $estado_conexion;
                }else{
                    echo"\nUsuario: ";
                    var_dump($u);
                    echo "\n \n u->id:";
                    var_dump($u->id);
    
                    echo"\n\nMatch_id_usu1:";
                    var_dump($match["match_id_usu1"]);
                    echo"\n Match_id_usu1 == u->id:";
                    var_dump($match["match_id_usu1"] == $u->id);
    
                    echo"\n \n Match_id_usu2:";
                    var_dump($match["match_id_usu2"]);
                    echo"\n Match_id_usu2 == u->id:";
                    var_dump($match["match_id_usu2"] == $u->id);
                }
                
                //return ["Autentication"=>$u,"Matches"=>$matchesDevolver,"Chats"=>$chatsDevolver];
                if(sizeof($mensajes)>0){
                    echo "\nCHAT DEVOLVER AÑADIDO";
                   $match["mensajes"]=$mensajes;
                   $chatsDevolver[]=$match;
    
                }else{
                    echo "\nMatch DEVOLVER AÑADIDO";
                    $matchesDevolver[]=$match;
                }
            }
        }

        
        return["Autenticacion"=>$u,"Matches"=>$matchesDevolver,"Chats"=>$chatsDevolver];
    }

    /*
    *Obtiene un match por su id
    */
    public static function getMatch($id)
    {
        return Mach::getMatch($id);
    }

    /*
	*Encuentra el otro usuario de un chat pasandole el token del usuario que lo envia y el match_id del mensaje
	*/
    public static function findUsuario2ByMatch($token,$match_id)
    {
        echo "\nfindUsuario dentro";
        $u=CommandsUsuarioController::getUserWhithAuthToken($token);
       
        $match=static::getMatch($match_id);
        if($u){
           echo "\n u ya entro en ifema";
           $u2=$match->match_id_usu2;
           if($match->match_id_usu2==$u->id){
            echo "\n segundo";
            $u2=$match->match_id_usu1;
           }
          $u2=Usuario::findIdentity($u2);
          return ["autenticacion"=>$u,"usuario2"=>$u2,"match"=>$match];
        }
        return ["autenticacion"=>false,"usuario2"=>null];
    }


}