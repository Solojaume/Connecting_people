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
class AspectoController extends ActiveController
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
                        'delete' => ['POST'],
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
        $searchModel = new AspectoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Aspecto model.
     * @param int $aspecto_id Aspecto ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($aspecto_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($aspecto_id),
        ]);
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
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'aspecto_id' => $model->aspecto_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Aspecto model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $aspecto_id Aspecto ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($aspecto_id)
    {
        $model = $this->findModel($aspecto_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'aspecto_id' => $model->aspecto_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Aspecto model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $aspecto_id Aspecto ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($aspecto_id)
    {
        $this->findModel($aspecto_id)->delete();

        return $this->redirect(['index']);
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
