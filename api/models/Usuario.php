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
    public static function findIdentity($id)
    {
        return static::findOne($id);
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

    /**
     * @param string $authKey
     * @return bool|null if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'email', 'password', 'nombre'], 'required'],
            [['id', 'rol', 'activo'], 'integer'],
            [['timestamp_nacimiento', 'cad_token', 'cad_token_recuperar_pass'], 'safe'],
            [['email'], 'string', 'max' => 100],
            [['password'], 'string', 'max' => 110],
            [['nombre'], 'string', 'max' => 11],
            [['token'], 'string', 'max' => 60],
            [['token_recuperar_pass'], 'string', 'max' => 32],
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
        ];
    }

    /**
     * Gets query for [[Imagens]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImagens()
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
