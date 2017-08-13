<?php

namespace app\models;

use Yii;

/* (C) Copyright 2017 Heru Arief Wijaya (http://belajararief.com/) untuk DJPK Kemenkeu.*/

class RefPemda extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'ref_pemda';
    }

    public function rules()
    {
        return [
            [['id', 'province_id', 'name'], 'required'],
            [['id'], 'string', 'max' => 5],
            [['province_id'], 'string', 'max' => 2],
            [['name'], 'string', 'max' => 100],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'province_id' => 'Province ID',
            'name' => 'Name',
        ];
    }
}
