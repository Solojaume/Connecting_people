<?php

namespace app\controllers;

use app\models\Review;
use app\models\ReviewSearch;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\PuntuacionesReview;
use app\helpers\HelperArray;
/**
 * ReviewController implements the CRUD actions for Review model.
 */
class ReviewController extends ApiController
{
    public $modelClass='app\models\Review';

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
                        'getReviewsByUserId'=>['POST'],
                        'createReview' => ['POST']
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Review models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ReviewSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Review model.
     * @param int $review_id Review ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($review_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($review_id),
        ]);
    }
    /**
     * Recive:
     *  Usuario=>POST
     * Devuelve:
     *  Reviews, que contiene:[PuntuacionesReview] y el campo extra llamado "puntuacion_media"
     * 
     */
    public function actionGetReviewsByUserId()
    {
        if ($this->request->isPost) {
            $u=self::getUserWhithAuthToken();
            if(isset($u['error'])){
                return $u['error'];
            }
            $usuario = isset($_POST["usuario"])?$_POST["usuario"]:null;
            // var_dump($usuario);
            if (!$usuario==null) {
                $rev = new Review();
                $rev = $rev->getReviewByUserID($usuario);
                for ($i=0; $i < count($rev); $i++) { 
                    $rev[$i]["puntuacion_media"] = PuntuacionesReviewController::getMediaPuntuaciones($rev[$i]["review_id"]);
                    //die();
                    $rev[$i]["puntuaciones_review"] = PuntuacionesReviewController::getPuntuaciones($rev[$i]["review_id"]);
                }
                return $rev;    
            }else{
                return ["error"=>"No hay usuario en la peticion"];
            }    
        }
        return ["error"=>"UPPS, Algo ha salido mal"];
        
    }
    /**
     * Creates a new Review model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreateReview()
    {
        $model = new Review();
        //La vista indica si el usuario a realizado una puntuacion simple o avanzada
        //TE VAS A CAGAR CUANDO TE TOQUE IMPLEMENTAR EN ANGULAR, Denada Guapo :)
        //var_dump($this->request->isPost);
        if ($this->request->isPost) {
            $vista=isset($_GET["vista"])?$_GET["vista"]:"simple";
            $u=self::getUserWhithAuthToken();
            if(isset($u['error'])){
                return $u['error'];
            }
            //var_dump($vista);
            //die();
            //var_dump($vista);
            switch ($vista) {
                case "simple":
                   // echo"simp";
                   $model = new Review();
                   $id=0;
                    if($model->load($this->request->post(),'')&&$model->save()){
                        $id=$model->review_id;
                        $aspectos = new \app\models\Aspecto();
                        $aspectos=$aspectos->getTodosAspectos();
                       
                        foreach ($aspectos as $key) {
                            $model = new \app\models\PuntuacionesReview();
                            $model-> puntuaciones_review_aspecto_id=$key["aspecto_id"];
                            $model-> puntuaciones_review_review_id=$id;
                            $punt=isset($_POST["review_puntuacion_review"])?$_POST["review_puntuacion_review"]:"";
                            if ($punt>=$key["puntuacion_minima"]&&$punt<=$key["puntuacion_maxima"]) {
                                $model->puntuaciones_review_puntuacion=$punt;
                            }
                            
                            if ($model->save()) {
                                return ["status"=>"Se ha guardado correctamente"];
                            }
                        }
                    }
                    break;
                case "avanzada":
                    //echo "h";
                    $model = new Review();
                    $id=0;
                    if($model->load($this->request->post(),'')&&$model->save()){
                        //$id=$model->review_id;
                        return ["review_id"=>$model->review_id];
                    }
                    if(isset($_POST["review_puntuacion_review"])) {
                        $puntuaciones=$_POST["review_puntuacion_review"];
                        $puntuaciones = substr($puntuaciones,2,strlen($puntuaciones)-2);
                       // $puntuaciones=explode('"',);
                      // settype($puntuaciones,"array");
                        var_dump($puntuaciones);
                        die();
                        foreach ($puntuaciones as $key) {
                            $key["puntuaciones_review_review_id"]=$id;
                            /**
                             * {{"puntuaciones_review_aspecto_id" : 0, "puntuaciones_review_puntuacion" : 4, "puntuaciones_review_review_id": },{"puntuaciones_review_aspecto_id" : 0, "puntuaciones_review_puntuacion" : 4, "puntuaciones_review_review_id": }}
                             */
                            var_dump(PuntuacionesReviewController::actionCreateR($key));
                            die();
                            if (PuntuacionesReviewController::actionCreate($key)) {
                                return ["status"=> "Se guardo correctamente"];
                            };
                        }
                    }    
                        
                    break;
                default:
                    return["error"=>"Se derramo una copa de vino sobre el programa y no se va"];
                    break;
            }

        }
        else{
            return ["error"=>"Algo ha salido mal, jo"];

        }	
        
    }

        

    /**
     * Updates an existing Review model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $review_id Review ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($review_id)
    {
        $model = $this->findModel($review_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'review_id' => $model->review_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Review model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $review_id Review ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($review_id)
    {
        $this->findModel($review_id)->delete();

        return $this->redirect(['index']);
    }
   

    /**
     * Finds the Review model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $review_id Review ID
     * @return Review the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($review_id)
    {
        if (($model = Review::findOne(['review_id' => $review_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
