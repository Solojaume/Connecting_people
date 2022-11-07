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
    public $modelClass = 'app\models\Review';

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
                        'getReviewsByUserId' => ['POST'],
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
    public function actionGetReviewsByUserId($id)
    {
        if ($this->request->isPost) {
            $u = self::getUserWhithAuthToken();
            if (isset($u['error'])) {
                return $u['error'];
            }
            $usuario = isset($_POST["usuario"]) ? $_POST["usuario"] : null;
            // var_dump($usuario);
            if (!$usuario == null) {
                $rev = new Review();
                $rev = $rev->getReviewByUserID($usuario);
                for ($i = 0; $i < count($rev); $i++) {
                    $rev[$i]["puntuacion_media"] = PuntuacionesReviewController::getMediaPuntuaciones($rev[$i]["review_id"]);
                    $rev[$i]["puntuaciones_review"] = PuntuacionesReviewController::getPuntuaciones($rev[$i]["review_id"]);
                }
                return $rev;
            } else {
                return ["error" => "No hay usuario en la peticion"];
            }
        }
        return ["error" => "UPPS, Algo ha salido mal"];
    }
    public static function getReviewsByUserId($id)
    {
        $rev = new Review();
        $rev = $rev->getReviewByUserID($id);
        //echo"Review";
        //var_dump($rev);
        //die();
        for ($i = 0; $i < count($rev); $i++) {
            //$rev[$i]["puntuacion_media"] = PuntuacionesReviewController::getMediaPuntuaciones($rev[$i]["review_id"]);
            $rev[$i]["puntuaciones_review"] = PuntuacionesReviewController::getPuntuaciones($rev[$i]["review_id"]);
            $rev[$i]["puntuacion_media"] = $rev[$i]["puntuaciones_review"][0]??1;
        }
        return $rev;
    }

    public static function getReviewsByUserIdWithAuthToken()
    {
        $u = self::getUserWhithAuthToken();
        if (isset($u['error'])) {
            return $u["error"];
        }

        // var_dump($usuario);
        if (!$u == null) {
            $rev = new Review();
            $rev = $rev->getReviewByUserID($u["id"]);
            for ($i = 0; $i < count($rev); $i++) {
                $rev[$i]["puntuacion_media"] = PuntuacionesReviewController::getMediaPuntuaciones($rev[$i]["review_id"]);
                $rev[$i]["puntuaciones_review"] = PuntuacionesReviewController::getPuntuaciones($rev[$i]["review_id"]);
            }

            return $rev;
        } else {
            return ["error" => "No hay usuario en la peticion"];
        }
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
        $params = json_decode(file_get_contents("php://input"), false);
        //echo "\nEntra\n";
        //echo"Params sin decodificar:\n";
        //var_dump(file_get_contents("php://input"));
        //echo"\n\n\n";
        if ($params) {
            //var_dump($params);

            $vista = isset($params->vista) ? $params->vista : "simple";
            $u = self::getUserWhithAuthToken();
            if (isset($u['error'])) {
                return $u['error'];
            }
            //echo" ";
            switch ($vista) {
                case "simple":
                    //echo"simp\n";
                    $modal = new Review;
                    $modal->review_id = $params->review_id;
                    $modal->review_usuario_id = $params->review_usuario_id;
                    $modal->review_descripcion = $params->review_descripcion;
                    //var_dump($modal);
                    //var_dump($modal->save());
                    if ($modal->save()) {
                        //echo "Entra en el if\n";
                        $id = $modal->review_id;
                        $aspectos = new \app\models\Aspecto();
                        $aspectos = $aspectos->getTodosAspectos();
                        $puntuaciones = $params->puntuaciones_review;
                        $guardada = 0;
                        for ($i = 0; $i < count($puntuaciones); $i++) {
                            $key = $puntuaciones[$i];
                            $punt = new \app\models\PuntuacionesReview();
                            $aspecto =  $key->puntuaciones_review_aspecto_id;
                            $punt->puntuaciones_review_aspecto_id = $aspecto->aspecto_id;
                            $punt->puntuaciones_review_review_id = $modal->review_id;
                            $punt->puntuaciones_review_id = 0;
                            if (
                                $key->puntuaciones_review_puntuacion>= $aspecto->puntuacion_minima &&
                                $key->puntuaciones_review_puntuacion <= $aspecto->puntuacion_maxima
                            ) {
                                $punt->puntuaciones_review_puntuacion = $key->puntuaciones_review_puntuacion;
                                $punt->puntuaciones_review_review_id =$modal->review_id;
                                //echo "\nHemos creado la puntuacion correctamente";
                            }
                            
                            if ($punt->save()) {
                                $guardada = $guardada+1;
                               // echo "Se ha guardado";
                                //return ["status" => "Se ha guardado correctamente"];
                            } 
                        }
                        if($guardada>0){
                            return ["status" => "Se ha guardado correctamente"];
                        }
                        
                    }
                    break;
                case "avanzada":
                    //echo "h";
                    $model = new Review();
                    $id = 0;
                    if ($model->load($this->request->post(), '') && $model->save()) {
                        //$id=$model->review_id;
                        return ["review_id" => $model->review_id];
                    }
                    if (isset($_POST["review_puntuacion_review"])) {
                        $puntuaciones = $_POST["review_puntuacion_review"];
                        $puntuaciones = substr($puntuaciones, 2, strlen($puntuaciones) - 2);
                        // $puntuaciones=explode('"',);
                        // settype($puntuaciones,"array");
                        var_dump($puntuaciones);
                        foreach ($puntuaciones as $key) {
                            $key["puntuaciones_review_review_id"] = $id;
                            /**
                             * {{"puntuaciones_review_aspecto_id" : 0, "puntuaciones_review_puntuacion" : 4, "puntuaciones_review_review_id": },{"puntuaciones_review_aspecto_id" : 0, "puntuaciones_review_puntuacion" : 4, "puntuaciones_review_review_id": }}
                             */
                            var_dump(PuntuacionesReviewController::actionCreateR($key));
                            //die();
                            if (PuntuacionesReviewController::actionCreate($key)) {
                                return ["status" => "Se guardo correctamente"];
                            };
                        }
                    }

                    break;
                default:
                    return ["error" => "Se derramo una copa de vino sobre el programa y no se va"];
                    break;
            }
        } else {
            return ["error" => "Algo ha salido mal, jo"];
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
