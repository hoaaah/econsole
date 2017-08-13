<?php

namespace app\models;

use Yii;

/* (C) Copyright 2017 Heru Arief Wijaya (http://belajararief.com/) untuk DJPK Kemenkeu.*/

class RefTransfer extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'ref_transfer';
    }

    public function rules()
    {
        return [
            [['jenis_transfer'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'jenis_transfer' => 'Jenis Transfer',
        ];
    }
}
