<?php
namespace app\commands;

use app\models\Mensajes;

class CommandsMensajesController extends WebsocketController
{
    public static function create($objeto)
    {   
        echo "\nentra en create";
         //Se guarda en la base de datos
        echo "\nVar_dump mensajes";
        var_dump($objeto);
		$mensaje = new Mensajes();
        echo "\nPost mensajes";
		$mensaje->mensajes_match_id = $objeto->match_id;
        echo "\nobjeto->match_id correcto";
		$mensaje->mensaje_contenido = $objeto->chat_message;
        echo "\nobjeto->chat_message correcto";
		$mensaje->timestamp = $objeto->timestamp;
        echo "\nobjeto->timestamp correcto";
        $mensaje->entregado = 0;
        echo "\nObjeto->entregado correcto";
        //var_dump($objeto->chat_user);
        $mensaje->mensajes_usuario_id=$objeto->chat_user;
        echo"\nObjeto->mensajes_usuario_id correcto";
        var_dump($mensaje->save());
        echo "\nMensaje->save no peta";

        return $mensaje;
    }

    public static function getByMatch($match_id,$u)
    { 
        echo"\n Entra en getByMatch";
        $mensajes=Mensajes::getMensajesByMatch($match_id);
        $mensajes_devolver=[];
       
        echo"\n Preforeach";
        foreach ($mensajes as $mensaje) {
            $mns=[];
            $mensaje2=Mensajes::findIdentity($mensaje["mensajes_id"]);
            if ($mensaje["mensajes_usuario_id"]!=$u) {
                echo "\n Pre mensaje buscado en bd";
                var_dump($mensaje);
                echo "\n Mensaje buscado en bd exitosamente";
                
                $mensaje2->entregado=1;
                $mensaje2->save();
            }
            $mns["chat_user"]=$mensaje2->mensajes_usuario_id;
            $mns["chat_message"]=$mensaje2->mensaje_contenido;
            $mns["type"] = "inChat";
            $mns["match_id"] = $match_id;
            $mns["id"]= $mensaje2->mensajes_id;
            $mns["timestamp"] = $mensaje2->timestamp;
            $mns["estado"] = 1;
            $mensajes_devolver[]=$mns;
        }
        //var_dump($mensajes);
        return $mensajes_devolver;
    }
}