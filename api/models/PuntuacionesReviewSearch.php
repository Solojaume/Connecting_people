<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\puntuacionesReview;

/**
 * PuntuacionesReviewSearch represents the model behind the search form of `app\models\puntuacionesReview`.
 */
class PuntuacionesReviewSearch extends puntuacionesReview
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['puntuaciones_review_id', 'puntuaciones_review_aspecto_id', 'puntuaciones_review_puntuacion', 'puntuaciones_review_review_id'], 'integer'],
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
        $query = puntuacionesReview::find();

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
            'puntuaciones_review_id' => $this->puntuaciones_review_id,
            'puntuaciones_review_aspecto_id' => $this->puntuaciones_review_aspecto_id,
            'puntuaciones_review_puntuacion' => $this->puntuaciones_review_puntuacion,
            'puntuaciones_review_review_id' => $this->puntuaciones_review_review_id,
        ]);

        return $dataProvider;
    }
}
