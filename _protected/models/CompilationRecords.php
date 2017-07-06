<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "compilation_records".
 *
 * @property string $tahun
 * @property integer $kd_provinsi
 * @property integer $kd_pemda
 * @property string $akhir_periode
 * @property integer $kd_rek_1
 * @property integer $kd_rek_2
 * @property integer $kd_rek_3
 * @property string $akun
 * @property string $anggaran
 * @property string $realisasi
 * @property integer $perubahan_id
 * @property integer $d_k
 * @property string $created_at
 * @property integer $user_id
 */
class CompilationRecords extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'compilation_records';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tahun', 'kd_provinsi', 'kd_pemda', 'akhir_periode', 'kd_rek_1', 'kd_rek_2', 'kd_rek_3'], 'required'],
            [['tahun', 'akhir_periode', 'created_at'], 'safe'],
            [['kd_provinsi', 'kd_pemda', 'kd_rek_1', 'kd_rek_2', 'kd_rek_3', 'perubahan_id', 'd_k', 'user_id'], 'integer'],
            [['anggaran', 'realisasi'], 'number'],
            [['akun'], 'string', 'max' => 255],
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
            'kd_rek_1' => 'Kd Rek 1',
            'kd_rek_2' => 'Kd Rek 2',
            'kd_rek_3' => 'Kd Rek 3',
            'akun' => 'Akun',
            'anggaran' => 'Anggaran',
            'realisasi' => 'Realisasi',
            'perubahan_id' => 'Perubahan ID',
            'd_k' => 'D K',
            'created_at' => 'Created At',
            'user_id' => 'User ID',
        ];
    }
}
