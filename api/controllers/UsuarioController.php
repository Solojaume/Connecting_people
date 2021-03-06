<?php

namespace app\controllers;

use app\models\Usuario;
use app\models\UsuarioSearch;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\auth\HttpBearerAuth;
use yii\data\ActiveDataProvider;


/**
 * UsuarioController implements the CRUD actions for Usuario model.
 */
class UsuarioController extends ApiController
{ 
    public $urlFrontend="http://localhost:4200/";
    public $modelClass='app\models\Usuario';
    /**
     * @inheritDoc
     */
    public function actions() {
        $actions = parent::actions();
        //Eliminamos acciones de crear y eliminar apuntes. Eliminamos update para personalizarla
        unset($actions['view'], $actions['create'],$actions['update']);
        // Redefinimos el método que prepara los datos en el index
        $actions['index']['prepareDataProvider'] = [$this, 'indexProvider'];
        return $actions;
    }
    public function indexProvider() {
        $uid=Yii::$app->user->identity->id;
        return new ActiveDataProvider ([
            'query' => Apuntes::find()->where('usuarios_id='.$uid )->orderBy('id')
        ]);
    }
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                        'login'=>['POST'],
                        'activate'=>['POST'],
                        'create'=>['POST'],
                        'cambiarContrasenya'=>['POST'],
                        'recuperar'=>['GET','POST'],
                        'autenticate' => ['POST']
                    ],
                ],  
                'authenticator' => [//token
                    'class' => HttpBearerAuth::className(),
                    'except' => ['login','create',"activate","recuperar",'autenticate'],
                ]
            ]
        );
    }

    
    /**
     * 
     * Lists all Usuario models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UsuarioSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Usuario model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    

    /**
     * Creates a new Usuario model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Usuario();

        $params=json_decode(file_get_contents("php://input"), false);
        if ($this->request->isPost) {
            $post=$this->request->post();
            //return $post;
            //Comprovamos que los campos que vamos a utilizar existan en el params
            if(!isset($params->email)|$params->email==""){
                return ["error"=>"El email es un campo requerido","errorType"=>"email"];
            }else if (static::is_valid_email($params->email)==false) {
                return ["error"=>"El email no es valido, introduce un email valido","errorType"=>"email"];
            }
            if(!isset($params->password)|$params->password==""){
                return ["error"=>"La contraseña es un campo requerido","errorType"=>"password"];
            }else if(strlen($params->password)<6){
                return ["error"=>"La contraseña ha de tener mínimo 6 caracteres","errorType"=>"password"];
            }
            if(!isset($params->pass2)|$params->pass2==""){
                return ["error"=>"La confirmación de contraseña es un campo requerido","errorType"=>"password2"];
            }else if($params->password!=$params->pass2){
                return ["error" =>"Las contraseñas no coinciden","errorType"=>"password2"];
            }
            if(!isset($params->nombre)|$params->nombre==""){
                return ["error"=>"El nombre es un campo requerido","errorType"=>"nombre"];
            }
            if(!isset($params->fecha_na)|$params->fecha_na==""){
                return ["error"=>"La fecha nacimiento es un campo requerido","errorType"=>"fecha"];
            }
            
            //Se declara las variables de los compos que se van a usar, es decir las dos password para poder compararlas entre si
            $email=$params->email;
            $password=$params->password;
            $password2= $params->pass2;
            $fecha_na = $params->fecha_na;
            $nombre = $params->nombre;
           
            //Comprovamos que las contraseñas sean iguales
            $cond=$password==$password2;
            
            if ($cond && $email && $fecha_na && $nombre) {
                $model->email=$email;
                $model->nombre = $nombre;
  
                $model->password=$password;
                $model->timestamp_nacimiento=$fecha_na;
                //return ["error"=>$model->password,"status"=>"-"];

                if($model->save()){
                    $text=" para activar tu cuenta: ".$this->actionRecuperar(["sub_action"=>"generate","email"=>$model->email,"url"=>"http://localhost:4200"])["url"];
                    $this->sendMail($model->email,"Activacion - Connecting People", $text);
                    return ["mensaje"=>"Se ha registrado correctamente, se ha enviado un email con un enlace de verificacion al correo electronico"];
                }else{
                    return ["error"=>"Ya existe un usuario con el email introducido, inicie sesion o prueve con otro email","errorType"=>"general"];
                }
            } else if(!$cond){
                return ["error" =>"Las contraseñas no coinciden","errorType"=>"password2"];
            }
        } else {
            echo "ddd";
            $model->loadDefaultValues();
            return ["error"=>"Contacte con el soporte"];
        }

        /*return $this->render('create', [
            'model' => $model,
        ]);*/
    }

     
    /**
     * Updates an existing Usuario model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Usuario model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /*Cambia la contraseña cuanda se esta dentro del usuario
    *Si el token de validacion no es validado, se devolvera un error
    * Si el token esta caducado,se devolvera error */
    //CambiarContrasenya
    public function actionCambiarcontrasenya(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //die();
            $cad_tok = static::generarCadToken("+ 24 hour");
                        
            //Contraseña antigua
            $pass = $_POST["password"]??"";
            //Contraseña nueva rep1
            $pass1=$_POST["pass1"];
            //Contraseña nueva rep2
            $pass2=$_POST["pass2"];
             
            $userWhithAuthToken = self::getUserWhithAuthToken();
            $model = $userWhithAuthToken["usuario"];
            //var_dump($model->password);
            
            $token = $userWhithAuthToken["token"];
            $pass1_h=self::sha256($pass1);
            Unset($userWhithAuthToken);
            
            //VERIFICACIONES:
            //Contraseña antigua en texto plano introducida es distinta
            $con=$pass!=$pass1?true:false;
            //Las contraseñas de verificacion son iguales
            $con2=$pass1===$pass2?true:false;
            //Contraseña de base de datos es igual a la contraseña antigua sin cifrar
            $con3=$model->password==$pass?true:false; 

            //Cifrando contraseña antigua
            $pass=self::sha256($pass);
            //Contraseña de base de datos es igual a la contraseña  antigua cifrada
            $con4=$model->password==$pass?true:false;
           
            //var_dump($con);
           // var_dump($model->validateAuthToken($token)); 
            if(isset($model)&&$model->validateAuthToken($token)){
                //die();
                //echo"avionetaaaaaaaaaaaaaaaa";
                if(($con===true&&$con2===true&&$con3===true)||($con===true&&$con2===true&&$con4===true)) {
                    $model->password=$pass1_h;
                    $model->cad_token=$cad_tok;                    
                    $model->save();
                    //echo "Iguales";
                    return ["status"=> "ok"];
                }else if($con2!=true){
                    return ["error"=>"Las contraseñas no coinciden"];
                }else if($con===false){
                    return ["error"=>"La contraseña es igual a la anterior cambiela"];
                }
                else if($con3!==true||$con4!==true){
                    return ["error"=>"No a introducido la contraseña correctamente"];
                }
                
                
                
                
            }
            return ["error"=>"Se a caducado la sesion, vuelve a iniar sesion de nuevo"];
 
        }
    }
    
    public function actionAutenticate(){
        $params=json_decode(file_get_contents("php://input"), false);
        @$token=$params->token;
        $u=null;
        try {
            if(isset($token))
            $u=\app\models\Usuario::findIdentityByAccessToken($token);

        } catch (\Throwable $th) {
            return ["error"=>"La sessión ha caducado, por favor inicie sesion de nuevo"];

        }
        if ($u==null) {
            return ["error"=>"La sessión ha caducado, por favor inicie sesion de nuevo"];
        }     
        $validacion=$u->validateAuthToken($token);
        if($validacion===true){
            return ['token'=>$u->token,'id'=>$u->id,'nombre'=>$u->nombre,'rol'=>$u->rol];
        }else{
            return ["error"=>"La sessión ha caducado, por favor inicie sesion de nuevo"];
        }
        
    } 
    /**
     * Finds the Usuario model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Usuario the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Usuario::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     *
     * Valida un email usando filter_var y comprobar las DNS. 
     *  Devuelve true si es correcto o false en caso contrario
     *
     * @param    string  $str la dirección a validar
     * @return   boolean
     *
     */
    private static function is_valid_email($str)
    {
        $dns_correctos=["gmail.com","outlook.com","hotmail.es","hotmail.com","yahoo.com"];
        $result = (false !== filter_var($str, FILTER_VALIDATE_EMAIL));
        $count=0;
        if ($result)
        {
            list($user, $domain) = explode('@', $str);
            foreach ($dns_correctos as $key) {
               if($domain!=$key){
                    $count=$count+1;
               }else{
                   $count=0;
                   break;
               }
            }
            if($count>0){
                return false;
            }

            $result = checkdnsrr($domain, 'MX');
        }
        
        return $result;
    }

    private function sendMail($to,$subject,$text){
        $eventDispatcher = new EventDispatcher();
         
        $MAILER_DSN="gmail://connectingpeoplesending@gmail.com:vvgrbszitsxpgpdn@default?verify_peer=0";
        $transport = Transport::fromDsn($MAILER_DSN);
        $mailer = new Mailer($transport, null, $eventDispatcher);
        
        $email = (new Email())
        ->from('connectingpeoplesending@gmail.com')
        ->to($to)
        //->cc('cc@example.com')
        //->bcc('bcc@example.com')
        //->replyTo('fabien@example.com')
        //->priority(Email::PRIORITY_HIGH)
        ->subject($subject)
        ->text("Si has recivido el email sin que te corresponda, eliminalo. Este es el link de connecting people: $text")
        ->html('<p>'."Si has recivido el email sin que te corresponda, eliminalo.
            <br> Este es el link de connecting people para $text".'</p>');

         return $mailer->send($email);
    }
    //Esta funcion sirve para loguear
    public function actionLogin(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Si se envían los datos en formato raw dentro de la petición http, se recogen así:
            $params=json_decode(file_get_contents("php://input"), false);
            @$email=$params->email??"";
            @$password=$params->password??"";
            //var_dump($params);
           // die();
            // Si se envían los datos de la forma habitual (form-data), se reciben en $_POST:
            //$email=$_POST['email'] ?? " ";
            //$password=$_POST['password'] ?? " ";
            
            if($u=Usuario::findOne(['email'=>$email])){
          
                /*if($u->password==sha256($password) {//o crypt, según esté en la BD
     
                    return ['token'=>$u->token,'id'=>$u->id,'nombre'=>$u->nombre];
                }*/
                //echo "Pass cifrada: ".self::sha256($password);
                //echo "\n Pass guardada: ".$u->password;
                //echo"\n Pass plana: $password"; 
                //die();

                if($u->password==$password || $u->password==self::sha256($password)) {//Esto es para comprobar la contraseña en texto plano o cifrada
                    if($u->activo===1){
                        $u->token = self::generateToken();
                        $now = static::generarCadToken("+ 168 hour");
                        $u->cad_token = $now;
                        $u->save();
                        return ['token'=>$u->token,'id'=>$u->id,'nombre'=>$u->nombre,'rol'=>$u->rol];
                    }else{
                        //Sirve para desactivar el token
                        $generate_activacion_token=true;
                        /*
                        *Aqui genera un token de recuperacion de contraseña que es el que se usara cuando no 
                        *este activado un usuario para activarlo.
                        */
                        if ($generate_activacion_token===true) {
                            $u->token_recuperar_pass = self::generateToken();
                            $now = static::generarCadToken("+ 30 minutes");
                            $u->cad_token_recuperar_pass = $now;
                            //var_dump($u->save());
                            $u->save();
                        }
                    
                        return ["error"=>"Haz click el enlace que encontraras en tu correo electronico, si no lo encuentras solicite otro"];
                    }
               
                }
     
                 return ['error'=>'No existe usuario con el email: '.$email .' o se ha introducido una contraseña incorrecta'];
            }
            return['error'=>'Petición incorrecta, introduzca email y contraseña'];
        }
    }
    //Este metodo sirve para generar todos los token 
    public static function generateToken(){
        //Generar token random parte1                                                                                     
        $token=bin2hex(openssl_random_pseudo_bytes(32));
        //Generar token random parte2
        $token2=bin2hex(openssl_random_pseudo_bytes(32));
        //Generar token random parte3
        $token3=bin2hex(openssl_random_pseudo_bytes(32));
        //Generar token random parte4
        $token4=bin2hex(openssl_random_pseudo_bytes(32));
        //hasheamos 2 tokens
        $token=self::sha256($token.$token2);
        $token3=self::sha256($token3.$token4);
        //Concatenamos token1 y token2 y la haseamos
        $token=self::sha256($token.$token2.$token3.$token4."");
        return $token;
    }

    public function actionActivate(){
        $params=json_decode(file_get_contents("php://input"), false);
       // return ["error"=>$params];
        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($params->token_activacion)){
            
            $t_a=$params->token_activacion;
            $u = Usuario::findIdentityByRecoveryToken($t_a);
            //return $u->validateRecoveryToken($t_a);
            if (isset($u)&&$u->validateRecoveryToken($t_a)&&!$u->token_recuperar_pass==null) {
                $u->activo=1;
                $u->cad_token_recuperar_pass=null;
                $u->token_recuperar_pass=null;
                $u->save();
                return ["status"=>"ok","mensaje"=>"Ha sido activado satisfactoriamente"];
            }
            else if(isset($u)){
                $text=" para activar tu cuenta: ".$this->actionRecuperar(["sub_action"=>"generate","email"=>$u->email,"url"=>"http://localhost:4200"])["url"];
                $this->sendMail($u->email,"Activacion - Connecting People", $text);
                return ["mensaje"=>"Se ha enviado un nuevo enlace de activación"];
            }
        }
        return ["error"=> "Petición incorrecta, puede que ya se haya activado prueve a iniciar sesion"];
    }

    public static function getUserWhithAuthToken($type = "array",$token=null)
    {
        try {
            //Devuelve el usuario del token que se encuentre en la cabecera de la petición
            $token_auth = \Yii::$app->request->headers->get("authorization");
            //var_dump($token_auth);
            $token_auth =$token===null ?str_replace('Bearer ', '', $token_auth):$token;
            //var_dump($token_auth);
            $u=Usuario::findIdentityByAccessToken($token_auth);
            if($type==="array"){
                return ["usuario"=>$u,"token"=>$token_auth,"id"=>$u->id];
            }
            return $u;
        } catch (\Throwable $th) {
            return false;
            //throw $th;
        }
    }
    
    public static function sha256($pass1 = null)
    {
        return hash("sha256",$pass1);
    }
    
    public static function generarCadToken($timeExtra="+ 24 hour"){
        $fecha_actual = date("Y-m-d H:i:s");
        $now = date("Y-m-d H:i:s",strtotime($fecha_actual.$timeExtra)); 
        return $now;
    }

    public function actionRecuperar($var = null)
    {
        if($_SERVER['REQUEST_METHOD'] === 'GET'||$_SERVER['REQUEST_METHOD'] === 'POST'){
           // echo"holiwis";
            $t_a=$_GET["token_activacion"] ?? " ";
            $s_a=isset($_GET["sub_action"]) ?$_GET["sub_action"]:$var["sub_action"];
            $email= isset($_GET["email"])?$_GET["email"]:$var["email"];
            $p=$_POST["password"]??" ";
            $p1=$_POST["password1"]??" ";
            $u =  Usuario::findIdentityByRecoveryToken($t_a)?:Usuario::findOne(["email"=>$email]);
            //var_dump($u);
            $con0 = $s_a !== " " && $email !==" " && Usuario::findOne(["email"=>$email])==true;
            $api_usurio=$var["url"]??"http://localhost/connectingpeople/api/web/usuario";
            
            // var_dump($s_a);
            switch ($s_a) {
                case 'generate':
                case 0:
                    if ($con0===true) {
                        $u->cad_token_recuperar_pass=self::generarCadToken();
                        $u->token_recuperar_pass=self::generateToken();
                        if(isset($var["action"])){
                            $action = $var["action"];
                        }
                        else if($u->activo==0){
                            $action="/activate";
                        }else{
                            $action="/recuperar?sub_action=recovery";
                        }
                        if($u->save())
                        return ["status"=>"ok",
                        "url"=>$api_usurio.$action."/".$u->token_recuperar_pass];//Quitar esto cuando se envien correos
                       //return ["status"=>"ok","mensaje"=>"Ha sido recuperado satisfactoriamente"];
                    }else{
                        return ["error"=>"No se encontrado email"];
                    }
                    //var_dump("Con: $con0");
                    break;
                case 'recovery':
                case 1:
                    //var_dump($u);
                    //var_dump(isset($u));
                    //die();
                    if($t_a===" "||!isset($u)||$u===null){
                        return ["error","Error peticion invalida"];
                    }

                    $con1 = $s_a !== " " && $u->validateRecoveryToken($t_a) ? true:false;
                    if(isset($_GET["token_activacion"])){
                        $t_a=$_GET["token_activacion"];
                    
                        if (isset($u)&&$con1===true && $p1 === $p){
                            $u->password=self::sha256($p1);
                            $u->cad_token_recuperar_pass="0000-00-00";
                            $u->token_recuperar_pass=null;
                            $u->save();
                            //echo "reccc";
                            return ["status"=>"ok","mensaje"=>"Ha sido cambiado satisfactoriamente"];
                        }else if($p1!==$p){
                            return ["error"=>"Comprueve que la contraseñas sean iguales"];
                        }
                        return ["error"=>"Algo fue mal"];

                        //echo"a";
                    }
                    break;
                default:
                    return ["error"=>"Enlace es incorrecto"];
                    break;
            }
            $u = Usuario::findIdentityByRecoveryToken($t_a);
            
        }    
    
    }
    
}
