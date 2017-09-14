<?php

namespace app\models;

use Yii;

/* (C) Copyright 2017 Heru Arief Wijaya (http://belajararief.com/) untuk DJPK Kemenkeu.*/

class RefUserMenu extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'ref_user_menu';
    }

    public static function primaryKey(){
       return array('kd_user', 'menu');
    }    

    public function rules()
    {
        return [
            [['menu', 'kd_user'], 'integer'],
            [['kd_user', 'menu'], 'unique', 'targetAttribute' => ['kd_user', 'menu'], 'message' => 'The combination of Menu and Kd User has already been taken.'],
            [['kd_user'], 'exist', 'skipOnError' => true, 'targetClass' => RefUser::className(), 'targetAttribute' => ['kd_user' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'menu' => 'Menu',
            'kd_user' => 'Kd User',
        ];
    }

    public function getKdUser()
    {
        return $this->hasOne(RefUser::className(), ['id' => 'kd_user']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'kd_user']);
    }
}
