<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Mensajes;

/**
 * MensajesSearch represents the model behind the search form of `app\models\Mensajes`.
 */
class MensajesSearch extends Mensajes
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mensajes_id', 'mensajes_match_id', 'entregado', 'mensajes_usuario_id'], 'integer'],
            [['mensaje_contenido', 'timestamp'], 'safe'],
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
        $query = Mensajes::find();

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
            'mensajes_id' => $this->mensajes_id,
            'mensajes_match_id' => $this->mensajes_match_id,
            'timestamp' => $this->timestamp,
            'entregado' => $this->entregado,
            'mensajes_usuario_id' => $this->mensajes_usuario_id,
        ]);

        $query->andFilterWhere(['like', 'mensaje_contenido', $this->mensaje_contenido]);

        return $dataProvider;
    }
}
