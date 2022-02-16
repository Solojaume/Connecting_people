<?php

namespace app\controllers;

use app\models\Usuario;
use app\models\UsuarioSearch;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\auth\HttpBearerAuth;

/**
 * UsuarioController implements the CRUD actions for Usuario model.
 */
class UsuarioController extends ActiveController
{
    public $modelClass = 'app\models\Usuario';
    /**
     * @inheritDoc
     */
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
                    ],
                ],
                'authenticator' => [//token
                    'class' => HttpBearerAuth::className(),
                    'except' => ['login'],
                ]
            ]
        );
    } 
    

    public function init()
    {
        parent::init();
        \Yii::$app->user->enableSession = false;
    }


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
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Usuario model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Usuario();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
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

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    
    public function actionLogin(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          // Si se envían los datos en formato raw dentro de la petición http, se recogen así:
          //$params=json_decode(file_get_contents("php://input"), false);
          //@$email=$params->email;
         // @$password=$params->password;
          // Si se envían los datos de la forma habitual (form-data), se reciben en $_POST:
          $email=$_POST['email']??" ";
          $password=$_POST['password']??" ";

          if($u=Usuario::findOne(['email'=>$email]))
            /*if($u->password==password_hash($password,CRYPT_SHA256)) {//o crypt, según esté en la BD
     
                  return ['token'=>$u->token,'id'=>$u->id,'nombre'=>$u->nombre];
              }*/
            if($u->password==$password) {//Esto es para comprobar la contraseña en texto plano
                $u->token=self::generateToken();
                $u->save();
                return ['token'=>$u->token,'id'=>$u->id,'email'=>$u->email];
            }
     
          return ['error'=>'No existe usuario con el email:'.$email .' o contraseña incorrecta'];
        }
    }
    /**
     * Activa los usuario que no han sido activados
     *
     * @return string
     */
    public function actionActivate(){
        return ["mensaje"=> "Actualizado"];
    }
    
    private static function generateToken(){
        //Generar token random parte1                                                                                     
        $token=bin2hex(openssl_random_pseudo_bytes(32));
        //Generar token random parte2
        $token2=bin2hex(openssl_random_pseudo_bytes(32));
        //Concatenamos token1 y token2 y la haseamos
        $token=password_hash($token.$token2."",PASSWORD_DEFAULT);
        return $token;
    }
}
