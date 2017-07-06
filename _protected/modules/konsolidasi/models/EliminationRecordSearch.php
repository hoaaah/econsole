<?php

namespace app\modules\konsolidasi\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EliminationRecord;

/**
 * EliminationRecordSearch represents the model behind the search form about `app\models\EliminationRecord`.
 */
class EliminationRecordSearch extends EliminationRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'kd_provinsi', 'kd_pemda', 'user_id', 'created_at', 'updated_at'], 'integer'],
            [['tahun', 'no_elim', 'tgl_tetap'], 'safe'],
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
        $query = EliminationRecord::find();

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
            'id' => $this->id,
            'tahun' => $this->tahun,
            'tgl_tetap' => $this->tgl_tetap,
            'kd_provinsi' => $this->kd_provinsi,
            'kd_pemda' => $this->kd_pemda,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'no_elim', $this->no_elim]);

        return $dataProvider;
    }
}
