<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "review".
 *
 * @property int $review_id
 * @property string $review_descripcion
 * @property int $review_usuario_id
 *
 * @property PuntuacionesReview[] $puntuacionesReviews
 * @property Usuario $reviewUsuario
 */
class Review extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'review';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['review_id', 'review_descripcion', 'review_usuario_id'], 'required'],
            [['review_id', 'review_usuario_id'], 'integer'],
            [['review_descripcion'], 'string', 'max' => 11],
            [['review_id'], 'unique'],
            [['review_usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['review_usuario_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'review_id' => 'Review ID',
            'review_descripcion' => 'Review Descripcion',
            'review_usuario_id' => 'Review Usuario ID',
        ];
    }

    /**
     * Gets query for [[PuntuacionesReviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPuntuacionesReviews()
    {
        return $this->hasMany(PuntuacionesReview::className(), ['puntuaciones_review_review_id' => 'review_id']);
    }

    /**
     * Gets query for [[ReviewUsuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviewUsuario()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'review_usuario_id']);
    }
}
