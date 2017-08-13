<?php

namespace app\models;

use Yii;

 /* (C) Copyright 2017 Heru Arief Wijaya (http://belajararief.com/) untuk DJPK Kemenkeu.*/

class EliminationAccount extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'elimination_account';
    }

    public $kd3;
    public $kd4;
    public $kd5;

    public function rules()
    {
        return [
            [['tahun', 'kd_pemda', 'kd_rek_1', 'kd_rek_2', 'kd_rek_3', 'kd_rek_4', 'kd_rek_5'], 'required'],
            [['tahun'], 'safe'],
            [['kd_rek_1', 'kd_rek_2', 'kd_rek_3', 'kd_rek_4', 'kd_rek_5', 'transfer_id'], 'integer'],
            [['kd_pemda', 'kd3', 'kd4', 'kd5'], 'string', 'max' => 11],
        ];
    }

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
            'transfer_id' => 'Kategori Transfer',
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

    public function getTransfer()
    {
        return $this->hasOne(\app\models\RefTransfer::className(), [
            'id' => 'transfer_id'
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

    public function getRek4Compilation5()
    {
        return $this->hasOne(\app\models\CompilationRecord5::className(), [
            'tahun' => 'tahun',
            'kd_pemda' => 'kd_pemda',
            'kd_rek_1' => 'kd_rek_1',
            'kd_rek_2' => 'kd_rek_2',
            'kd_rek_3' => 'kd_rek_3',
            'kd_rek_4' => 'kd_rek_4',
        ]);
    } 

    public function getRek5Compilation5()
    {
        return $this->hasOne(\app\models\CompilationRecord5::className(), [
            'tahun' => 'tahun',
            'kd_pemda' => 'kd_pemda',
            'kd_rek_1' => 'kd_rek_1',
            'kd_rek_2' => 'kd_rek_2',
            'kd_rek_3' => 'kd_rek_3',
            'kd_rek_4' => 'kd_rek_4',
            'kd_rek_5' => 'kd_rek_5'
        ]);
    }                
}
