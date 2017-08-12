<?php

namespace app\modules\konsolidasi\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EliminationAccount;

/**
 * EliminationAccountSearch represents the model behind the search form about `app\models\EliminationAccount`.
 */
class EliminationAccountSearch extends EliminationAccount
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tahun', 'kd_pemda'], 'safe'],
            [['kd_rek_1', 'kd_rek_2', 'kd_rek_3', 'kd_rek_4', 'kd_rek_5'], 'integer'],
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
        $query = EliminationAccount::find();

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
            'tahun' => $this->tahun,
            'kd_rek_1' => $this->kd_rek_1,
            'kd_rek_2' => $this->kd_rek_2,
            'kd_rek_3' => $this->kd_rek_3,
            'kd_rek_4' => $this->kd_rek_4,
            'kd_rek_5' => $this->kd_rek_5,
        ]);

        $query->andFilterWhere(['like', 'kd_pemda', $this->kd_pemda]);

        return $dataProvider;
    }
}
