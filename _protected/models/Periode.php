<?php

namespace app\models;

use Yii;

/* (C) Copyright 2017 Heru Arief Wijaya (http://belajararief.com/) untuk DJPK Kemenkeu.*/

class Periode extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'periode';
    }

    public function rules()
    {
        return [
            [['id', 'akhir_periode'], 'required'],
            [['id'], 'integer'],
            [['akhir_periode'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'akhir_periode' => 'Akhir Periode',
        ];
    }
}
