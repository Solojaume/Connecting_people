<?php

namespace app\controllers;

use yii\filters\Cors;
use yii\filters\auth\HttpBearerAuth;
use yii\data\ActiveDataProvider;
use app\models\Noticias;
use Yii;

//el resto de controladores hereda de esta clase para que no falle el cors, y gestionar el token
class ApiController extends \yii\rest\ActiveController
{
    public $enableCsrfValidation = false;
    public $authenable = true;//en los controladores que no queramos el token se pone en false
    public $modelClass="d";

    public function beforeAction($a)
    {
        header('Access-Control-Allow-Origin: *');
        return parent::beforeAction($a);
    }


    public function behaviors()
    {
        $behaviors = parent::behaviors();
        unset($behaviors['authenticator']);
        $behaviors['corsFilter'] = [
            'class' => Cors::className(),
            'cors' => [
                'Origin' => ['localhost:*/*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'HEAD', 'OPTIONS', 'DELETE'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => $this->authenable,
                'Access-Control-Max-Age' => 86400
            ],
        ];

        if (!$this->authenable)
            return $behaviors;//behaviour->configuracion de la api(controladores)

        $behaviors['authenticator'] = [//token
            'class' => HttpBearerAuth::className(),
            'except' => ['options'],
        ];

        return $behaviors;
    }
    protected static function sha256($pass1 = null)
    {
        return hash("sha256",$pass1);
    }

    public static function getUserWhithAuthToken($type = "array")
    {
        //Devuelve el usuario del token que se encuentre en la cabecera de la petición
        $token_auth = \Yii::$app->request->headers->get("authorization");
        //var_dump($token_auth);
        $token_auth = str_replace('Bearer ', '', $token_auth);
        //var_dump($token_auth);
        $u=\app\models\Usuario::findIdentityByAccessToken($token_auth);
        $validacion=$u->validateAuthToken($token_auth);
        if($validacion==true){
             if ($type === "array") {
                return ["usuario"=>$u,"token"=>$token_auth,"id"=>$u->id,"rol"=>$u->rol];
            }
            return $u;
        }
        return ["error"=> "Sesion caducada, inicia sesion de nuevo"];
    }

    
}
