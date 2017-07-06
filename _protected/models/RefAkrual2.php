<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_akrual_2".
 *
 * @property integer $kd_akrual_1
 * @property integer $kd_akrual_2
 * @property string $nm_akrual_2
 *
 * @property RefAkrual1 $kdAkrual1
 * @property RefAkrual3[] $refAkrual3s
 */
class RefAkrual2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_akrual_2';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kd_akrual_1', 'kd_akrual_2', 'nm_akrual_2'], 'required'],
            [['kd_akrual_1', 'kd_akrual_2'], 'integer'],
            [['nm_akrual_2'], 'string', 'max' => 100],
            [['kd_akrual_1'], 'exist', 'skipOnError' => true, 'targetClass' => RefAkrual1::className(), 'targetAttribute' => ['kd_akrual_1' => 'kd_akrual_1']],
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
            'nm_akrual_2' => 'Nm Akrual 2',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKdAkrual1()
    {
        return $this->hasOne(RefAkrual1::className(), ['kd_akrual_1' => 'kd_akrual_1']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefAkrual3s()
    {
        return $this->hasMany(RefAkrual3::className(), ['kd_akrual_1' => 'kd_akrual_1', 'kd_akrual_2' => 'kd_akrual_2']);
    }
}
