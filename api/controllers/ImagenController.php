<?php

namespace app\controllers;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
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

    public function actions() {
        $actions = parent::actions();
        //Eliminamos acciones de crear y eliminar apuntes. Eliminamos update para personalizarla
        unset($actions['delete'], $actions['create'],$actions['update'],$actions["get"]);
        // Redefinimos el método que prepara los datos en el index
        $actions['index']['prepareDataProvider'] = [$this, 'indexProvider'];
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
                        'deleteImagen' => ['POST'],
                        'getImagen'=>['POST'],
                        'subirImagen'=>['POST','FILES']
                    ],
                ],
            ]
        );
    }
   

    public function indexProvider($id) {
        $uid=Yii::$app->user->identity->id;

        return new ActiveDataProvider([
            'query' => Imagen::find()->where('imagen_id='.$id)->orderBy('imagen_id')
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
    public function actionDeleteImagen()
    {
        $params=json_decode(file_get_contents("php://input"), false);
        //echo "Params:";
        //var_dump($params);
        try {
            $imagen =  Imagen::find()->where("imagen_id = :imagen_id ",[":imagen_id"=>$params->imagen_id])->all();

        } catch (\Throwable $th) {
            //throw $th;
        }
        //echo "image:";
        //var_dump($imagen[0]);
        $imagen = $imagen[0];
        
        $dir_final = dirname(__FILE__)."\..\imagenes\\".$imagen->imagen_src;
        unlink($dir_final);
        $img_ret = $imagen;
       // echo"imagen->delete()";
        //var_dump($imagen->delete());
        $imagen->delete();
        
       // $this->findModel($params->imagen_id)->delete();

        return $img_ret;
    }

    //Este metodo sirbe para obtener las imagenes de usuario
    public function actionGetImagen(){
        $u=self::getUserWhithAuthToken();
        $usu= isset($_POST["id_usu"])?$_POST["id_usu"]:$u["id"];
        $im= new Imagen();
        return Imagen::getImagenUsuario($usu);
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
        $resultado = $this->compressImage($archivo["tmp_name"],$dir_final,95,550,750);

        //$resultado = move_uploaded_file($archivo["tmp_name"],$dir_final);
        

        /*
            //---------------------- DEV TOOLS ----------------------
        echo"Resultado:";
        var_dump($resultado);
        */
        
        if ($resultado) {
            $u = static::getUserWhithAuthToken();
            $model->imagen_usuario_id = $u["id"];
            $model->imagen_src = $cod;
            
            $model->imagen_localizacion_donde_subida="Interno";
            if ($model->save()) { 
                     
                return [
                    "status"=>"ok",
                    "imagen"=>$model
                ];
                
            }
            ///throw new Exception("Error");    
            return ["status"=>"error","error"=>"Error al guardar archivo"];
            
        } else {
            return ["error"=>"Error al subir archivo"];
        }
        
       

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

    /* 
    * Función personalizada para comprimir y 
    * subir una imagen mediante PHP
    */ 
    function compressImage($source, $destination, $quality, $with=500 ,$heitgh=500) { 
        // Obtenemos la información de la imagen
        $imgInfo = getimagesize($source); 
        $mime = $imgInfo['mime']; 

        // Creamos una imagen
        switch($mime){ 
            case 'image/jpeg': 
                $image = imagecreatefromjpeg($source); 
                break; 
            case 'image/png': 
                $image = imagecreatefrompng($source); 
                break; 
            case 'image/gif': 
                $image = imagecreatefromgif($source); 
                break; 
            default: 
                $image = imagecreatefromjpeg($source); 
        } 
        
        //resizamos la imagen
        $imagen_redimensionada=imagescale($image,$with,$heitgh)??$image;

       
        // Guardamos la imagen
        imagejpeg($imagen_redimensionada, $destination, $quality); 
        
        // Devolvemos la imagen comprimida
        return $destination; 
    } 
}
