<?php

namespace app\modules\parameter\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RefAkrual3;

/**
 * RefAkrual3Search represents the model behind the search form about `app\models\RefAkrual3`.
 */
class RefAkrual3Search extends RefAkrual3
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kd_akrual_1', 'kd_akrual_2', 'kd_akrual_3'], 'integer'],
            [['nm_akrual_3', 'saldoNorm'], 'safe'],
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
        $query = RefAkrual3::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'kd_akrual_1' => $this->kd_akrual_1,
            'kd_akrual_2' => $this->kd_akrual_2,
            'kd_akrual_3' => $this->kd_akrual_3,
        ]);

        $query->andFilterWhere(['like', 'nm_akrual_3', $this->nm_akrual_3])
            ->andFilterWhere(['like', 'saldoNorm', $this->saldoNorm]);

        return $dataProvider;
    }
}
