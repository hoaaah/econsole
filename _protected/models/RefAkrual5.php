<?php

namespace app\models;

use Yii;

/* (C) Copyright 2017 Heru Arief Wijaya (http://belajararief.com/) untuk DJPK Kemenkeu.*/

class RefAkrual5 extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'ref_akrual_5';
    }

    public function rules()
    {
        return [
            [['kd_akrual_1', 'kd_akrual_2', 'kd_akrual_3', 'kd_akrual_4', 'kd_akrual_5', 'nm_akrual_5'], 'required'],
            [['kd_akrual_1', 'kd_akrual_2', 'kd_akrual_3', 'kd_akrual_4', 'kd_akrual_5'], 'integer'],
            [['nm_akrual_5'], 'string', 'max' => 255],
            [['peraturan'], 'string', 'max' => 50],
            [['kd_akrual_1', 'kd_akrual_2', 'kd_akrual_3', 'kd_akrual_4'], 'exist', 'skipOnError' => true, 'targetClass' => RefAkrual4::className(), 'targetAttribute' => ['kd_akrual_1' => 'kd_akrual_1', 'kd_akrual_2' => 'kd_akrual_2', 'kd_akrual_3' => 'kd_akrual_3', 'kd_akrual_4' => 'kd_akrual_4']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'kd_akrual_1' => 'Kd Akrual 1',
            'kd_akrual_2' => 'Kd Akrual 2',
            'kd_akrual_3' => 'Kd Akrual 3',
            'kd_akrual_4' => 'Kd Akrual 4',
            'kd_akrual_5' => 'Kd Akrual 5',
            'nm_akrual_5' => 'Nm Akrual 5',
            'peraturan' => 'Peraturan',
        ];
    }

    public function getKdAkrual1()
    {
        return $this->hasOne(RefAkrual4::className(), ['kd_akrual_1' => 'kd_akrual_1', 'kd_akrual_2' => 'kd_akrual_2', 'kd_akrual_3' => 'kd_akrual_3', 'kd_akrual_4' => 'kd_akrual_4']);
    }
}
