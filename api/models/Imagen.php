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
 * @property string $imagen_localizacion_donde_subida 
 * Esta properti puede ser "Interno" haciendo referencia a que estan en la carpeta de imagenes del proyecto o 
 * "Externo" que se guardan en un servidor de terceros y bajo otro dominio.
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
            [['imagen_src'], 'string', 'max' => 100],
            [['imagen_localizacion_donde_subida'], 'string', 'max' => 12],
            //[['imagen_src'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, gif'],
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
            "imagen_localizacion_donde_subida" => "Imagen Localizacion Donde Subida"
        ];
    }

    /**
     * Gets query for [[ImagenUsuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public static function getImagenUsuario($u_id)
    {
        return Yii::$app->db->createCommand("SELECT * FROM `imagen` WHERE `imagen_usuario_id` = $u_id")->queryAll();
    }
}
