<?php

namespace app\controllers;
use yii\rest\ActiveController;
use app\models\Mensajes;
use app\models\MensajesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Mach;
use yii\data\ActiveDataProvider;

/**
 * MensajesController implements the CRUD actions for Mensajes model.
 */
class MensajesController extends ApiController
{
    public $modelClass='app\models\Mensajes';

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
                        'get-mensajes' => ['POST'],
                        'get-mensajes-no-recividos' => ['POST'],
                        'get-mensajes-by-match' => ['POST'],
                        'enviar' => ['POST'],
                        'contar-nuevos-mensajes' => ['POST'],
                        'get-mensajes-by-match' => ['POST']
                    ],
                ],
            ]
        );
    }
    public function actions()
    {
        $actions = parent::actions();
        //Eliminamos acciones de crear y eliminar apuntes. Eliminamos update para personalizarla
        unset($actions['delete'], $actions['create'], $actions['update']);
        // Redefinimos el método que prepara los datos en el index
        $actions['index']['prepareDataProvider'] = [$this, 'indexProvider'];
        return $actions;
    }

    /**
     * Lists all Mensajes models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MensajesSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Mensajes model.
     * @param int $mensajes_id Mensajes ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($mensajes_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($mensajes_id),
        ]);
    }


    /**
     * Deletes an existing Mensajes model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $mensajes_id Mensajes ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($mensajes_id)
    {
        $this->findModel($mensajes_id)->delete();

        return $this->redirect(['index']);
    }

    public function actionGetMensajesByMatch()
    {
        
        
        $id = isset($_POST["match_id"]) ? $_POST["match_id"] : " ";
        $match = isset($_POST["match_id"]) ? \app\models\Mach::findOne(["match_id"=>$id]):" ";
        $u=self::getUserWhithAuthToken();
        //var_dump($match);
        //die();
        if(isset($u["error"])){
            return $u["error"];
        }else if($men = Mensajes::getMensajesByMatch($match->match_id)){
            //Modificamos los mensajes que no se hubieran entregado hasta ahora, para que su estado salga como entregados
            $models=[];
            foreach ($men as $key) {
                // var_dump($men);
                // var_dump($key);
                //  die();
                $model= Mensajes::findOne($key["mensajes_id"]);
                if($model->entregado===0)
                    $model->entregado=1;
                if($model->save());
                    $models[]=$model;
            }
            return $models;
        }
        return ["Mensajes",null];
    }

    public function actionGetMensajes(){
        $u=self::getUserWhithAuthToken();
        if(isset($u["error"])){
            return $u["error"];
        }else if($men = Mensajes::getMensajesByUserId($u["id"])){
            //Modificamos los mensajes que no se hubieran entregado hasta ahora, para que su estado salga como entregados
            $models=[];
            foreach ($men as $key) {
                // var_dump($men);
                // var_dump($key);
                //  die();
                $model= Mensajes::findOne($key["mensajes_id"]);
                if($model->entregado===0)
                    $model->entregado=1;
                if($model->save());
                    $models[]=$model;
            }
            return $models;
        }
        return ["Mensajes",null];
    }
    public function actionGetMensajesNoRecividos(){
        $u=self::getUserWhithAuthToken();
        if(isset($u["error"])){
            return $u["error"];
        }else if($men = Mensajes::getNoRecivedMensajesByUserId($u["id"])){
            $men= new ActiveDataProvider(['query'=>$men]);
            //Modificamos los mensajes que no se hubieran entregado hasta ahora, para que su estado salga como entregados
            $models=[];
            try {
                foreach ($men as $key) {
                    // var_dump($men);
                    // var_dump($key);
                    //  die();
                    $model= Mensajes::findOne($key["mensajes_id"]);
                    if($model->entregado===0)
                        $model->entregado=1;
                    if($model->save());
                        $models[]=$model;
                }
            } catch (\Throwable $th) {
                //throw $th;
                return ["mensajes"=>null];
            }
            return $models;
        }
        return ["mensajes"=>null];
    }
    
    public function actionEnviar(){
        $u=self::getUserWhithAuthToken();
        //var_dump($u);
        if(isset($u["error"])===false){
            $model = new Mensajes();
            if ($this->request->isPost) {
                //echo"aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";
                //die();
                //var_dump($model->load($this->request->post(),''));
                if ($model->load($this->request->post(),'')&&$model->save()) {
                     
                    //echo"uss entre en el segundo";
                    //var_dump($model);
                    //die();
                    return $model;
                }
            } else {
                $model->loadDefaultValues();
            }
        }
        else
        {
            return $u["error"];
        };
    }
    public function actionContarNuevosMensajes(){
        $u=self::getUserWhithAuthToken();
        if(!isset($u['error'])){
            return Mensajes::getCountNoRecivedMensagesByUserId($u["id"]);
        }
        return $u;
    }

    /**
     * Finds the Mensajes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $mensajes_id Mensajes ID
     * @return Mensajes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($mensajes_id)
    {
        if (($model = Mensajes::findOne(['mensajes_id' => $mensajes_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
