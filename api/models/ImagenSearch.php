<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Imagen;

/**
 * ImagenSearch represents the model behind the search form of `app\models\Imagen`.
 */
class ImagenSearch extends Imagen
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['imagen_id', 'imagen_usuario_id'], 'integer'],
            [['imagen_src', 'imagen_timestamp'], 'safe'],
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
        $query = Imagen::find();

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
            'imagen_id' => $this->imagen_id,
            'imagen_usuario_id' => $this->imagen_usuario_id,
            'imagen_timestamp' => $this->imagen_timestamp,
        ]);

        $query->andFilterWhere(['like', 'imagen_src', $this->imagen_src]);

        return $dataProvider;
    }
}
