<?php

namespace app\models;

use Yii;

/* (C) Copyright 2017 Heru Arief Wijaya (http://belajararief.com/) untuk DJPK Kemenkeu.*/

class RefAkrual3 extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'ref_akrual_3';
    }

    public function rules()
    {
        return [
            [['kd_akrual_1', 'kd_akrual_2', 'kd_akrual_3', 'nm_akrual_3', 'saldoNorm'], 'required'],
            [['kd_akrual_1', 'kd_akrual_2', 'kd_akrual_3'], 'integer'],
            [['nm_akrual_3'], 'string', 'max' => 100],
            [['saldoNorm'], 'string', 'max' => 1],
            [['kd_akrual_1', 'kd_akrual_2'], 'exist', 'skipOnError' => true, 'targetClass' => RefAkrual2::className(), 'targetAttribute' => ['kd_akrual_1' => 'kd_akrual_1', 'kd_akrual_2' => 'kd_akrual_2']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'kd_akrual_1' => 'Kd Akrual 1',
            'kd_akrual_2' => 'Kd Akrual 2',
            'kd_akrual_3' => 'Kd Akrual 3',
            'nm_akrual_3' => 'Nm Akrual 3',
            'saldoNorm' => 'Saldo Norm',
        ];
    }

    public function getKdAkrual1()
    {
        return $this->hasOne(RefAkrual2::className(), ['kd_akrual_1' => 'kd_akrual_1', 'kd_akrual_2' => 'kd_akrual_2']);
    }

    public function getRefAkrual4s()
    {
        return $this->hasMany(RefAkrual4::className(), ['kd_akrual_1' => 'kd_akrual_1', 'kd_akrual_2' => 'kd_akrual_2', 'kd_akrual_3' => 'kd_akrual_3']);
    }
}
