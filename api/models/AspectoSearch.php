<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Aspecto;

/**
 * AspectoSearch represents the model behind the search form of `app\models\Aspecto`.
 */
class AspectoSearch extends Aspecto
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['aspecto_id'], 'integer'],
            [['aspecto_nombre'], 'safe'],
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
        $query = Aspecto::find();

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
            'aspecto_id' => $this->aspecto_id,
        ]);

        $query->andFilterWhere(['like', 'aspecto_nombre', $this->aspecto_nombre]);

        return $dataProvider;
    }
}
