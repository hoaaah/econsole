<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "elimination_account".
 *
 * @property string $tahun
 * @property string $kd_pemda
 * @property integer $kd_rek_1
 * @property integer $kd_rek_2
 * @property integer $kd_rek_3
 * @property integer $kd_rek_4
 * @property integer $kd_rek_5
 */
class EliminationAccount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'elimination_account';
    }

    public $kd3;
    public $kd4;
    public $kd5;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tahun', 'kd_pemda', 'kd_rek_1', 'kd_rek_2', 'kd_rek_3', 'kd_rek_4', 'kd_rek_5'], 'required'],
            [['tahun'], 'safe'],
            [['kd_rek_1', 'kd_rek_2', 'kd_rek_3', 'kd_rek_4', 'kd_rek_5'], 'integer'],
            [['kd_pemda', 'kd3', 'kd4', 'kd5'], 'string', 'max' => 11],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tahun' => 'Tahun',
            'kd_pemda' => 'Kd Pemda',
            'kd_rek_1' => 'Kd Rek 1',
            'kd_rek_2' => 'Kd Rek 2',
            'kd_rek_3' => 'Kd Rek 3',
            'kd_rek_4' => 'Kd Rek 4',
            'kd_rek_5' => 'Kd Rek 5',
            'kd3' => 'Jenis',
            'kd4' => 'Objek',
            'kd5' => 'Rincian Objek',  
        ];
    }


    public function getPemda()
    {
        return $this->hasOne(\app\models\RefPemda::className(), ['id' => 'kd_pemda']);
    }

    public function getRek3()
    {
        return $this->hasOne(\app\models\RefAkrual3::className(), [
            'kd_akrual_1' => 'kd_rek_1',
            'kd_akrual_2' => 'kd_rek_2',
            'kd_akrual_3' => 'kd_rek_3'
        ]);
    }

    public function getRek3Compilation()
    {
        return $this->hasOne(\app\models\CompilationRecords::className(), [
            'tahun' => 'tahun',
            'kd_pemda' => 'kd_pemda',
            'kd_rek_1' => 'kd_rek_1',
            'kd_rek_2' => 'kd_rek_2',
            'kd_rek_3' => 'kd_rek_3'
        ]);
    }

    public function getRek3Compilation5()
    {
        return $this->hasOne(\app\models\CompilationRecord5::className(), [
            'tahun' => 'tahun',
            'kd_pemda' => 'kd_pemda',
            'kd_rek_1' => 'kd_rek_1',
            'kd_rek_2' => 'kd_rek_2',
            'kd_rek_3' => 'kd_rek_3'
        ]);
    }        
}
