<?php

namespace app\controllers;
use yii\rest\ActiveController;
use app\models\Mach;
use app\models\MachSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MachController implements the CRUD actions for Mach model.
 */
class MachController extends ActiveController
{
    public $modelClass='app\models\Mach';

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
     * Lists all Mach models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MachSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Mach model.
     * @param int $match_id Match ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($match_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($match_id),
        ]);
    }

    /**
     * Creates a new Mach model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Mach();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'match_id' => $model->match_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Mach model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $match_id Match ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($match_id)
    {
        $model = $this->findModel($match_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'match_id' => $model->match_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Mach model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $match_id Match ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($match_id)
    {
        $this->findModel($match_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Mach model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $match_id Match ID
     * @return Mach the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($match_id)
    {
        if (($model = Mach::findOne(['match_id' => $match_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
