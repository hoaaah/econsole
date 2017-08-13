<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/* (C) Copyright 2017 Heru Arief Wijaya (http://belajararief.com/) untuk DJPK Kemenkeu.*/

class TaPengumuman extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'ta_pengumuman';
    }

    public function rules()
    {
        return [
            [['diumumkan_di', 'sticky', 'title', 'published', 'user_id'], 'required'],
            [['diumumkan_di', 'sticky', 'published', 'user_id', 'created_at', 'updated_at'], 'integer'],
            [['content'], 'string'],
            [['title'], 'string', 'max' => 100],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'diumumkan_di' => 'Diumumkan pada',
            'sticky' => 'Sticky',
            'title' => 'Judul',
            'content' => 'Content',
            'published' => 'Di Publikasikan',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }    
    
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

}
