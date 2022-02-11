<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Mach;

/**
 * MachSearch represents the model behind the search form of `app\models\Mach`.
 */
class MachSearch extends Mach
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['match_id', 'match_id_usu1', 'match_id_usu2', 'match_estado_u1', 'match_estado_u2'], 'integer'],
            [['match_fecha'], 'safe'],
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
        $query = Mach::find();

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
            'match_id' => $this->match_id,
            'match_id_usu1' => $this->match_id_usu1,
            'match_id_usu2' => $this->match_id_usu2,
            'match_estado_u1' => $this->match_estado_u1,
            'match_estado_u2' => $this->match_estado_u2,
            'match_fecha' => $this->match_fecha,
        ]);

        return $dataProvider;
    }
}
