<?php

namespace app\controllers;

use app\models\Helper;
use yii\rest\ActiveController;
use app\models\Mach;
use app\models\MachSearch;
use yii\filters\auth\HttpBearerAuth;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MachController implements the CRUD actions for Mach model.
 */
class MachController extends ApiController
{
    public $modelClass = 'app\models\Mach';

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
                        'get_new_match_users_list' => ['POST'],
                        'get-matches' => ['POST'],
                        'like-dislike' => ['POST'],
                        'deshacer' => ['POST']
                    ],

                ], 'authenticator' => [ //token
                    'class' => HttpBearerAuth::className(),
                    'except' => ['get_new_match_users_list'],
                ]
            ]
        );
    }

    /**
     * Borrar match
     */
    public function actionDeshacer()
    {
        $params = json_decode(file_get_contents("php://input"), false);

        $u = UsuarioController::getUserWhithAuthToken("o");
        $match_id = $params->match_id ?? " ";
       
        if ($u == true) {
            $match = $this->findModel($match_id);
            $match->match_estado_u1 = 2;
            $match-> match_deshecho = 1;
            if ($match->match_id_usu2 === $u->id){
                $match->match_estado_u1 = 1;
                $match->match_estado_u2 = 2;
            }
            if($match->save()){
                return $match;
            }
            return ["error"=>"Ha habido un error al deshacer match"];

        }
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

    public function actionGet_new_match_users_list()
    {

        $m = new Mach();
        $m = $m->getUsersNoMostrados();
        $c = 0;

        //return ["status"=>"error"];
        return $m;
    }

    public function actionGetMatches()
    {
        $u = UsuarioController::getUserWhithAuthToken()["id"];
        return Mach::getUserMatches($u);
    }

    public function actionLikeDislike()
    {
        $params = json_decode(file_get_contents("php://input"), false);

        $u = UsuarioController::getUserWhithAuthToken("o");
        $post = $params->usuario_id ?? " ";
        $estado = isset($params->estado) ? $params->estado : 0;
        $u2 = isset($post) ? \app\models\Usuario::findOne(["id" => $post]) : " ";


        if ($m = Mach::findOne(["match_id_usu1" => $u2->id, "match_id_usu2" => $u->id])) {
            $now = date("Y-m-d H:i:s");
            $now = date("Y-m-d H:i:s", strtotime($now));
            $m->match_estado_u2 = $estado;
            $m->match_fecha = $now;
        }

        if ($m == null) {
            $m = new Mach();
            //$m->match_id=count(Mach::find()->asArray()->all());
            $m->match_id_usu1 = $u->id;
            $m->match_id_usu2 = $u2->id;
            $m->match_estado_u1 = $estado;
            $m->match_estado_u2 = 0;
        }

        if ($m->save() && $u->validateAuthToken($u->token)) {
            return ["status" => "ok"];
        } else {
            return ["error" => "Session caducada"];
        }
    }
}
