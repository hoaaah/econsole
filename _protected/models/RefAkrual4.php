<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_akrual_4".
 *
 * @property integer $kd_akrual_1
 * @property integer $kd_akrual_2
 * @property integer $kd_akrual_3
 * @property integer $kd_akrual_4
 * @property string $mm_akrual_4
 *
 * @property RefAkrual3 $kdAkrual1
 * @property RefAkrual5[] $refAkrual5s
 */
class RefAkrual4 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_akrual_4';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kd_akrual_1', 'kd_akrual_2', 'kd_akrual_3', 'kd_akrual_4', 'mm_akrual_4'], 'required'],
            [['kd_akrual_1', 'kd_akrual_2', 'kd_akrual_3', 'kd_akrual_4'], 'integer'],
            [['mm_akrual_4'], 'string', 'max' => 255],
            [['kd_akrual_1', 'kd_akrual_2', 'kd_akrual_3'], 'exist', 'skipOnError' => true, 'targetClass' => RefAkrual3::className(), 'targetAttribute' => ['kd_akrual_1' => 'kd_akrual_1', 'kd_akrual_2' => 'kd_akrual_2', 'kd_akrual_3' => 'kd_akrual_3']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'kd_akrual_1' => 'Kd Akrual 1',
            'kd_akrual_2' => 'Kd Akrual 2',
            'kd_akrual_3' => 'Kd Akrual 3',
            'kd_akrual_4' => 'Kd Akrual 4',
            'mm_akrual_4' => 'Mm Akrual 4',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKdAkrual1()
    {
        return $this->hasOne(RefAkrual3::className(), ['kd_akrual_1' => 'kd_akrual_1', 'kd_akrual_2' => 'kd_akrual_2', 'kd_akrual_3' => 'kd_akrual_3']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefAkrual5s()
    {
        return $this->hasMany(RefAkrual5::className(), ['kd_akrual_1' => 'kd_akrual_1', 'kd_akrual_2' => 'kd_akrual_2', 'kd_akrual_3' => 'kd_akrual_3', 'kd_akrual_4' => 'kd_akrual_4']);
    }
}
