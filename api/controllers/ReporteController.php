<?php

namespace app\controllers;

use app\models\Reporte;
use app\models\ReporteSearch;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ReporteController implements the CRUD actions for Reporte model.
 */
class ReporteController extends ActiveController
{
    public $modelClass='app\models\Reporte';

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
     * Lists all Reporte models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ReporteSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Reporte model.
     * @param int $reporte_id Reporte ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($reporte_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($reporte_id),
        ]);
    }

    /**
     * Creates a new Reporte model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Reporte();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'reporte_id' => $model->reporte_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Reporte model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $reporte_id Reporte ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($reporte_id)
    {
        $model = $this->findModel($reporte_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'reporte_id' => $model->reporte_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Reporte model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $reporte_id Reporte ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($reporte_id)
    {
        $this->findModel($reporte_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Reporte model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $reporte_id Reporte ID
     * @return Reporte the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($reporte_id)
    {
        if (($model = Reporte::findOne(['reporte_id' => $reporte_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
