<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\Usuario;
use yii\console\Controller;
use yii\console\ExitCode;

class WebsocketController extends Controller
{  
   public $base_socket_io_host;
   public $base_socket_io_port;
   public $base_imagenes;
   public $base_api;
   public $base_frontend;

   public function __autoload__()
   {
      # code...
      $this->base_socket_io_host = $GLOBALS["base_socket_io_host"];
      $this->base_socket_io_port = $GLOBALS["base_socket_io_port"];
      $this->base_imagenes = $this->get_base_imagen_URL();
      $this->base_api = $this->get_base_URL_api();
      $this->base_frontend = $this->get_url_frontend();
   }

   public static function get_base_imagen_URL(){
      return $GLOBALS["base_imagenes"];
   }
   
   public static function get_base_URL_api(){
      return $GLOBALS["base_api"];
   }

   public static function get_url_frontend(){
      return $GLOBALS["base_frontend"];
   }
   public static function get_base_url_socket(){
      return $GLOBALS["base_socket_io"];
   }
}
