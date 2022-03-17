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
            [['aspecto_nombre','puntuacion_maxima', 'puntuacion_minima' ], 'required'],
            [['aspecto_id','puntuacion_maxima','puntuacion_minima'], 'integer'],
            [['aspecto_nombre'], 'string', 'max' => 12],
            [['aspecto_id'], 'unique'],
        ];
    }
    public function beforeSave($insert){
        if($this->isNewRecord){
            $this->aspecto_id=count(self::find()->asArray()->all());
        }
        return parent::beforeSave($insert);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'aspecto_id' => 'Aspecto ID',
            'aspecto_nombre' => 'Aspecto Nombre',
            'puntuacion_minima' => 'Puntuacion Minima',
            'puntuacion_maxima' => 'Puntuacion Maxima'
        ];
    }

    /*Obtener aspecto por Id*/
    public static function getAspectoById( $id = null)
    {
        return self::findOne('aspecto_id='.$id);
    }

    public function getTodosAspectos()
    {
       return self::find()->asArray()->all();
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
