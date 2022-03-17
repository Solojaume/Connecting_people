<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "imagen".
 *
 * @property int $imagen_id
 * @property int $imagen_usuario_id
 * @property string $imagen_src
 * @property string $imagen_timestamp
 *
 * @property Usuario $imagenUsuario
 */
class Imagen extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'imagen';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['imagen_usuario_id', 'imagen_src'], 'required'],
            [['imagen_id', 'imagen_usuario_id'], 'integer'],
            [['imagen_timestamp'], 'safe'],
            //[['imagen_src'], 'string', 'max' => 50],
            [['imagen_src'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
            [['imagen_id'], 'unique'],
            [['imagen_usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['imagen_usuario_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'imagen_id' => 'Imagen ID',
            'imagen_usuario_id' => 'Imagen Usuario ID',
            'imagen_src' => 'Imagen Src',
            'imagen_timestamp' => 'Imagen Timestamp',
        ];
    }

    /**
     * Gets query for [[ImagenUsuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImagenUsuario()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'imagen_usuario_id'])->queryAll();
    }
}
