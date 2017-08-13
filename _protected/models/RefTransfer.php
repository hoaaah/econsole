<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_transfer".
 *
 * @property integer $id
 * @property string $jenis_transfer
 */
class RefTransfer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_transfer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['jenis_transfer'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'jenis_transfer' => 'Jenis Transfer',
        ];
    }
}
