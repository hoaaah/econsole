<?php

namespace app\models;

use Yii;

/* (C) Copyright 2017 Heru Arief Wijaya (http://belajararief.com/) untuk DJPK Kemenkeu.*/

class RefAkrual2 extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'ref_akrual_2';
    }

    public function rules()
    {
        return [
            [['kd_akrual_1', 'kd_akrual_2', 'nm_akrual_2'], 'required'],
            [['kd_akrual_1', 'kd_akrual_2'], 'integer'],
            [['nm_akrual_2'], 'string', 'max' => 100],
            [['kd_akrual_1'], 'exist', 'skipOnError' => true, 'targetClass' => RefAkrual1::className(), 'targetAttribute' => ['kd_akrual_1' => 'kd_akrual_1']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'kd_akrual_1' => 'Kd Akrual 1',
            'kd_akrual_2' => 'Kd Akrual 2',
            'nm_akrual_2' => 'Nm Akrual 2',
        ];
    }

    public function getKdAkrual1()
    {
        return $this->hasOne(RefAkrual1::className(), ['kd_akrual_1' => 'kd_akrual_1']);
    }

    public function getRefAkrual3s()
    {
        return $this->hasMany(RefAkrual3::className(), ['kd_akrual_1' => 'kd_akrual_1', 'kd_akrual_2' => 'kd_akrual_2']);
    }
}
