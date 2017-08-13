<?php

namespace app\models;

use Yii;

/* (C) Copyright 2017 Heru Arief Wijaya (http://belajararief.com/) untuk DJPK Kemenkeu.*/

class RefUser extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'ref_user';
    }

    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 50],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    public function getRefUserMenus()
    {
        return $this->hasMany(RefUserMenu::className(), ['kd_user' => 'id']);
    }
}
