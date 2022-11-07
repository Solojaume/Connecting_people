<?php

namespace app\controllers;

use app\models\PuntuacionesReview;
use app\models\PuntuacionesReviewSearch;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PuntuacionesReviewController implements the CRUD actions for puntuacionesReview model.
 */
class PuntuacionesReviewController extends ApiController
{
    public $modelClass='app\models\PuntuacionesReview';
    
    public function actions() {
        $actions = parent::actions();
        //Eliminamos acciones de crear y eliminar apuntes. Eliminamos update para personalizarla
        unset($actions['delete'],$actions['update'],$actions['view']);
        // Redefinimos el método que prepara los datos en el index
       // $actions['index']['prepareDataProvider'] = [$this, 'indexProvider'];
        return $actions;
    }

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
                       // 'delete' => ['POST'],
                       'createR' => ['POST']
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all puntuacionesReview models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PuntuacionesReviewSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    static function getPuntuaciones($review){
        $p = new PuntuacionesReview();
       
        if($p=$p->getPuntuacionesReview($review)){
            /*for ($i=0; $i < count($p) ; $i++) { 
                $pr=PuntuacionesReview::findOne("puntuaciones_review_id".$p[$i]["puntuaciones_review_id"]);
                //var_dump($pr->getPuntuacionReviewAspecto()->asArray()->all()[0]['aspecto_nombre']);
                //die();
                $p[$i]["puntuaciones_review_aspecto_id"] = $pr->getPuntuacionReviewAspecto()->asArray()->all()[0]['aspecto_nombre'];
            }*/
            return $p;
        }
       // var_dump($review);
        return [];
    }

    static function getMediaPuntuaciones( $review = null)
    {
        try {
            $m = new PuntuacionesReview();
            $sumaPuntuaciones = 0;
            $cantidad = $m->getCountPuntuaciones($review);
            $punt = $m->getPuntuacionesReview();
            unset($m);
            for ($i=0; $i < count($punt); $i++) { 
                $sumaPuntuaciones=$sumaPuntuaciones+$punt[$i]["puntuaciones_review_puntuacion"];
            }
            return $sumaPuntuaciones/$cantidad;
        } catch (\Throwable $th) {
            //throw $th;
            return 0;
        }
        
    }

    /**
     * Creates a new puntuacionesReview model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreateR()
    {
        $model = new PuntuacionesReview();
        //var_dump($model->load($punt,""));
        //die();
        if ($this->request->isPost) {
            $u=self::getUserWhithAuthToken();
            if(isset($u['error'])){
                return $u['error'];
            }
            // var_dump($model->load($this->request->isPost));
            if ($model->load($this->request->post(),'') && $model->save()) {
                return ["status"=>"Se guardo correctamente"];
            }else{
                return false;
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }


    /**
     * Finds the puntuacionesReview model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $puntuaciones_review_id Puntuaciones Review ID
     * @return puntuacionesReview the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($puntuaciones_review_id)
    {
        if (($model = puntuacionesReview::findOne(['puntuaciones_review_id' => $puntuaciones_review_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
