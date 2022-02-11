<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "aspecto".
 *
 * @property int $aspecto_id
 * @property string $aspecto_nombre
 *
 * @property PuntuacionesReview[] $puntuacionesReviews
 */
class Aspecto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'aspecto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['aspecto_id', 'aspecto_nombre'], 'required'],
            [['aspecto_id'], 'integer'],
            [['aspecto_nombre'], 'string', 'max' => 12],
            [['aspecto_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'aspecto_id' => 'Aspecto ID',
            'aspecto_nombre' => 'Aspecto Nombre',
        ];
    }

    /**
     * Gets query for [[PuntuacionesReviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPuntuacionesReviews()
    {
        return $this->hasMany(PuntuacionesReview::className(), ['puntuaciones_review_aspecto_id' => 'aspecto_id']);
    }
}
