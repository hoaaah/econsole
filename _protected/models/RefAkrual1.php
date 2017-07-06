<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_akrual_1".
 *
 * @property integer $kd_akrual_1
 * @property string $nm_akrual_1
 *
 * @property RefAkrual2[] $refAkrual2s
 */
class RefAkrual1 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_akrual_1';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kd_akrual_1', 'nm_akrual_1'], 'required'],
            [['kd_akrual_1'], 'integer'],
            [['nm_akrual_1'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'kd_akrual_1' => 'Kd Akrual 1',
            'nm_akrual_1' => 'Nm Akrual 1',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefAkrual2s()
    {
        return $this->hasMany(RefAkrual2::className(), ['kd_akrual_1' => 'kd_akrual_1']);
    }
}
