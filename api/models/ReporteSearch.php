<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Reporte;

/**
 * ReporteSearch represents the model behind the search form of `app\models\Reporte`.
 */
class ReporteSearch extends Reporte
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reporte_id', 'reporte_motivo_id', 'reporte_usuario_id', 'reporte_match_id'], 'integer'],
            [['reporte_resolucion'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Reporte::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'reporte_id' => $this->reporte_id,
            'reporte_motivo_id' => $this->reporte_motivo_id,
            'reporte_usuario_id' => $this->reporte_usuario_id,
            'reporte_match_id' => $this->reporte_match_id,
        ]);

        $query->andFilterWhere(['like', 'reporte_resolucion', $this->reporte_resolucion]);

        return $dataProvider;
    }
}
