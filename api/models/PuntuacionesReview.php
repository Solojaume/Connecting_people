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
            [['puntuaciones_review_aspecto_id', 'puntuaciones_review_puntuacion', 'puntuaciones_review_review_id'], 'required'],
            [['puntuaciones_review_id', 'puntuaciones_review_aspecto_id', 'puntuaciones_review_puntuacion', 'puntuaciones_review_review_id'], 'integer'],
            //[['puntuaciones_review_id'], 'unique'],
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
    public function getPuntuacionReviewAspecto()
    {
        return $this->hasOne(Aspecto::className(), ['aspecto_id' => 'puntuaciones_review_aspecto_id']);
    }

    //Sirve para obtener todas las puntuaciones de una review
    public function getPuntuacionesReview( $review = null)
    {
        return self::find("puntuaciones_review_review_id=".$review)->asArray()->all();
    }

    public function getCountPuntuaciones( $review = null)
    {
        //var_dump(self::find("puntuaciones_review_review_id=".$review)->asArray());
       // die();
        return count(self::find("puntuaciones_review_review_id=".$review)->asArray()->all());
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

    
    public function beforeSave($insert=null)
    {
        if ($this->isNewRecord) {
            $this->puntuaciones_review_id=count(PuntuacionesReview::find()->asArray()->all())+1;
        }
        return parent::beforeSave($insert);
    }
}
