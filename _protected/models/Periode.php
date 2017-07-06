<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "periode".
 *
 * @property integer $id
 * @property string $akhir_periode
 */
class Periode extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'periode';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'akhir_periode'], 'required'],
            [['id'], 'integer'],
            [['akhir_periode'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'akhir_periode' => 'Akhir Periode',
        ];
    }
}
