<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;
/**
 * This is the model class for table "usuario".
 *
 * @property int $id
 * @property string $email
 * @property string $password
 * @property string $nombre
 * @property int $rol
 * @property string $timestamp_nacimiento
 * @property string|null $token
 * @property string $cad_token
 * @property string|null $token_recuperar_pass
 * @property string $cad_token_recuperar_pass
 * @property int|null $activo
 *
 * @property Imagen[] $imagens
 * @property Mach[] $maches
 * @property Mach[] $maches0
 * @property Review[] $reviews
 */
class Usuario extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuario';
    }

    
    //Encontrar usuario por token
    public static function findIdentityByAccessToken($token, $type = null) {
        return self::findOne(['token' => $token]);
    }
    
    //Encontrar usuario por token de recuperación
    public static function findIdentityByRecoveryToken($token){
        return self::findOne(['token_recuperar_pass'=>$token]);
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }    

    public static function findIdentityById($id)
    {
        return Yii::$app->db->createCommand("SELECT * from usuario where id=$id")->queryAll();
    }

    public static function findIdentityBySocket($ip_cli, $ip_ser, $puer_cli,$puer_serv)
    {   
        return self::findOne(["ip_cliente"=>$ip_cli,"ip_servidor"=>$ip_ser,"puerto_cliente"=>$puer_cli,"puerto_servidor"=>$puer_serv]);
        return Yii::$app->db->createCommand(
            "SELECT * FROM usuario where ip_cliente=$ip_cli && ip_servidor=$ip_ser && puerto_cliente=$puer_cli && puerto_servidor=$puer_serv"
        )->queryAll();
        return self::findIdentity($u[0]["id"]);
    }
    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    }

    

    /**
     * @return string|null current user auth key
     */
    public function getAuthKey()
    {
        return $this->password;
    }
    

    public function validateCaducityDateAuthToken()
    {   
        //date_default_timezone_set('UTC');
        $date = strtotime($this->cad_token);
        $now = strtotime(date("Y-m-d H:i:s"));
        //echo "NOW:$now";
        //echo " Date:$date";
        return $now<$date;
    } 

    public function validateCaducityDateRecoveryToken()
    {
        //date_default_timezone_set('UTC ');
        $date = strtotime($this->cad_token_recuperar_pass);
        $now = strtotime(date("Y-m-d H:i:s"));
        return $now<$date;
    }

    public function validateAuthToken($token){
        echo "validate";
        $con=$this->token==$token;
        $con2=$this->validateCaducityDateAuthToken()==true;
        return $con && $con2;
    }

    public function validateRecoveryToken($token){
        return ($this->token_recuperar_pass===$token)&&($this->validateCaducityDateRecoveryToken()==true);
    }

    public function getRolUsuario(){//sirve para mostrar "administrador" en vez de "1", etc
        if ($this->rol == 1) {
            return "Administrador";
        }else if($this->rol == 0){
            return "Usuario";
        }
    }
    
    //Sirve para comparar el rol del usuario con el pasado por parametro
    public function hasRol($role){
        return $this->rol == $role;
    }

    /**
     * @param string $authKey
     * @return bool|null if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public static function DisconectAll()
    {
        self::updateAll(['ip_cliente'=> "",'ip_servidor'=>"", 'puerto_cliente'=>"",'puerto_servidor'=>""]);
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ 'email', 'password', 'nombre'], 'required'],
            [['id', 'rol', 'activo'], 'integer'],
            [['timestamp_nacimiento', 'cad_token', 'cad_token_recuperar_pass'], 'safe'],
            [['email'], 'string', 'max' => 100],
            [['password'], 'string', 'max' => 64],
            [['nombre'], 'string', 'max' => 11],
            [['ip_cliente','ip_servidor'], 'string', 'max' => 16],
            [['puerto_cliente','puerto_servidor'], 'string', 'max' => 6],
            [['token'], 'string', 'max' => 100],
            [['token_recuperar_pass'], 'string', 'max' => 100],
            [['email'], 'unique'],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'password' => 'Password',
            'nombre' => 'Nombre',
            'rol' => 'Rol',
            'timestamp_nacimiento' => 'Timestamp Nacimiento',
            'token' => 'Token',
            'cad_token' => 'Cad Token',
            'token_recuperar_pass' => 'Token Recuperar Pass',
            'cad_token_recuperar_pass' => 'Cad Token Recuperar Pass',
            'activo' => 'Activo',
            'ip_cliente'=> 'IP Cliente',
            'puerto_cliente'=>'Puerto Cliente',
            'ip_servidor'=> 'IP Servidor',
            'puerto_servidor'=>'Puerto Servidor',
        ];
    }
    public function beforeSave($insert){
        if ($this->isNewRecord) {
            $now=\app\controllers\UsuarioController::generarCadToken("+ 30 minutes");
            $this->cad_token_recuperar_pass = $now;
            //Se genera el token que permite recuperar la contraseeña en este caso se usa para activar la cuenta
            $this->token_recuperar_pass = \app\controllers\UsuarioController::generateToken();
            //Se cifra la contraseña
            $this->password=\app\controllers\UsuarioController::sha256($this->password);
            $this->id = count(Usuario::find()->asArray()->all());
            $this->rol=0;//0 es usuario registrado 1 es admin
            $this->activo=0;
        }
        //echo"";
        //var_dump($this);
        return parent::beforeSave($insert);
        //return ["status"=>"ok","mensaje"=>"Ha sido activado satisfactoriamente"];
    }

    /**
     * Gets query for [[Imagens]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImagenes()
    {
        return $this->hasMany(Imagen::className(), ['imagen_usuario_id' => 'id']);
    }

    /**
     * Gets query for [[Maches]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMaches()
    {
        return $this->hasMany(Mach::className(), ['match_id_usu1' => 'id']);
    }

    /**
     * Gets query for [[Maches0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMaches0()
    {
        return $this->hasMany(Mach::className(), ['match_id_usu2' => 'id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Review::className(), ['review_usuario_id' => 'id']);
    }
}
