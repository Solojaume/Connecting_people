<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mach".
 *
 * @property int $match_id
 * @property int $match_id_usu1
 * @property int $match_id_usu2
 * @property int $match_estado_u1
 * @property int $match_estado_u2
 * @property string $match_fecha
 *
 * @property Usuario $matchIdUsu1
 * @property Usuario $matchIdUsu2
 * @property Mensajes[] $mensajes
 * @property Reporte[] $reportes
 */
class Mach extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mach';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['match_id', 'match_id_usu1', 'match_id_usu2', 'match_estado_u1'], 'required'],
            [['match_id', 'match_id_usu1', 'match_id_usu2', 'match_estado_u1', 'match_estado_u2'], 'integer'],
            [['match_fecha'], 'safe'],
            [['match_id'], 'unique'],
            [['match_id_usu1'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['match_id_usu1' => 'id']],
            [['match_id_usu2'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['match_id_usu2' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'match_id' => 'Match ID',
            'match_id_usu1' => 'Match Id Usu1',
            'match_id_usu2' => 'Match Id Usu2',
            'match_estado_u1' => 'Match Estado U1',
            'match_estado_u2' => 'Match Estado U2',
            'match_fecha' => 'Match Fecha',
        ];
    }

    /**
     * Gets query for [[MatchIdUsu1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMatchIdUsu1()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'match_id_usu1']);
    }

    /**
     * Gets query for [[MatchIdUsu2]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMatchIdUsu2()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'match_id_usu2']);
    }

    /**
     * Gets query for [[Mensajes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMensajes()
    {
        return $this->hasMany(Mensajes::className(), ['mensajes_match_id' => 'match_id']);
    }

    /**
     * Gets query for [[Reportes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReportes()
    {
        return $this->hasMany(Reporte::className(), ['reporte_match_id' => 'match_id']);
    }
}
