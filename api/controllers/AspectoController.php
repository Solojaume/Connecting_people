<?php

namespace app\controllers;
use yii\rest\ActiveController;
use app\models\Aspecto;
use app\models\AspectoSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AspectoController implements the CRUD actions for Aspecto model.
 */
class AspectoController extends ApiController
{
    /**
     * @inheritDoc
     */
    public $modelClass='app\models\Aspecto';
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'deleteAspecto' => ['POST'],
                        'updateAspecto' => ['POST']
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Aspecto models.
     *
     * @return string
     */
    public function actionIndex()
    { 
        $id=$_POST["a"];
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            return $searchModel::findOne(["id",$id]);
        }
    }

    /**
     * Creates a new Aspecto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function fields(){
        return ['id','nombre','estado','email','rol'];
    }
    public function actionCreate()
    {
        $model = new Aspecto();

        if ($this->request->isPost) {
            $u=self::getUserWhithAuthToken();
            if(isset($u['error'])){
                return $u['error'];
            }
            else if ($model->load($this->request->post()) && $model->save() && $u->hasRol(1)) {
                return ["status"=>"Se ha guardado corretamente el nuevo Aspecto"];
            }else if ($u->rol===0 && $u->hasRol(0)) {
                return ["error"=>"El usuario no tiene permisos para realizar esta acción"];
            }
        } else {
            $model->loadDefaultValues();
        }
    }

    /**
     * Updates an existing Aspecto model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $aspecto_id Aspecto ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdateAspecto()
    {
        $aspecto_id=isset($_POST["aspecto_id"])?$_POST["aspecto_id"]:null;

        if ($this->request->isPost) {
            $u=self::getUserWhithAuthToken("object");
           
            if(isset($u['error'])){
                return $u['error'];
            }
            else if ( $u->hasRol(1)) {
                if ($aspecto_id===null) {
                    return ["error"=>"Aspecto no encontrado"];
                }else{
                    $model = $this->findModel($aspecto_id);
                }

                if ($model->load($this->request->post(),"") && $model->save()) {
                    return ["status"=>"Se ha guardado corretamente los cambios Aspecto"];
                }
            }else if ($u->rol===0 && $u->hasRol(0)) {
                return ["error"=>"El usuario no tiene permisos para realizar esta acción"];
            }
        } else {
            $model->loadDefaultValues();
        }
    }

    /**
     * Deletes an existing Aspecto model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $aspecto_id Aspecto ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDeleteAspecto()
    {
        $aspecto_id=isset($_POST["aspecto_id"])?$_POST["aspecto_id"]:null;

        if ($this->request->isPost) {
            $u=self::getUserWhithAuthToken("o");
           
            if(isset($u['error'])){
                return $u['error'];
            }
            else if ( $u->hasRol(1)) {
                if ($aspecto_id===null) {
                    return ["error"=>"Aspecto no encontrado"];
                }else{
                    try {
                        $model = $this->findModel($aspecto_id)->delete();
                        return ["status"=>"Se ha eliminado corretamente el Aspecto"];
                    } catch (\Throwable $th) {
                        //throw $th;
                        return ["error"=>"El aspecto en cuestion no existe"];
                    }
                    
                    
                }
           
            }else if ($u->rol===0 && $u->hasRol(0)) {
                return ["error"=>"El usuario no tiene permisos para realizar esta acción"];
            }
        }

    }

    public function actionGetAspectos($var = null)
    {
        if ($this->request->isPost) {
            $u=self::getUserWhithAuthToken();
           
            if(isset($u['error'])){
                return $u['error'];
            }
            else {  
                return Aspecto::getTodosAspectos();                
            }
        }
    }

    /**
     * Finds the Aspecto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $aspecto_id Aspecto ID
     * @return Aspecto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($aspecto_id)
    {
        if (($model = Aspecto::findOne(['aspecto_id' => $aspecto_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
