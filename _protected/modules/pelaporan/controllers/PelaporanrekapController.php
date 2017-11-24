<?php

namespace app\modules\pelaporan\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\helpers\ArrayHelper;

/* (C) Copyright 2017 Heru Arief Wijaya (http://belajararief.com/) untuk DJPK Kemenkeu.*/

class PelaporanrekapController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        IF($this->cekakses() !== true){
            Yii::$app->getSession()->setFlash('warning',  'Anda tidak memiliki hak akses');
            return $this->redirect(Yii::$app->request->referrer);
        }    
        IF(Yii::$app->session->get('tahun'))
        {
            $Tahun = Yii::$app->session->get('tahun');
        }ELSE{
            $Tahun = DATE('Y');
        }

        $get = new \app\models\Laporan();
        $Kd_Laporan = NULL;
        $data = NULL;
        $data1 = NULL;
        $data2 = NULL;
        $data3 = NULL;
        $data4 = NULL;
        $data5 = NULL;
        $data6 = NULL;
        $render = NULL;
        $getparam = NULL;
        IF(Yii::$app->request->queryParams){
            $getparam = Yii::$app->request->queryParams;
            // this is for array in pemda
            // $kd_pemda_params = NULL;
            // foreach($getparam['Laporan']['kd_pemda'] as $data){
            //     $kd_pemda_params = $kd_pemda_params.$data.',';
            // }            
            // if(!($getparam['Laporan']['kd_pemda']) || in_array('%', $getparam['Laporan']['kd_pemda'])){
            //     $getparam['Laporan']['kd_pemda'] = \app\models\RefPemda::find()->select(['id'])->asArray()->all();
            //     $kd_pemda_params = NULL;
            //     foreach($getparam['Laporan']['kd_pemda'] as $data){
            //         $kd_pemda_params = $kd_pemda_params.$data['id'].',';
            //     }
            // }
            // $kd_pemda_params = substr($kd_pemda_params, 0, -1);            
            IF($getparam['Laporan']['Kd_Laporan']){
                $Kd_Laporan = Yii::$app->request->queryParams['Laporan']['Kd_Laporan'];
                switch ($Kd_Laporan) {
                    case 1:
                        $totalCount = Yii::$app->db->createCommand("
                            SELECT COUNT(a.kd_rek_1) FROM
                            (
                                SELECT
                                c.kd_rek_1, c.kd_rek_2, c.kd_rek_3, IFNULL(b.nm_akrual_3, '[--Rekening Tidak Terdaftar--]' )AS nm_akrual_3, SUM(c.realisasi) AS realisasi_sebelum, SUM(a.realisasi) AS realisasi_sesudah
                                FROM
                                (
                                    SELECT A.*
                                    FROM compilation_record5 A 
                                    WHERE A.tahun = :tahun AND A.akhir_periode = :tgl_laporan AND A.kd_rek_1 IN (4,5,6,7)
                                ) c 
                                LEFT JOIN
                                (
                                    SELECT A.*
                                    FROM compilation_record5 A LEFT OUTER JOIN
                                        (
                                        SELECT A.tahun, A.kd_pemda, A.kd_rek_1, A.kd_rek_2, A.kd_rek_3, A.kd_rek_4, A.kd_rek_5
                                        FROM compilation_record5 A,
                                            elimination_account B
                                        WHERE (B.transfer_id <= :transfer_id) AND A.tahun = :tahun AND B.tahun = :tahun AND A.akhir_periode = :tgl_laporan AND 
                                            (A.tahun = B.tahun) AND (A.kd_pemda = B.kd_pemda) AND (A.kd_rek_1 = B.kd_rek_1) AND (A.kd_rek_2 = B.kd_rek_2) AND (A.kd_rek_3 = B.kd_rek_3) 
                                            AND ((B.kd_rek_4 = 0)
                                            OR ((A.kd_rek_4 = B.kd_rek_4) AND (B.kd_rek_4 <> 0) AND (B.kd_rek_5 = 0))
                                            OR ((A.kd_rek_4 = B.kd_rek_4) AND (A.kd_rek_5 = B.kd_rek_5) AND (B.kd_rek_5 <> 0)))
                                        GROUP BY A.tahun, A.kd_pemda, A.kd_rek_1, A.kd_rek_2, A.kd_rek_3, A.kd_rek_4, A.kd_rek_5
                                        ) B ON A.tahun = B.tahun AND A.kd_pemda = B.kd_pemda AND A.kd_rek_1 = B.kd_rek_1 AND A.kd_rek_2 = B.kd_rek_2 AND A.kd_rek_3 = B.kd_rek_3 AND A.kd_rek_4 = B.kd_rek_4 AND A.kd_rek_5 = B.kd_rek_5
                                    WHERE (B.tahun IS NULL) AND A.tahun = :tahun AND A.akhir_periode = :tgl_laporan AND A.kd_rek_1 IN (4,5,6,7)
                                ) a ON a.tahun = c.tahun AND a.kd_provinsi = c.kd_provinsi AND a.kd_pemda = c.kd_pemda AND a.akhir_periode = c.akhir_periode AND a.perubahan_id = c.perubahan_id AND 
                                a.kd_rek_1 = c.kd_rek_1 AND a.kd_rek_2 = c.kd_rek_2 AND a.kd_rek_3 = c.kd_rek_3 AND a.kd_rek_4 = c.kd_rek_4 AND a.kd_rek_5 = c.kd_rek_5
                                LEFT JOIN
                                ref_akrual_3 b ON c.kd_rek_1 = b.kd_akrual_1 AND c.kd_rek_2 = b.kd_akrual_2 AND c.kd_rek_3 = b.kd_akrual_3
                                GROUP BY c.kd_rek_1, c.kd_rek_2, c.kd_rek_3, b.nm_akrual_3 
                                ORDER BY c.kd_rek_1, c.kd_rek_2, c.kd_rek_3
                            ) a
                            ", [
                                ':transfer_id' => 3,
                                ':tahun' => $Tahun,
                                ':tgl_laporan' => $getparam['Laporan']['Tgl_Laporan'],
                            ])->queryScalar();

                        $data = new SqlDataProvider([
                            'sql' => "
                                SELECT
                                c.kd_rek_1, c.kd_rek_2, c.kd_rek_3, IFNULL(b.nm_akrual_3, '[--Rekening Tidak Terdaftar--]' )AS nm_akrual_3, SUM(c.realisasi) AS realisasi_sebelum, SUM(a.realisasi) AS realisasi_sesudah
                                FROM
                                (
                                    SELECT A.*
                                    FROM compilation_record5 A 
                                    WHERE A.tahun = :tahun AND A.akhir_periode = :tgl_laporan AND A.kd_rek_1 IN (4,5,6,7)
                                ) c 
                                LEFT JOIN
                                (
                                    SELECT A.*
                                    FROM compilation_record5 A LEFT OUTER JOIN
                                        (
                                        SELECT A.tahun, A.kd_pemda, A.kd_rek_1, A.kd_rek_2, A.kd_rek_3, A.kd_rek_4, A.kd_rek_5
                                        FROM compilation_record5 A,
                                            elimination_account B
                                        WHERE (B.transfer_id <= :transfer_id) AND A.tahun = :tahun AND B.tahun = :tahun AND A.akhir_periode = :tgl_laporan AND 
                                            (A.tahun = B.tahun) AND (A.kd_pemda = B.kd_pemda) AND (A.kd_rek_1 = B.kd_rek_1) AND (A.kd_rek_2 = B.kd_rek_2) AND (A.kd_rek_3 = B.kd_rek_3) 
                                            AND ((B.kd_rek_4 = 0)
                                            OR ((A.kd_rek_4 = B.kd_rek_4) AND (B.kd_rek_4 <> 0) AND (B.kd_rek_5 = 0))
                                            OR ((A.kd_rek_4 = B.kd_rek_4) AND (A.kd_rek_5 = B.kd_rek_5) AND (B.kd_rek_5 <> 0)))
                                        GROUP BY A.tahun, A.kd_pemda, A.kd_rek_1, A.kd_rek_2, A.kd_rek_3, A.kd_rek_4, A.kd_rek_5
                                        ) B ON A.tahun = B.tahun AND A.kd_pemda = B.kd_pemda AND A.kd_rek_1 = B.kd_rek_1 AND A.kd_rek_2 = B.kd_rek_2 AND A.kd_rek_3 = B.kd_rek_3 AND A.kd_rek_4 = B.kd_rek_4 AND A.kd_rek_5 = B.kd_rek_5
                                    WHERE (B.tahun IS NULL) AND A.tahun = :tahun AND A.akhir_periode = :tgl_laporan AND A.kd_rek_1 IN (4,5,6,7)
                                ) a ON a.tahun = c.tahun AND a.kd_provinsi = c.kd_provinsi AND a.kd_pemda = c.kd_pemda AND a.akhir_periode = c.akhir_periode AND a.perubahan_id = c.perubahan_id AND 
                                a.kd_rek_1 = c.kd_rek_1 AND a.kd_rek_2 = c.kd_rek_2 AND a.kd_rek_3 = c.kd_rek_3 AND a.kd_rek_4 = c.kd_rek_4 AND a.kd_rek_5 = c.kd_rek_5
                                LEFT JOIN
                                ref_akrual_3 b ON c.kd_rek_1 = b.kd_akrual_1 AND c.kd_rek_2 = b.kd_akrual_2 AND c.kd_rek_3 = b.kd_akrual_3
                                GROUP BY c.kd_rek_1, c.kd_rek_2, c.kd_rek_3, b.nm_akrual_3 
                                ORDER BY c.kd_rek_1, c.kd_rek_2, c.kd_rek_3
                                    ",
                            'params' => [
                                ':transfer_id' => 3,
                                ':tahun' => $Tahun,
                                ':tgl_laporan' => $getparam['Laporan']['Tgl_Laporan'],
                            ],
                            'totalCount' => $totalCount,
                            //'sort' =>false, to remove the table header sorting
                            'pagination' => [
                                'pageSize' => 50,
                            ],
                        ]);
                        $render = 'laporan1';
                        break;
                    case 2:
                        $totalCount = Yii::$app->db->createCommand("
                            SELECT COUNT(a.kd_rek_1) FROM
                            (
                                SELECT
                                c.kd_rek_1, c.kd_rek_2, c.kd_rek_3, IFNULL(b.nm_akrual_3, '[--Rekening Tidak Terdaftar--]' )AS nm_akrual_3, SUM(c.realisasi) AS realisasi_sebelum, SUM(a.realisasi) AS realisasi_sesudah
                                FROM
                                (
                                    SELECT A.*
                                    FROM compilation_record5 A 
                                    WHERE A.tahun = :tahun AND A.akhir_periode = :tgl_laporan AND A.kd_rek_1 IN (4,5,6,7) AND A.kd_pemda IN (SELECT pemda_id FROM pemda_wilayah WHERE wilayah_id = :wilayah_id)
                                ) c 
                                LEFT JOIN
                                (
                                    SELECT A.*
                                    FROM compilation_record5 A LEFT OUTER JOIN
                                        (
                                        SELECT A.tahun, A.kd_pemda, A.kd_rek_1, A.kd_rek_2, A.kd_rek_3, A.kd_rek_4, A.kd_rek_5
                                        FROM compilation_record5 A,
                                            elimination_account B
                                        WHERE (B.transfer_id <= :transfer_id) AND A.tahun = :tahun AND B.tahun = :tahun AND A.akhir_periode = :tgl_laporan AND 
                                            A.kd_pemda IN (SELECT pemda_id FROM pemda_wilayah WHERE wilayah_id = :wilayah_id) AND B.kd_pemda IN (SELECT pemda_id FROM pemda_wilayah WHERE wilayah_id = :wilayah_id) AND 
                                            (A.tahun = B.tahun) AND (A.kd_pemda = B.kd_pemda) AND (A.kd_rek_1 = B.kd_rek_1) AND (A.kd_rek_2 = B.kd_rek_2) AND (A.kd_rek_3 = B.kd_rek_3) 
                                            AND ((B.kd_rek_4 = 0)
                                            OR ((A.kd_rek_4 = B.kd_rek_4) AND (B.kd_rek_4 <> 0) AND (B.kd_rek_5 = 0))
                                            OR ((A.kd_rek_4 = B.kd_rek_4) AND (A.kd_rek_5 = B.kd_rek_5) AND (B.kd_rek_5 <> 0)))
                                        GROUP BY A.tahun, A.kd_pemda, A.kd_rek_1, A.kd_rek_2, A.kd_rek_3, A.kd_rek_4, A.kd_rek_5
                                        ) B ON A.tahun = B.tahun AND A.kd_pemda = B.kd_pemda AND A.kd_rek_1 = B.kd_rek_1 AND A.kd_rek_2 = B.kd_rek_2 AND A.kd_rek_3 = B.kd_rek_3 AND A.kd_rek_4 = B.kd_rek_4 AND A.kd_rek_5 = B.kd_rek_5
                                    WHERE (B.tahun IS NULL) AND A.kd_pemda IN (SELECT pemda_id FROM pemda_wilayah WHERE wilayah_id = :wilayah_id) AND A.tahun = :tahun AND A.akhir_periode = :tgl_laporan AND A.kd_rek_1 IN (4,5,6,7)
                                ) a ON a.tahun = c.tahun AND a.kd_provinsi = c.kd_provinsi AND a.kd_pemda = c.kd_pemda AND a.akhir_periode = c.akhir_periode AND a.perubahan_id = c.perubahan_id AND 
                                a.kd_rek_1 = c.kd_rek_1 AND a.kd_rek_2 = c.kd_rek_2 AND a.kd_rek_3 = c.kd_rek_3 AND a.kd_rek_4 = c.kd_rek_4 AND a.kd_rek_5 = c.kd_rek_5
                                LEFT JOIN
                                ref_akrual_3 b ON c.kd_rek_1 = b.kd_akrual_1 AND c.kd_rek_2 = b.kd_akrual_2 AND c.kd_rek_3 = b.kd_akrual_3
                                GROUP BY c.kd_rek_1, c.kd_rek_2, c.kd_rek_3, b.nm_akrual_3 
                                ORDER BY c.kd_rek_1, c.kd_rek_2, c.kd_rek_3
                            ) a
                            ", [
                                ':transfer_id' => 2,
                                ':tahun' => $Tahun,
                                ':tgl_laporan' => $getparam['Laporan']['Tgl_Laporan'],
                                ':wilayah_id' => $getparam['Laporan']['kd_wilayah'],
                            ])->queryScalar();

                        $data = new SqlDataProvider([
                            'sql' => "
                                SELECT
                                c.kd_rek_1, c.kd_rek_2, c.kd_rek_3, IFNULL(b.nm_akrual_3, '[--Rekening Tidak Terdaftar--]' )AS nm_akrual_3, SUM(c.realisasi) AS realisasi_sebelum, SUM(a.realisasi) AS realisasi_sesudah
                                FROM
                                (
                                    SELECT A.*
                                    FROM compilation_record5 A 
                                    WHERE A.tahun = :tahun AND A.akhir_periode = :tgl_laporan AND A.kd_rek_1 IN (4,5,6,7) AND A.kd_pemda IN (SELECT pemda_id FROM pemda_wilayah WHERE wilayah_id = :wilayah_id)
                                ) c 
                                LEFT JOIN
                                (
                                    SELECT A.*
                                    FROM compilation_record5 A LEFT OUTER JOIN
                                        (
                                        SELECT A.tahun, A.kd_pemda, A.kd_rek_1, A.kd_rek_2, A.kd_rek_3, A.kd_rek_4, A.kd_rek_5
                                        FROM compilation_record5 A,
                                            elimination_account B
                                        WHERE (B.transfer_id <= :transfer_id) AND A.tahun = :tahun AND B.tahun = :tahun AND A.akhir_periode = :tgl_laporan AND 
                                            A.kd_pemda IN (SELECT pemda_id FROM pemda_wilayah WHERE wilayah_id = :wilayah_id) AND B.kd_pemda IN (SELECT pemda_id FROM pemda_wilayah WHERE wilayah_id = :wilayah_id) AND 
                                            (A.tahun = B.tahun) AND (A.kd_pemda = B.kd_pemda) AND (A.kd_rek_1 = B.kd_rek_1) AND (A.kd_rek_2 = B.kd_rek_2) AND (A.kd_rek_3 = B.kd_rek_3) 
                                            AND ((B.kd_rek_4 = 0)
                                            OR ((A.kd_rek_4 = B.kd_rek_4) AND (B.kd_rek_4 <> 0) AND (B.kd_rek_5 = 0))
                                            OR ((A.kd_rek_4 = B.kd_rek_4) AND (A.kd_rek_5 = B.kd_rek_5) AND (B.kd_rek_5 <> 0)))
                                        GROUP BY A.tahun, A.kd_pemda, A.kd_rek_1, A.kd_rek_2, A.kd_rek_3, A.kd_rek_4, A.kd_rek_5
                                        ) B ON A.tahun = B.tahun AND A.kd_pemda = B.kd_pemda AND A.kd_rek_1 = B.kd_rek_1 AND A.kd_rek_2 = B.kd_rek_2 AND A.kd_rek_3 = B.kd_rek_3 AND A.kd_rek_4 = B.kd_rek_4 AND A.kd_rek_5 = B.kd_rek_5
                                    WHERE (B.tahun IS NULL) AND A.kd_pemda IN (SELECT pemda_id FROM pemda_wilayah WHERE wilayah_id = :wilayah_id) AND A.tahun = :tahun AND A.akhir_periode = :tgl_laporan AND A.kd_rek_1 IN (4,5,6,7)
                                ) a ON a.tahun = c.tahun AND a.kd_provinsi = c.kd_provinsi AND a.kd_pemda = c.kd_pemda AND a.akhir_periode = c.akhir_periode AND a.perubahan_id = c.perubahan_id AND 
                                a.kd_rek_1 = c.kd_rek_1 AND a.kd_rek_2 = c.kd_rek_2 AND a.kd_rek_3 = c.kd_rek_3 AND a.kd_rek_4 = c.kd_rek_4 AND a.kd_rek_5 = c.kd_rek_5
                                LEFT JOIN
                                ref_akrual_3 b ON c.kd_rek_1 = b.kd_akrual_1 AND c.kd_rek_2 = b.kd_akrual_2 AND c.kd_rek_3 = b.kd_akrual_3
                                GROUP BY c.kd_rek_1, c.kd_rek_2, c.kd_rek_3, b.nm_akrual_3 
                                ORDER BY c.kd_rek_1, c.kd_rek_2, c.kd_rek_3
                                    ",
                            'params' => [
                                ':transfer_id' => 2,
                                ':tahun' => $Tahun,
                                ':tgl_laporan' => $getparam['Laporan']['Tgl_Laporan'],
                                ':wilayah_id' => $getparam['Laporan']['kd_wilayah'],
                            ],
                            'totalCount' => $totalCount,
                            //'sort' =>false, to remove the table header sorting
                            'pagination' => [
                                'pageSize' => 50,
                            ],
                        ]);
                        $render = 'laporan1';
                        break;  
                    case 3:
                        $totalCount = Yii::$app->db->createCommand("
                            SELECT COUNT(a.kd_rek_1) FROM
                            (
                                SELECT
                                c.kd_rek_1, c.kd_rek_2, c.kd_rek_3, IFNULL(b.nm_akrual_3, '[--Rekening Tidak Terdaftar--]' )AS nm_akrual_3, SUM(c.realisasi) AS realisasi_sebelum, SUM(a.realisasi) AS realisasi_sesudah
                                FROM
                                (
                                    SELECT A.*
                                    FROM compilation_record5 A 
                                    WHERE A.tahun = :tahun AND A.akhir_periode = :tgl_laporan AND A.kd_rek_1 IN (4,5,6,7) AND A.kd_pemda IN (SELECT id FROM ref_pemda WHERE province_id = :province_id)
                                ) c 
                                LEFT JOIN
                                (
                                    SELECT A.*
                                    FROM compilation_record5 A LEFT OUTER JOIN
                                        (
                                        SELECT A.tahun, A.kd_pemda, A.kd_rek_1, A.kd_rek_2, A.kd_rek_3, A.kd_rek_4, A.kd_rek_5
                                        FROM compilation_record5 A,
                                            elimination_account B
                                        WHERE (B.transfer_id <= :transfer_id) AND A.tahun = :tahun AND B.tahun = :tahun AND A.akhir_periode = :tgl_laporan AND 
                                            A.kd_pemda IN (SELECT id FROM ref_pemda WHERE province_id = :province_id) AND B.kd_pemda IN (SELECT id FROM ref_pemda WHERE province_id = :province_id) AND 
                                            (A.tahun = B.tahun) AND (A.kd_pemda = B.kd_pemda) AND (A.kd_rek_1 = B.kd_rek_1) AND (A.kd_rek_2 = B.kd_rek_2) AND (A.kd_rek_3 = B.kd_rek_3) 
                                            AND ((B.kd_rek_4 = 0)
                                            OR ((A.kd_rek_4 = B.kd_rek_4) AND (B.kd_rek_4 <> 0) AND (B.kd_rek_5 = 0))
                                            OR ((A.kd_rek_4 = B.kd_rek_4) AND (A.kd_rek_5 = B.kd_rek_5) AND (B.kd_rek_5 <> 0)))
                                        GROUP BY A.tahun, A.kd_pemda, A.kd_rek_1, A.kd_rek_2, A.kd_rek_3, A.kd_rek_4, A.kd_rek_5
                                        ) B ON A.tahun = B.tahun AND A.kd_pemda = B.kd_pemda AND A.kd_rek_1 = B.kd_rek_1 AND A.kd_rek_2 = B.kd_rek_2 AND A.kd_rek_3 = B.kd_rek_3 AND A.kd_rek_4 = B.kd_rek_4 AND A.kd_rek_5 = B.kd_rek_5
                                    WHERE (B.tahun IS NULL) AND A.kd_pemda IN (SELECT id FROM ref_pemda WHERE province_id = :province_id) AND A.tahun = :tahun AND A.akhir_periode = :tgl_laporan AND A.kd_rek_1 IN (4,5,6,7)
                                ) a ON a.tahun = c.tahun AND a.kd_provinsi = c.kd_provinsi AND a.kd_pemda = c.kd_pemda AND a.akhir_periode = c.akhir_periode AND a.perubahan_id = c.perubahan_id AND 
                                a.kd_rek_1 = c.kd_rek_1 AND a.kd_rek_2 = c.kd_rek_2 AND a.kd_rek_3 = c.kd_rek_3 AND a.kd_rek_4 = c.kd_rek_4 AND a.kd_rek_5 = c.kd_rek_5
                                LEFT JOIN
                                ref_akrual_3 b ON c.kd_rek_1 = b.kd_akrual_1 AND c.kd_rek_2 = b.kd_akrual_2 AND c.kd_rek_3 = b.kd_akrual_3
                                GROUP BY c.kd_rek_1, c.kd_rek_2, c.kd_rek_3, b.nm_akrual_3 
                                ORDER BY c.kd_rek_1, c.kd_rek_2, c.kd_rek_3
                            ) a
                            ", [
                                ':transfer_id' => 1,
                                ':tahun' => $Tahun,
                                ':tgl_laporan' => $getparam['Laporan']['Tgl_Laporan'],
                                ':province_id' => $getparam['Laporan']['kd_provinsi'],
                            ])->queryScalar();

                        $data = new SqlDataProvider([
                            'sql' => "
                                SELECT
                                c.kd_rek_1, c.kd_rek_2, c.kd_rek_3, IFNULL(b.nm_akrual_3, '[--Rekening Tidak Terdaftar--]' )AS nm_akrual_3, SUM(c.realisasi) AS realisasi_sebelum, SUM(a.realisasi) AS realisasi_sesudah
                                FROM
                                (
                                    SELECT A.*
                                    FROM compilation_record5 A 
                                    WHERE A.tahun = :tahun AND A.akhir_periode = :tgl_laporan AND A.kd_rek_1 IN (4,5,6,7) AND A.kd_pemda IN (SELECT id FROM ref_pemda WHERE province_id = :province_id)
                                ) c 
                                LEFT JOIN
                                (
                                    SELECT A.*
                                    FROM compilation_record5 A LEFT OUTER JOIN
                                        (
                                        SELECT A.tahun, A.kd_pemda, A.kd_rek_1, A.kd_rek_2, A.kd_rek_3, A.kd_rek_4, A.kd_rek_5
                                        FROM compilation_record5 A,
                                            elimination_account B
                                        WHERE (B.transfer_id <= :transfer_id) AND A.tahun = :tahun AND B.tahun = :tahun AND A.akhir_periode = :tgl_laporan AND 
                                            A.kd_pemda IN (SELECT id FROM ref_pemda WHERE province_id = :province_id) AND B.kd_pemda IN (SELECT id FROM ref_pemda WHERE province_id = :province_id) AND 
                                            (A.tahun = B.tahun) AND (A.kd_pemda = B.kd_pemda) AND (A.kd_rek_1 = B.kd_rek_1) AND (A.kd_rek_2 = B.kd_rek_2) AND (A.kd_rek_3 = B.kd_rek_3) 
                                            AND ((B.kd_rek_4 = 0)
                                            OR ((A.kd_rek_4 = B.kd_rek_4) AND (B.kd_rek_4 <> 0) AND (B.kd_rek_5 = 0))
                                            OR ((A.kd_rek_4 = B.kd_rek_4) AND (A.kd_rek_5 = B.kd_rek_5) AND (B.kd_rek_5 <> 0)))
                                        GROUP BY A.tahun, A.kd_pemda, A.kd_rek_1, A.kd_rek_2, A.kd_rek_3, A.kd_rek_4, A.kd_rek_5
                                        ) B ON A.tahun = B.tahun AND A.kd_pemda = B.kd_pemda AND A.kd_rek_1 = B.kd_rek_1 AND A.kd_rek_2 = B.kd_rek_2 AND A.kd_rek_3 = B.kd_rek_3 AND A.kd_rek_4 = B.kd_rek_4 AND A.kd_rek_5 = B.kd_rek_5
                                    WHERE (B.tahun IS NULL) AND A.kd_pemda IN (SELECT id FROM ref_pemda WHERE province_id = :province_id) AND A.tahun = :tahun AND A.akhir_periode = :tgl_laporan AND A.kd_rek_1 IN (4,5,6,7)
                                ) a ON a.tahun = c.tahun AND a.kd_provinsi = c.kd_provinsi AND a.kd_pemda = c.kd_pemda AND a.akhir_periode = c.akhir_periode AND a.perubahan_id = c.perubahan_id AND 
                                a.kd_rek_1 = c.kd_rek_1 AND a.kd_rek_2 = c.kd_rek_2 AND a.kd_rek_3 = c.kd_rek_3 AND a.kd_rek_4 = c.kd_rek_4 AND a.kd_rek_5 = c.kd_rek_5
                                LEFT JOIN
                                ref_akrual_3 b ON c.kd_rek_1 = b.kd_akrual_1 AND c.kd_rek_2 = b.kd_akrual_2 AND c.kd_rek_3 = b.kd_akrual_3
                                GROUP BY c.kd_rek_1, c.kd_rek_2, c.kd_rek_3, b.nm_akrual_3 
                                ORDER BY c.kd_rek_1, c.kd_rek_2, c.kd_rek_3
                                    ",
                            'params' => [
                                ':transfer_id' => 1,
                                ':tahun' => $Tahun,
                                ':tgl_laporan' => $getparam['Laporan']['Tgl_Laporan'],
                                ':province_id' => $getparam['Laporan']['kd_provinsi'],
                            ],
                            'totalCount' => $totalCount,
                            //'sort' =>false, to remove the table header sorting
                            'pagination' => [
                                'pageSize' => 50,
                            ],
                        ]);
                        $render = 'laporan1';
                        break;
                    case 4:
                        $totalCount = Yii::$app->db->createCommand("
                            SELECT COUNT(a.kd_rek_1) FROM
                            (
                                SELECT
                                a.kd_rek_1, a.kd_rek_2, a.kd_rek_3, IFNULL(b.nm_akrual_3, '[--Rekening Tidak Terdaftar--]' )AS nm_akrual_3, SUM(a.realisasi) AS realisasi_sebelum, SUM(a.realisasi) AS realisasi_sesudah
                                FROM
                                (
                                    SELECT A.tahun, A.kd_pemda, A.kd_rek_1, A.kd_rek_2, A.kd_rek_3, A.kd_rek_4, A.kd_rek_5, SUM(A.realisasi) AS realisasi
                                    FROM compilation_record5 A
                                    WHERE A.tahun = :tahun AND A.akhir_periode = :tgl_laporan AND 
                                        A.kd_pemda = :pemda_id AND A.kd_rek_1 IN (4,5,6,7)
                                    GROUP BY A.tahun, A.kd_pemda, A.kd_rek_1, A.kd_rek_2, A.kd_rek_3, A.kd_rek_4, A.kd_rek_5       
                                ) a
                                LEFT JOIN
                                ref_akrual_3 b ON a.kd_rek_1 = b.kd_akrual_1 AND a.kd_rek_2 = b.kd_akrual_2 AND a.kd_rek_3 = b.kd_akrual_3
                                GROUP BY a.kd_rek_1, a.kd_rek_2, a.kd_rek_3, b.nm_akrual_3
                                ORDER BY a.kd_rek_1, a.kd_rek_2, a.kd_rek_3
                            ) a
                            ", [
                                ':tahun' => $Tahun,
                                ':tgl_laporan' => $getparam['Laporan']['Tgl_Laporan'],
                                ':pemda_id' => $getparam['Laporan']['kd_pemda'],
                            ])->queryScalar();

                        $data = new SqlDataProvider([
                            'sql' => "
                                SELECT
                                a.kd_rek_1, a.kd_rek_2, a.kd_rek_3, IFNULL(b.nm_akrual_3, '[--Rekening Tidak Terdaftar--]' )AS nm_akrual_3, SUM(a.realisasi) AS realisasi_sebelum, SUM(a.realisasi) AS realisasi_sesudah
                                FROM
                                (
                                    SELECT A.tahun, A.kd_pemda, A.kd_rek_1, A.kd_rek_2, A.kd_rek_3, A.kd_rek_4, A.kd_rek_5, SUM(A.realisasi) AS realisasi
                                    FROM compilation_record5 A
                                    WHERE A.tahun = :tahun AND A.akhir_periode = :tgl_laporan AND 
                                        A.kd_pemda = :pemda_id AND A.kd_rek_1 IN (4,5,6,7)
                                    GROUP BY A.tahun, A.kd_pemda, A.kd_rek_1, A.kd_rek_2, A.kd_rek_3, A.kd_rek_4, A.kd_rek_5       
                                ) a
                                LEFT JOIN
                                ref_akrual_3 b ON a.kd_rek_1 = b.kd_akrual_1 AND a.kd_rek_2 = b.kd_akrual_2 AND a.kd_rek_3 = b.kd_akrual_3
                                GROUP BY a.kd_rek_1, a.kd_rek_2, a.kd_rek_3, b.nm_akrual_3
                                ORDER BY a.kd_rek_1, a.kd_rek_2, a.kd_rek_3
                                    ",
                            'params' => [
                                ':tahun' => $Tahun,
                                ':tgl_laporan' => $getparam['Laporan']['Tgl_Laporan'],
                                ':pemda_id' => $getparam['Laporan']['kd_pemda'],
                            ],
                            'totalCount' => $totalCount,
                            //'sort' =>false, to remove the table header sorting
                            'pagination' => [
                                'pageSize' => 50,
                            ],
                        ]);
                        $render = 'laporan1';
                        break;                                              
                    case 5:
                        $query = \app\models\EliminationAccount::find()->where(['tahun' => $Tahun,])->andWhere('kd_rek_1 IN (4,5,6,7)');
                        switch ($getparam['Laporan']['elimination_level']) {
                            case 1:
                                $pemda = \app\models\RefPemda::find()->select('id')->where(['province_id' => $getparam['Laporan']['kd_provinsi']])->asArray()->all();
                                $arrayPemda = ArrayHelper::getColumn($pemda, 'id');
                                if(count($arrayPemda) != 0){
                                    $stringArrayPemda = implode(',', $arrayPemda);
                                    $query->andWhere("kd_pemda IN($stringArrayPemda)");
                                }
                                break;
                            case 2:
                                $pemda = \app\models\PemdaWilayah::find()->select('pemda_id')->where(['wilayah_id' => $getparam['Laporan']['kd_wilayah']])->asArray()->all();
                                $arrayPemda = ArrayHelper::getColumn($pemda, 'pemda_id');
                                if(count($arrayPemda) != 0){
                                    $stringArrayPemda = implode(',', $arrayPemda);
                                    $query->andWhere("kd_pemda IN($stringArrayPemda)");
                                }
                                break;
                            
                            default:
                                # code...
                                break;
                        }
                        $data = new ActiveDataProvider([
                            'query' => $query->orderBy('transfer_id, kd_pemda'),
                            'pagination' => [
                                'pageSize' => 50,
                            ],
                        ]);
                        $render = 'laporan2';
                        break;                                                      

                    default:
                        # code...
                        break;
                }
            }

        }

        return $this->render('index', [
            'get' => $get,
            'Kd_Laporan' => $Kd_Laporan,
            'data' => $data,
            'data1' => $data1,
            'data2' => $data2,
            'data3' => $data3,
            'data4' => $data4,
            'data5' => $data5,
            'data6' => $data6,
            'render' => $render,
            'getparam' => $getparam,
            'Tahun' => $Tahun,
        ]);
    }


//dari index kita cetak. Code below
//---------------------------------------------------------------------------------------------------------------------------------------------------
    public function actionCetak()
    {
        IF($this->cekakses() !== true){
            Yii::$app->getSession()->setFlash('warning',  'Anda tidak memiliki hak akses');
            return $this->redirect(Yii::$app->request->referrer);
        }    
        IF(Yii::$app->session->get('tahun'))
        {
            $Tahun = Yii::$app->session->get('tahun');
        }ELSE{
            $Tahun = DATE('Y');
        }

        $get = new \app\models\Laporan();
        $Kd_Laporan = NULL;
        $data = NULL;
        $data1 = NULL;
        $data2 = NULL;
        $data3 = NULL;
        $data4 = NULL;
        $data5 = NULL;
        $data6 = NULL;
        $render = NULL;
        $getparam = NULL;
        IF(Yii::$app->request->queryParams){
            $getparam = Yii::$app->request->queryParams;
            IF($getparam['Laporan']['Kd_Sumber'] <> NULL){
                list($kd_penerimaan_1, $kd_penerimaan_2) = explode('.', $getparam['Laporan']['Kd_Sumber']);
                IF($kd_penerimaan_1 == 0) $kd_penerimaan_1 = '%';
                IF($kd_penerimaan_2 == 0) $kd_penerimaan_2 = '%';
            }
            IF($getparam['Laporan']['Kd_Laporan']){
                $Kd_Laporan = Yii::$app->request->queryParams['Laporan']['Kd_Laporan'];
                switch ($Kd_Laporan) {
                    case 2:
                        $data =  Yii::$app->db->createCommand("
                                    SELECT a.tahun, a.sekolah_id, a.kd_program, c.uraian_program, a.kd_sub_program, d.uraian_sub_program, a.kd_kegiatan, e.uraian_kegiatan, a.Kd_Rek_1, a.anggaran, b.TW1, b.TW2, b.TW3, b.TW4 FROM
                                    (
                                        SELECT
                                        a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, SUM(a.total) AS anggaran
                                        FROM
                                        ta_rkas_history a
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = :perubahan_id
                                        AND IFNULL(a.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2,'') LIKE :kd_penerimaan_2
                                        GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1
                                    ) a 
                                    LEFT JOIN
                                    (
                                        SELECT
                                        a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1,
                                        SUM(IFNULL(a.januari1,0) + IFNULL(a.februari1,0) + IFNULL(a.maret1,0)) AS TW1,
                                        SUM(IFNULL(a.april1,0) + IFNULL(a.mei1,0) + IFNULL(a.juni1,0)) AS TW2,
                                        SUM(IFNULL(a.juli,0) + IFNULL(a.agustus,0) + IFNULL(a.september,0)) AS TW3,
                                        SUM(IFNULL(a.oktober,0) + IFNULL(a.november,0) + IFNULL(a.desember,0)) AS TW4
                                        FROM
                                        ta_rkas_belanja_rencana_history a
                                        INNER JOIN 
                                        (
                                            SELECT a.tahun, a.sekolah_id, a.perubahan_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2 , a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                                FROM ta_rkas_history a
                                                WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = :perubahan_id
                                                AND IFNULL(a.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2,'') LIKE :kd_penerimaan_2
                                                GROUP BY a.tahun, a.sekolah_id, a.perubahan_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2 , a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        )b 
                                        ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.perubahan_id = b.perubahan_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.kd_rek_5 = b.Kd_Rek_5
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = :perubahan_id
                                        AND IFNULL(b.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(b.kd_penerimaan_2,'') LIKE :kd_penerimaan_2
                                        GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1
                                        UNION ALL
                                        SELECT
                                        a.tahun, a.sekolah_id, 0 AS kd_program, 0 AS kd_sub_program, 0 AS kd_kegiatan, a.Kd_Rek_1,
                                        SUM(IFNULL(a.januari1,0) + IFNULL(a.februari1,0) + IFNULL(a.maret1,0)) AS TW1,
                                        SUM(IFNULL(a.april1,0) + IFNULL(a.mei1,0) + IFNULL(a.juni1,0)) AS TW2,
                                        SUM(IFNULL(a.juli,0) + IFNULL(a.agustus,0) + IFNULL(a.september,0)) AS TW3,
                                        SUM(IFNULL(a.oktober,0) + IFNULL(a.november,0) + IFNULL(a.desember,0)) AS TW4
                                        FROM
                                        ta_rkas_pendapatan_rencana_history a
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = :perubahan_id
                                        AND a.kd_penerimaan_1 LIKE :kd_penerimaan_1 AND a.kd_penerimaan_2 LIKE :kd_penerimaan_2
                                        GROUP BY a.tahun, a.sekolah_id, a.Kd_Rek_1
                                    ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan AND a.Kd_Rek_1 = b.Kd_Rek_1
                                    INNER JOIN ref_program_sekolah c ON a.kd_program = c.kd_program
                                    INNER JOIN ref_sub_program_sekolah d ON a.kd_program = d.kd_program AND a.kd_sub_program = d.kd_sub_program
                                    INNER JOIN ref_kegiatan_sekolah e ON a.kd_program = e.kd_program AND a.kd_sub_program = e.kd_sub_program AND a.kd_kegiatan = e.kd_kegiatan
                                    ORDER BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1 ASC                        
                        ")->bindValues([
                                ':tahun' => $Tahun,
                                ':sekolah_id' => Yii::$app->user->identity->sekolah_id,
                                ':perubahan_id' => $getparam['Laporan']['perubahan_id'],
                                ':kd_penerimaan_1' => $kd_penerimaan_1,
                                ':kd_penerimaan_2' => $kd_penerimaan_2,
                        ])->queryAll();                    

                        $render = 'cetaklaporan2';
                        break;   

                    default:
                        # code...
                        break;
                }
            }

        }

        $peraturan = \app\models\TaRKASPeraturan::findOne([
                            'tahun' => $Tahun,
                            'perubahan_id' => $getparam['Laporan']['perubahan_id'],
                            'sekolah_id' => Yii::$app->user->identity->sekolah_id,
                            ]);


        return $this->render($render, [
            'get' => $get,
            'Kd_Laporan' => $Kd_Laporan,
            'data' => $data,
            'data1' => $data1,
            'data2' => $data2,
            'data3' => $data3,
            'data4' => $data4,
            'data5' => $data5,
            'data6' => $data6,
            'render' => $render,
            'getparam' => $getparam,
            'Tahun' => $Tahun,
            'peraturan' => $peraturan,
        ]);
    } 

    /**
     * Finds the TaValidasiPembayaran model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $Kd_Bidang
     * @param integer $Kd_Sub
     * @param integer $Kd_Unit
     * @param integer $Kd_Urusan
     * @param string $No_Validasi
     * @param integer $Tahun
     * @return TaValidasiPembayaran the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($Kd_Bidang, $Kd_Sub, $Kd_Unit, $Kd_Urusan, $No_Validasi, $Tahun)
    {
        if (($model = TaValidasiPembayaran::findOne(['Kd_Bidang' => $Kd_Bidang, 'Kd_Sub' => $Kd_Sub, 'Kd_Unit' => $Kd_Unit, 'Kd_Urusan' => $Kd_Urusan, 'No_Validasi' => $No_Validasi, 'Tahun' => $Tahun])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    protected function cekakses(){

        IF(Yii::$app->user->identity){
            $akses = \app\models\RefUserMenu::find()->where(['kd_user' => Yii::$app->user->identity->kd_user, 'menu' => 601])->one();
            IF($akses){
                return true;
            }else{
                return false;
            }
        }ELSE{
            return false;
        }
    }      
}
