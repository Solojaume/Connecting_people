<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuario".
 *
 * @property int $id
 * @property string $email
 * @property int $password
 * @property int $token
 *
 * @property Comentario[] $comentarios
 */
class Usuario extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
           // [['imagen_src'], 'required'],
            [['imagen_src'], 'required', 'on' => 'create'],
            [['password', 'token'], 'string','max'=>64],
            [['email'], 'string', 'max' => 30],
            [['imagen_src'],'string', 'max'=>64],
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
            'token' => 'Token',
            'imagen_src'=> 'Imagen Src',
        ];
    }
    public static function findIdentityByAccessToken($token, $type = null)
    {
        Yii::debug('start calculating average revenue');
        //die();
        /*
        $u=static::findOne(['token' => $token]);
        var_dump($u);
        */
        return static::findOne(['token' => $token]);
    }
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
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }
    public function getId()
    {
        return $this->id;
    }
    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->id=count(self::find()->asArray()->all())+1;
            $this->email=uniqid();
            $this->password="123";
            $this->token=uniqid();
        }
        return parent::beforeSave($insert);
    }

    /**
     * Gets query for [[Comentarios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComentarios()
    {
        return $this->hasMany(Comentario::className(), ['id_usuario' => 'id']);
    }
}
