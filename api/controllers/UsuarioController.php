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
class UsuarioController extends ApiController
{
    public $modelClass='app\models\Usuario';
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
                        'activate'=>['POST']
                    ],
                ],  
                'authenticator' => [//token
                    'class' => HttpBearerAuth::className(),
                    'except' => ['login','create'],
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
    /*Cambia la contraseña cuanda se esta dentro del usuario
    *Si el token de validacion no es validado, se devolvera un error
    * Si el token esta caducado,se devolvera error */
    public function actionCambiarContrasenya(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            die();
            $pass = $_POST["password"]??"";
            $token = $_POST["token"]??"";
            $model = Usuario::findIdentityByAccessToken($token);
            return ["status"=> "ok"];
 
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

    //Esta funcion sirve para loguear
    public function actionLogin(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          // Si se envían los datos en formato raw dentro de la petición http, se recogen así:
          //$params=json_decode(file_get_contents("php://input"), false);
          //@$email=$params->email;
         // @$password=$params->password;
          // Si se envían los datos de la forma habitual (form-data), se reciben en $_POST:
          $email=$_POST['email'];
          $password=$_POST['password'];

          if($u=Usuario::findOne(['email'=>$email]))
            /*if($u->password==password_hash($password,CRYPT_SHA256)) {//o crypt, según esté en la BD
     
                  return ['token'=>$u->token,'id'=>$u->id,'nombre'=>$u->nombre];
              }*/
            if($u->password==$password) {//Esto es para comprobar la contraseña en texto plano
                $u->token=self::generateToken();
                return ['token'=>$u->token,'id'=>$u->id,'nombre'=>$u->nombre];
            }
     
          return ['error'=>'No existe usuario con el email:'.$email .'o contraseña incorrecta'];
        }
    }
    public function actionActivate(){

    }
}
