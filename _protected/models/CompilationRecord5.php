<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "compilation_record5".
 *
 * @property string $tahun
 * @property integer $kd_provinsi
 * @property string $kd_pemda
 * @property string $akhir_periode
 * @property integer $perubahan_id
 * @property integer $kd_rek_1
 * @property integer $kd_rek_2
 * @property integer $kd_rek_3
 * @property integer $kd_rek_4
 * @property integer $kd_rek_5
 * @property string $nm_rek_1
 * @property string $nm_rek_2
 * @property string $nm_rek_3
 * @property string $nm_rek_4
 * @property string $nm_rek_5
 * @property string $anggaran
 * @property string $realisasi
 * @property integer $d_k
 * @property string $created_at
 * @property integer $user_id
 */
class CompilationRecord5 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'compilation_record5';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tahun', 'kd_provinsi', 'kd_pemda', 'akhir_periode', 'perubahan_id', 'kd_rek_1', 'kd_rek_2', 'kd_rek_3', 'kd_rek_4', 'kd_rek_5'], 'required'],
            [['tahun', 'akhir_periode', 'created_at'], 'safe'],
            [['kd_provinsi', 'perubahan_id', 'kd_rek_1', 'kd_rek_2', 'kd_rek_3', 'kd_rek_4', 'kd_rek_5', 'd_k', 'user_id'], 'integer'],
            [['anggaran', 'realisasi'], 'number'],
            [['kd_pemda'], 'string', 'max' => 11],
            [['nm_rek_1', 'nm_rek_2', 'nm_rek_3', 'nm_rek_4', 'nm_rek_5'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tahun' => 'Tahun',
            'kd_provinsi' => 'Kd Provinsi',
            'kd_pemda' => 'Kd Pemda',
            'akhir_periode' => 'Akhir Periode',
            'perubahan_id' => 'Perubahan ID',
            'kd_rek_1' => 'Kd Rek 1',
            'kd_rek_2' => 'Kd Rek 2',
            'kd_rek_3' => 'Kd Rek 3',
            'kd_rek_4' => 'Kd Rek 4',
            'kd_rek_5' => 'Kd Rek 5',
            'nm_rek_1' => 'Nm Rek 1',
            'nm_rek_2' => 'Nm Rek 2',
            'nm_rek_3' => 'Nm Rek 3',
            'nm_rek_4' => 'Nm Rek 4',
            'nm_rek_5' => 'Nm Rek 5',
            'anggaran' => 'Anggaran',
            'realisasi' => 'Realisasi',
            'd_k' => 'D K',
            'created_at' => 'Created At',
            'user_id' => 'User ID',
        ];
    }
}
