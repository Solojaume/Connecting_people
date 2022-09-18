<?php
namespace app\commands;

use app\models\Imagen;

class CommandsImagenController extends WebsocketController{
    public static function getImagenUsuario($id){
        $imagenes = Imagen::getImagenUsuario($id);
        echo "\nHemos obtenido las imagenes y son:";
        var_dump($imagenes);
        $imagenes_d = [];
        foreach ($imagenes as $key) {
            
            if($key["imagen_localizacion_donde_subida"]=="Interno"){
                echo"Entramos en el puñetero if";
                echo "\n Base imagenes:";
                var_dump($GLOBALS["base_imagenes"]);
                $key["imagen_src"] = $GLOBALS["base_imagenes"].$key["imagen_src"];
            }
            $imagenes_d[] = $key;
        }
        echo"\n Salimos de for";
        unset($imagenes);
        var_dump($imagenes_d);
        return $imagenes_d;

    }

}