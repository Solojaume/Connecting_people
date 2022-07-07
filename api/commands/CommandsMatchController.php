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
   
    public static function actionGet_new_match_users_list($token){
        if($u=CommandsUsuarioController::getUserWhithAuthToken($token)){
            $m= new Mach();
            $m= $m->getUsersNoMostrados($u->id);
            $c=0;
      
            return $m;
        }
        return false;
    }

    public static function getMatches($token){
        $u=CommandsUsuarioController::getUserWhithAuthToken($token);
        if($u){
            return ["autenticacion"=>$u,"matches"=>Mach::getUserMatches($u->id)];
        }
        return ["autenticacion"=>false,"matches"=>null];;
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
             
                $mensajes=Mensajes::getMensajesByMatch($match["match_id"]);
                if($match["match_id_usu1"] == $u->id){
                    echo "\nEntra en el primer if";
                    $u2=Usuario::findIdentity($match["match_id_usu2"]);
                    $match["match_id_usu1"] = ["id"=>$u->id,"nombre"=>$u->nombre,"edad"=>Helper::calcularEdad($u->timestamp_nacimiento)];
                    $match["match_id_usu2"] = ["id"=>$u2->id,"nombre" => $u2->nombre,"edad"=>Helper::calcularEdad($u2->timestamp_nacimiento)];
                }else if($match["match_id_usu2"] == $u->id){
                    echo "\nEntra en el else if";
                    $u2=Usuario::findIdentity($match["match_id_usu1"]);
                    $match["match_id_usu2"] = ["id"=>$u->id,"nombre"=>$u->nombre,"edad"=>Helper::calcularEdad($u->timestamp_nacimiento)];
                    $match["match_id_usu1"] = ["id"=>$u2->id,"nombre" => $u2->nombre,"edad"=>Helper::calcularEdad($u2->timestamp_nacimiento)];
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

}