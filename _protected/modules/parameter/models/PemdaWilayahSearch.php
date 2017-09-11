<?php

namespace app\modules\parameter\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PemdaWilayah;

/* (C) Copyright 2017 Heru Arief Wijaya (http://belajararief.com/) untuk Indonesia.*/
/**
 * PemdaWilayahSearch represents the model behind the search form about `app\models\PemdaWilayah`.
 */
class PemdaWilayahSearch extends PemdaWilayah
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['wilayah_id'], 'integer'],
            [['pemda_id'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = PemdaWilayah::find();

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
            'wilayah_id' => $this->wilayah_id,
        ]);

        $query->andFilterWhere(['like', 'pemda_id', $this->pemda_id]);

        return $dataProvider;
    }
}
