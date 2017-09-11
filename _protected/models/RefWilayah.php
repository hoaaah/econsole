<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_wilayah".
 *
 * @property integer $id
 * @property string $kodifikasi
 * @property string $nama_wilayah
 */
class RefWilayah extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_wilayah';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kodifikasi', 'nama_wilayah'], 'required'],
            [['kodifikasi'], 'string', 'max' => 5],
            [['nama_wilayah'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kodifikasi' => 'Kodifikasi',
            'nama_wilayah' => 'Nama Wilayah',
        ];
    }
}
