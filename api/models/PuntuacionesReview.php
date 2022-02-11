<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "puntuaciones_review".
 *
 * @property int $puntuaciones_review_id
 * @property int $puntuaciones_review_aspecto_id
 * @property int $puntuaciones_review_puntuacion
 * @property int $puntuaciones_review_review_id
 *
 * @property Aspecto $puntuacionesReviewAspecto
 * @property Review $puntuacionesReviewReview
 */
class PuntuacionesReview extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'puntuaciones_review';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['puntuaciones_review_id', 'puntuaciones_review_aspecto_id', 'puntuaciones_review_puntuacion', 'puntuaciones_review_review_id'], 'required'],
            [['puntuaciones_review_id', 'puntuaciones_review_aspecto_id', 'puntuaciones_review_puntuacion', 'puntuaciones_review_review_id'], 'integer'],
            [['puntuaciones_review_id'], 'unique'],
            [['puntuaciones_review_review_id'], 'exist', 'skipOnError' => true, 'targetClass' => Review::className(), 'targetAttribute' => ['puntuaciones_review_review_id' => 'review_id']],
            [['puntuaciones_review_aspecto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Aspecto::className(), 'targetAttribute' => ['puntuaciones_review_aspecto_id' => 'aspecto_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'puntuaciones_review_id' => 'Puntuaciones Review ID',
            'puntuaciones_review_aspecto_id' => 'Puntuaciones Review Aspecto ID',
            'puntuaciones_review_puntuacion' => 'Puntuaciones Review Puntuacion',
            'puntuaciones_review_review_id' => 'Puntuaciones Review Review ID',
        ];
    }

    /**
     * Gets query for [[PuntuacionesReviewAspecto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPuntuacionesReviewAspecto()
    {
        return $this->hasOne(Aspecto::className(), ['aspecto_id' => 'puntuaciones_review_aspecto_id']);
    }

    /**
     * Gets query for [[PuntuacionesReviewReview]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPuntuacionesReviewReview()
    {
        return $this->hasOne(Review::className(), ['review_id' => 'puntuaciones_review_review_id']);
    }
}
