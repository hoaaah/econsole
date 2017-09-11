<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pemda_wilayah".
 *
 * @property integer $wilayah_id
 * @property string $pemda_id
 */
class PemdaWilayah extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pemda_wilayah';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['wilayah_id', 'pemda_id'], 'required'],
            [['wilayah_id'], 'integer'],
            [['pemda_id'], 'string', 'max' => 5],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'wilayah_id' => 'Wilayah ID',
            'pemda_id' => 'Pemda ID',
        ];
    }

    public function getPemda()
    {
        return $this->hasOne(RefPemda::className(), ['id' => 'pemda_id']);
    }
}
