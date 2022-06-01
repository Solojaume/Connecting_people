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
class ReporteController extends ApiController
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
                        'getReportes'=>['POST']
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

        $u=self::getUserWhithAuthToken("objeto");
        $motivo=isset($_POST["motivo_id"]) ? $_POST["motivo_id"] : null;
        $usuario=isset($_POST["usuario"]) ? $_POST["usuario"] : null;
        $match=isset($_POST["match"]) && !$usuario==null? Mach::find()->where("match_id = ".$_POST['match']. " && (match_id_usu1=".$usuario."||match_id_usu2=".$usuario.")")->asArray()->all():null;
        $resolucion = isset($_POST["resolucion"]) ? $_POST["resolucion"] : null;
        /*var_dump($resolucion);
        echo"reporte:";
        var_dump($reporte);
        die();*/
        if(isset($u['error'])){
            return $u['error'];
        } else if (($u->rol==0 && $u->hasRol(0) && $reporte->load(\Yii::$app->request->post(),''))||($u->rol==1 && $u->hasRol(1) && $reporte->load(\Yii::$app->request->post(),''))) {
             
            switch ($resolucion) {
                case 'culpable':
                    $u=new Usuario();
                    $u->activo=0;
                    $u->cad_token_recuperar_pass=null;
                    $u->token_recuperar_pass=null;
                    $u->save();
                   
                    $reporte->save();
                    break;
                   
                default:
                    $u=new Usuario();
                    $u->activo=0;
                    $u->cad_token_recuperar_pass=null;
                    $u->token_recuperar_pass=null;
                    $u->save();
                    $reporte->save();
                    break;
            }

               return ["status"=> "Se guardo correctamente"];
        }else if($u->hasRol(0)){
            return ["error"=>"No tienes permisos para realizar esta acción"];
        }
        return ["error"=>"No se pueden dejar vacias la resolucion y/o el reporte"];
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
     
    public function actionGetReportes()
    {
        if ($this->request->isPost) {
            $u=self::getUserWhithAuthToken("objeto");
            if(isset($u['error'])){
                return $u['error'];
            } else if ($u->rol==1&&$u->hasRol(1)) {
               $r= new Reporte();
               try {
                    $rep=$r->getReportes();
                } catch (\Throwable $th) {
                    return ["error"=>"No hay reportes"];
                }
                
              
                $rep=$rep[array_rand($rep)];//Faltan añadir los mensajes del match
                $men= new \app\models\Mensajes();
                $rep=["reporte"=>$rep,"mensajes"=>$men->getMensajesByMatch($rep["reporte_match_id"])];
               return $rep;
            }
            
        }
        else
            return ["error"=>"Algo ha salido mal"];
    }

    public function actionSetResolucion()
    {
        if ($this->request->isPost) {
            
            $u=self::getUserWhithAuthToken("objeto");
            $reporte=isset($_POST["reporte_id"]) ? Reporte::find()->where("reporte_id=".$_POST["reporte_id"])->asArray()->all() : null;
            $resolucion = isset($_POST["resolucion"]) ? $_POST["resolucion"] : null;
            /*var_dump($resolucion);
            echo"reporte:";
            var_dump($reporte);
            die();*/
            if(isset($u['error'])){
                return $u['error'];
            } else if ($u->rol==1 && $u->hasRol(1) && !$reporte==null && !$resolucion==null) {
               
                switch ($resolucion) {
                    case 'culpable':
                        $u=new Usuario();
                        $u->activo=0;
                        $u->cad_token_recuperar_pass=null;
                        $u->token_recuperar_pass=null;
                        $u->save();
                        $reporte->reporte_resolucion=$resolucion;
                        $reporte->save();
                        break;
                    
                    default:
                        $reporte->reporte_resolucion=$resolucion;
                        $reporte->save();
                        break;
                }

               return ["status"=> "Se guardo correctamente"];
            }else if($u->hasRol(0)){
                return ["error"=>"No tienes permisos para realizar esta acción"];
            }
            return ["error"=>"No se pueden dejar vacias la resolucion y/o el reporte"];
        }
    }
}
