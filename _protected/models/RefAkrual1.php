<?php

namespace app\models;

use Yii;

/* (C) Copyright 2017 Heru Arief Wijaya (http://belajararief.com/) untuk DJPK Kemenkeu.*/

class RefAkrual1 extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'ref_akrual_1';
    }

    public function rules()
    {
        return [
            [['kd_akrual_1', 'nm_akrual_1'], 'required'],
            [['kd_akrual_1'], 'integer'],
            [['nm_akrual_1'], 'string', 'max' => 100],
        ];
    }

    public function attributeLabels()
    {
        return [
            'kd_akrual_1' => 'Kd Akrual 1',
            'nm_akrual_1' => 'Nm Akrual 1',
        ];
    }

    public function getRefAkrual2s()
    {
        return $this->hasMany(RefAkrual2::className(), ['kd_akrual_1' => 'kd_akrual_1']);
    }
}
