<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "elimination_record".
 *
 * @property integer $id
 * @property string $tahun
 * @property string $no_elim
 * @property string $tgl_tetap
 * @property integer $kd_provinsi
 * @property integer $kd_pemda
 * @property integer $user_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property EliminationAccount[] $eliminationAccounts
 */
class EliminationRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'elimination_record';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tahun', 'no_elim'], 'required'],
            [['tahun', 'tgl_tetap'], 'safe'],
            [['kd_provinsi', 'user_id', 'created_at', 'updated_at'], 'integer'],
            [['kd_pemda'], 'string'],
            [['no_elim'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tahun' => 'Tahun',
            'no_elim' => 'No Elim',
            'tgl_tetap' => 'Tgl Tetap',
            'kd_provinsi' => 'Kd Provinsi',
            'kd_pemda' => 'Kd Pemda',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'user_id',
                'updatedByAttribute' => 'user_id',
            ],            
        ];
    }   

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEliminationAccounts()
    {
        return $this->hasMany(EliminationAccount::className(), ['el_id' => 'id']);
    }
}
