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
            [['mensajes_id', 'mensajes_match_id', 'mensaje_contenido', 'mensajes_usuario_id'], 'required'],
            [['mensajes_id', 'mensajes_match_id', 'entregado', 'mensajes_usuario_id'], 'integer'],
            [['timestamp'], 'safe'],
            [['mensaje_contenido'], 'string', 'max' => 11],
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

    /**
     * Gets query for [[MensajesMatch]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMensajesMatch()
    {
        return $this->hasOne(Mach::className(), ['match_id' => 'mensajes_match_id']);
    }
}
