<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reporte".
 *
 * @property int $reporte_id
 * @property int $reporte_motivo_id
 * @property int $reporte_usuario_id
 * @property int $reporte_match_id
 * @property string $reporte_resolucion
 *
 * @property Mach $reporteMatch
 */
class Reporte extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reporte';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reporte_id', 'reporte_motivo_id', 'reporte_usuario_id', 'reporte_match_id', 'reporte_resolucion'], 'required'],
            [['reporte_id', 'reporte_motivo_id', 'reporte_usuario_id', 'reporte_match_id'], 'integer'],
            [['reporte_resolucion'], 'string', 'max' => 110],
            [['reporte_id'], 'unique'],
            [['reporte_match_id'], 'exist', 'skipOnError' => true, 'targetClass' => Mach::className(), 'targetAttribute' => ['reporte_match_id' => 'match_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'reporte_id' => 'Reporte ID',
            'reporte_motivo_id' => 'Reporte Motivo ID',
            'reporte_usuario_id' => 'Reporte Usuario ID',
            'reporte_match_id' => 'Reporte Match ID',
            'reporte_resolucion' => 'Reporte Resolucion',
        ];
    }

    /**
     * Gets query for [[ReporteMatch]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReporteMatch()
    {
        return $this->hasOne(Mach::className(), ['match_id' => 'reporte_match_id']);
    }
}
