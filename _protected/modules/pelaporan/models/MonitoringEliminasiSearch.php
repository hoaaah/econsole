<?php

namespace app\modules\pelaporan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RefPemda;
use app\models\EliminationAccount;

/**
 * MonitoringEliminasiSearch represents the model behind the search form about `app\models\RefPemda`.
 */
class MonitoringEliminasiSearch extends RefPemda
{

    public $akun_eliminasi;
    public $tahun;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'province_id', 'name', 'akun_eliminasi', 'tahun'], 'safe'],
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
        $query = RefPemda::find()
                ->select(['ref_pemda.id', 'ref_pemda.name', 'COUNT(b.kd_rek_1) AS province_id'])
                ->leftJoin("(SELECT * FROM elimination_account WHERE tahun = $this->tahun) b", 'ref_pemda.id = b.kd_pemda')
                ->groupBy('ref_pemda.id, ref_pemda.name');

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
        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'name', $this->name]);
        
        if($this->akun_eliminasi){
            // var_dump(is_numeric($this->akun_eliminasi));
            if(strpos($this->akun_eliminasi, '=') !== false || strpos($this->akun_eliminasi, '>') !== false || strpos($this->akun_eliminasi, '<') !== false) $query->having("COUNT(b.kd_rek_1) $this->akun_eliminasi");
            if(strpos($this->akun_eliminasi, ';') !== false || is_numeric($this->akun_eliminasi)){
                $this->akun_eliminasi = (int) $this->akun_eliminasi;
                $query->having(["COUNT(b.kd_rek_1)" => $this->akun_eliminasi]);
            }
        }

        return $dataProvider;
    }
}
