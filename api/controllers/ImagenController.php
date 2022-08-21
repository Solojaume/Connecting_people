<?php

namespace app\controllers;
use yii\rest\ActiveController;
use app\models\Imagen;
use app\models\ImagenSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ImagenController implements the CRUD actions for Imagen model.
 */
class ImagenController extends ApiController
{
    public $modelClass='app\models\Imagen';

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
                        'getImagen'=>['POST'],
                        'subirImagen'=>['POST','FILES']
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Imagen models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ImagenSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Imagen model.
     * @param int $imagen_id Imagen ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($imagen_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($imagen_id),
        ]);
    }

    /**
     * Creates a new Imagen model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Imagen();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'imagen_id' => $model->imagen_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Imagen model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $imagen_id Imagen ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($imagen_id)
    {
        $model = $this->findModel($imagen_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'imagen_id' => $model->imagen_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Imagen model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $imagen_id Imagen ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($imagen_id)
    {
        $this->findModel($imagen_id)->delete();

        return $this->redirect(['index']);
    }

    //Este metodo sirbe para obtener las imagenes de usuario
    public function actionGetImagen(){
        $u=self::getUserWhithAuthToken();
        $usu= isset($_POST["id_usu"])?$_POST["id_usu"]:$u["id"];
        $im= new Imagen();
        return $im->getImagenUsuario();
    }

    public function actionSubirImagen(){
        $model= new Imagen();
        //$model->imagen_src = UploadedFile::getInstance($model, 'imagen_src'); 
       
        /*
            //---------------------- DEV TOOLS ----------------------
        echo "FILES:";
        var_dump($_FILES); 
        */
        $archivo = $_FILES["file0"];
        
        switch ($archivo["type"]) {
            case "image/jpeg":
                $extension=".jpg";
                break;
            case "image/png":
                $extension=".png";
                break;
                
            default:
                return ["error"=>"Por favor suba una imagen"];
                break;
        }
        $cod = static::sha256(uniqid("",true).$archivo["name"].uniqid()).$extension;
        $dir_final = dirname(__FILE__)."\..\imagenes\\".$cod;
        $resultado = move_uploaded_file($archivo["tmp_name"],$dir_final);


        /*
            //---------------------- DEV TOOLS ----------------------
        echo"Resultado:";
        var_dump($resultado);
        */
        
        if ($resultado) {
            return ["status"=>"ok"];
            if($model->load(\Yii::$app->request->post(),'')) {
                // var_dump($model->imagen_src);
                // die();
                
                 $model->imagen_src->saveAs('../web/imagenes/' . $cod . '.' . $model->imagen_src->extension);
                 
                 $model->imagen_src = $cod . '.' . $model->imagen_src->extension;
     
                if ($model->save()) {            
                    return $this->redirect(['view', 'id' => $model->id]);
                }    
            }
        } else {
            return ["error"=>"Error al subir archivo"];
        }
        
       

    }
     
    public function actionDeleteImagen(){
        return "";
    }

    /**                                             
     * Finds the Imagen model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $imagen_id Imagen ID
     * @return Imagen the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($imagen_id)
    {
        if (($model = Imagen::findOne(['imagen_id' => $imagen_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
