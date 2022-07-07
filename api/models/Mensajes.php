<?php

namespace app\models;

use Yii;



/**
 * This is the model class for table "mensajes".
 *
 * @property int $mensajes_id
 * @property int $mensajes_match_id
 * @property string $mensaje_contenido
 * @property string $timestamp
 * @property int $entregado
 * @property int $mensajes_usuario_id
 *
 * @property Mach $mensajesMatch
 */
class Mensajes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mensajes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mensajes_match_id', 'mensaje_contenido'], 'required'],
            [['mensajes_id', 'mensajes_match_id', 'entregado', 'mensajes_usuario_id'], 'integer'],
            [['timestamp'], 'safe'],
            [['mensaje_contenido'], 'string', 'max' => 256],
            [['mensajes_id'], 'unique'],
            [['mensajes_match_id'], 'exist', 'skipOnError' => true, 'targetClass' => Mach::className(), 'targetAttribute' => ['mensajes_match_id' => 'match_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'mensajes_id' => 'Mensajes ID',
            'mensajes_match_id' => 'Mensajes Match ID',
            'mensaje_contenido' => 'Mensaje Contenido',
            'timestamp' => 'Timestamp',
            'entregado' => 'Entregado',
            'mensajes_usuario_id' => 'Mensajes Usuario ID',
        ];
    }

    public function beforeSave($insert = null)
    {
        if ($this->isNewRecord) {
            $fecha_actual = date("Y-m-d H:i:s");
            $now = date("Y-m-d H:i:s",strtotime($fecha_actual."+ 1 second")); 
            //$now=\app\controllers\UsuarioController::generarCadToken("+ 1 secon");
            $this->mensajes_id=count(Mensajes::find()->asArray()->all())+1;
            $this->entregado=0;
            $this->timestamp = $now;
            $this->mensajes_usuario_id=\app\controllers\MensajesController::getUserWhithAuthToken()["id"];
        }
        return parent::beforeSave($insert);
    }
    /**
     * Gets query for [[MensajesMatch]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMensajesMatch()
    {
        return $this->hasOne(Mach::className(), ['match_id' => 'mensajes_match_id']);
    }
    //Obtener  los mensages pasando
    public static function getMensajesByMatch($match){
        echo "\n GetMensajesBYMatch";
        $sql= Yii::$app->db->createCommand("SELECT * from mensajes where mensajes_match_id=$match")->queryAll();
        return $sql;
        //return (new \yii\db\Query()) -> select("mensajes_id,mensajes_match_id,mensaje_contenido,timestamp,mensajes_usuario_id,entregado") -> from("mensajes") -> where("mensajes_match_id = $match");
    }

    public static function getMensajesByUserId($usu){
       // $q=new \yii\db\Query();
        $sql= Yii::$app->db->createCommand("SELECT mensajes_id,mensajes_match_id,mensaje_contenido,timestamp,mensajes_usuario_id,entregado FROM `mensajes` INNER JOIN MACH  on mensajes_match_id=match_id where (match_id_usu2=$usu or match_id_usu1=$usu)" )->queryAll();
        return $sql;
        /*return new \yii\data\ActiveDataProvider([
        'query'=>
            $q->select("mensajes_id,mensajes_match_id,mensaje_contenido,timestamp,mensajes_usuario_id,entregado")->from("mensajes")->innerJoin("mach","mensajes_match_id=match_id")->where("match_id_usu1= $usu || match_id_usu2= $usu")
        ]);*/
    }
    
    public static function getNoRecivedMensajesByUserId($usu){
        $sql=Yii::$app->db->createCommand("SELECT mensajes_id,mensajes_match_id,mensaje_contenido,timestamp,mensajes_usuario_id,entregado FROM `mensajes` INNER JOIN MACH  on mensajes_match_id=match_id where (match_id_usu2=$usu or match_id_usu1=$usu)
        AND entregado=0 AND mensajes_usuario_id!=$usu")->queryAll();
        return $sql;
        /*return (new \yii\db\Query()) -> select("mensajes_id,mensajes_match_id,mensaje_contenido,timestamp,mensajes_usuario_id,entregado") -> from("mensajes") -> innerJoin("mach","mensajes_match_id=match_id") -> 
        where("(match_id_usu1= $usu && entregado = 0 ) || (match_id_usu2= $usu && entregado = 0)");
        */
    }
    public static function getCountMensajesByUserId($usu){
        return (new \yii\db\Query()) -> count("mensajes_id") -> from("mensajes") -> innerJoin("mach","mensajes_match_id=match_id") -> 
        where("match_id_usu1= $usu || match_id_usu2= $usu");
    }
    
    public static function getCountNoRecivedMensagesByUserId($usu){
        $sql= Yii::$app->db->createCommand("SELECT count(mensajes_id) FROM `mensajes` INNER JOIN MACH  on mensajes_match_id=match_id where (match_id_usu2=$usu or match_id_usu1=$usu) AND entregado=0")->queryAll();
        return $sql;
        return (new \yii\db\Query()) -> select( count("mensajes_id")) -> from("mensajes") -> innerJoin("mach","mensajes_match_id=match_id") -> 
        where("(match_id_usu1= $usu && entregado = 0 ) || (match_id_usu2= $usu && entregado = 0)");

    }
    public static function getCountMensajesByMatch($match){
        return (new \yii\db\Query())-> count("mensajes_id") -> from("mensajes") -> where("mensajes_match_id = $match");
    }
    public static function getCountMensajes(){
        return (new \yii\db\Query()) -> count("mensajes_id") -> from("mensajes");
    }

    
}
