<?php
namespace app\commands;

use app\models\Imagen;

class CommandsImagenController extends WebsocketController{
    public static function getImagenUsuario($id){
        $imagenes = Imagen::getImagenUsuario($id);
        echo "\nHemos obtenido las imagenes y son:";
        var_dump($imagenes);
        foreach ($imagenes as $key) {
            
            if($key["imagen_localizacion_donde_subida"]=="interno"){
                echo"Entramos en el puñetero if";
                $key->imagen_src = $GLOBALS["base_imagenes"].$key->imagen_src;
            }
        }
        echo"\n Salimos de for";
        return $imagenes;

    }

}