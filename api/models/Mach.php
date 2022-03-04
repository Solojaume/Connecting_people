<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mach".
 *
 * @property int $match_id
 * @property int $match_id_usu1
 * @property int $match_id_usu2
 * @property int $match_estado_u1
 * @property int $match_estado_u2
 * @property string $match_fecha
 *
 * @property Usuario $matchIdUsu1
 * @property Usuario $matchIdUsu2
 * @property Mensajes[] $mensajes
 * @property Reporte[] $reportes
 */
class Mach extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mach';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['match_id', 'match_id_usu1', 'match_id_usu2', 'match_estado_u1'], 'required'],
            [['match_id', 'match_id_usu1', 'match_id_usu2', 'match_estado_u1', 'match_estado_u2'], 'integer'],
            [['match_fecha'], 'safe'],
            [['match_id'], 'unique'],
            [['match_id_usu1'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['match_id_usu1' => 'id']],
            [['match_id_usu2'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['match_id_usu2' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'match_id' => 'Match ID',
            'match_id_usu1' => 'Match Id Usu1',
            'match_id_usu2' => 'Match Id Usu2',
            'match_estado_u1' => 'Match Estado U1',
            'match_estado_u2' => 'Match Estado U2',
            'match_fecha' => 'Match Fecha',
        ];
    }
    public static function gestUerMatches($uid)
    {
        $m=Yii::$app->db->createCommand(
            "SELECT * from mach where match_id_usu1=$uid AND match_estado_u1=1 AND match_estado_u2=1 or match_id_usu2=$uid AND match_estado_u1=1 AND match_estado_u2=1"
        )->queryAll();
        return $m;
    }
    public static function getUsersNoMostrados($entorno="prod",$data=null){
        $lista_usuarios=[];
        $usuario=["id"=>0,
        "nombre"=>"",
        "edad"=>0,
        "imagenes"=>[],
        "review"=>[]];
        $usuario1 = \app\controllers\UsuarioController::getUserWhithAuthToken()["usuario"]["id"];
        //var_dump($usuario1);
       // $usuario1=$usuario1->id;
        if($entorno === "test" && $data!==null){
            for ($i=0; $i < $data; $i++) { 
                $lista_usuarios[]=$usuario;
            }
        }else {
            $lista_usuarios=Yii::$app->db->createCommand(
                "SELECT id,nombre,timestamp_nacimiento FROM usuario as u LEFT JOIN mach as m on m.match_id_usu1 = u.id where u.id!=$usuario1 and 
                (not EXISTS (SELECT id,nombre,timestamp_nacimiento FROM usuario as u2 LEFT JOIN mach as m2 on m2.match_id_usu1 = u.id WHERe m2.match_estado_u1=1 and u.id=$usuario1) AND NOT EXISTS 
                (SELECT id,nombre,timestamp_nacimiento FROM usuario as u2 LEFT JOIN mach as m3 on m3.match_id_usu1 = u.id WHERe m3.match_estado_u1=2 and u.id=$usuario1) AND NOT EXISTS 
                (SELECT id,nombre,timestamp_nacimiento FROM usuario as u2 LEFT JOIN mach as m4 on m4.match_id_usu2 = u.id WHERe m4.match_estado_u1=2 and m4.match_id_usu2=$usuario1));
                "
            )->queryAll();
           // $lista_usuarios=Usuario::find("*")->where("id!=$usuario1"));
            //var_dump($lista_usuarios);
            //die();

            $us=[];
            $us[]=["id"=>$lista_usuarios[0]["id"],"timestamp_nacimiento"=>$lista_usuarios[0]["timestamp_nacimiento"],"nombre"=>$lista_usuarios[0]["nombre"],"imagenes"=>[],"reviews"=>[]];
            //die();
    
            foreach ($lista_usuarios as $key ) {
                $bol=false;
                for ($i=0; $i <count($us) ; $i++) { 
                    if($us[$i]["id"]!=$key["id"]){
                        //var_dump($i);
                        //$us[]=$key; 
                        $bol=true;
                    }else{
                        $bol=false;
                        //var_dump($i);
                    }
                }
                if ($bol==true) {
                    $key["imagenes"]=[];
                    $key["reviews"]=[];
                    $us[]=$key; 
                 }  
                
                //var_dump($key);
                
            }
            $lista_usuarios=$us;
        }
        
        //die();
        
        return $lista_usuarios;
    }

    /**
     * Gets query for [[MatchIdUsu1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMatchIdUsu1()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'match_id_usu1']);
    }

    /**
     * Gets query for [[MatchIdUsu2]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMatchIdUsu2()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'match_id_usu2']);
    }

    /**
     * Gets query for [[Mensajes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMensajes()
    {
        return $this->hasMany(Mensajes::className(), ['mensajes_match_id' => 'match_id']);
    }

    /**
     * Gets query for [[Reportes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReportes()
    {
        return $this->hasMany(Reporte::className(), ['reporte_match_id' => 'match_id']);
    }
    public function beforeSave($insert){
        if ($this->isNewRecord) {
            $this->id=count(Mach::find()->asArray()->all());
        }
        return parent::beforeSave($insert);
    }
}
