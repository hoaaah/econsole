<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "elimination_account".
 *
 * @property string $tahun
 * @property integer $el_id
 * @property integer $kd_pemda
 * @property integer $category
 * @property integer $kd_rek_1
 * @property integer $kd_rek_2
 * @property integer $kd_rek_3
 *
 * @property EliminationRecord $el
 */
class EliminationAccount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'elimination_account';
    }

    public $kd3;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tahun', 'el_id', 'kd_pemda', 'category'], 'required'],
            [['tahun'], 'safe'],
            [['el_id', 'category', 'kd_rek_1', 'kd_rek_2', 'kd_rek_3'], 'integer'],
            [['kd_pemda', 'kd3'], 'string'],
            [['el_id'], 'exist', 'skipOnError' => true, 'targetClass' => EliminationRecord::className(), 'targetAttribute' => ['el_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tahun' => 'Tahun',
            'el_id' => 'El ID',
            'kd_pemda' => 'Kd Pemda',
            'category' => 'Category',
            'kd_rek_1' => 'Kd Rek 1',
            'kd_rek_2' => 'Kd Rek 2',
            'kd_rek_3' => 'Kd Rek 3',
            'kd3' => 'Akun',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEl()
    {
        return $this->hasOne(EliminationRecord::className(), ['id' => 'el_id']);
    }

    public function getPemda()
    {
        return $this->hasOne(\app\models\RefPemda::className(), ['id' => 'kd_pemda']);
    }

    public function getRek3()
    {
        return $this->hasOne(\app\models\RefAkrual3::className(), [
            'kd_akrual_1' => 'kd_rek_1',
            'kd_akrual_2' => 'kd_rek_2',
            'kd_akrual_3' => 'kd_rek_3'
        ]);
    }

    public function getRek3Compilation()
    {
        return $this->hasOne(\app\models\CompilationRecords::className(), [
            'tahun' => 'tahun',
            'kd_pemda' => 'kd_pemda',
            'kd_rek_1' => 'kd_rek_1',
            'kd_rek_2' => 'kd_rek_2',
            'kd_rek_3' => 'kd_rek_3'
        ]);
    }
}
