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
            [['id', 'name'], 'required'],
            [['id'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'Kode',
            'name' => 'Nama Periode',
        ];
    }
}
