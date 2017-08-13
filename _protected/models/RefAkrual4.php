<?php

namespace app\models;

use Yii;

/* (C) Copyright 2017 Heru Arief Wijaya (http://belajararief.com/) untuk DJPK Kemenkeu.*/

class RefAkrual4 extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'ref_akrual_4';
    }

    public function rules()
    {
        return [
            [['kd_akrual_1', 'kd_akrual_2', 'kd_akrual_3', 'kd_akrual_4', 'mm_akrual_4'], 'required'],
            [['kd_akrual_1', 'kd_akrual_2', 'kd_akrual_3', 'kd_akrual_4'], 'integer'],
            [['mm_akrual_4'], 'string', 'max' => 255],
            [['kd_akrual_1', 'kd_akrual_2', 'kd_akrual_3'], 'exist', 'skipOnError' => true, 'targetClass' => RefAkrual3::className(), 'targetAttribute' => ['kd_akrual_1' => 'kd_akrual_1', 'kd_akrual_2' => 'kd_akrual_2', 'kd_akrual_3' => 'kd_akrual_3']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'kd_akrual_1' => 'Kd Akrual 1',
            'kd_akrual_2' => 'Kd Akrual 2',
            'kd_akrual_3' => 'Kd Akrual 3',
            'kd_akrual_4' => 'Kd Akrual 4',
            'mm_akrual_4' => 'Mm Akrual 4',
        ];
    }

    public function getKdAkrual1()
    {
        return $this->hasOne(RefAkrual3::className(), ['kd_akrual_1' => 'kd_akrual_1', 'kd_akrual_2' => 'kd_akrual_2', 'kd_akrual_3' => 'kd_akrual_3']);
    }

    public function getRefAkrual5s()
    {
        return $this->hasMany(RefAkrual5::className(), ['kd_akrual_1' => 'kd_akrual_1', 'kd_akrual_2' => 'kd_akrual_2', 'kd_akrual_3' => 'kd_akrual_3', 'kd_akrual_4' => 'kd_akrual_4']);
    }
}
