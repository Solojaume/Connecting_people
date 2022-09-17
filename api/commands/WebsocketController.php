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
   public static function get_base_imagen_URL(){
      return $GLOBALS["base_imagenes"];
   }
   
   public static function get_base_URL_api(){
      return $GLOBALS["base_api"];
   }

   public static function get_url_frontend(){
      return $GLOBALS["base_frontend"];
   }
}
