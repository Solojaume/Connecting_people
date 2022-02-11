<?php

namespace app\controllers;

use app\models\puntuacionesReview;
use app\models\PuntuacionesReviewSearch;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PuntuacionesReviewController implements the CRUD actions for puntuacionesReview model.
 */
class PuntuacionesReviewController extends ActiveController
{
    public $modelClass='app\models\PuntuacionesReview';

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

    /**
     * Displays a single puntuacionesReview model.
     * @param int $puntuaciones_review_id Puntuaciones Review ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($puntuaciones_review_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($puntuaciones_review_id),
        ]);
    }

    /**
     * Creates a new puntuacionesReview model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new puntuacionesReview();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'puntuaciones_review_id' => $model->puntuaciones_review_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing puntuacionesReview model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $puntuaciones_review_id Puntuaciones Review ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($puntuaciones_review_id)
    {
        $model = $this->findModel($puntuaciones_review_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'puntuaciones_review_id' => $model->puntuaciones_review_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing puntuacionesReview model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $puntuaciones_review_id Puntuaciones Review ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($puntuaciones_review_id)
    {
        $this->findModel($puntuaciones_review_id)->delete();

        return $this->redirect(['index']);
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
