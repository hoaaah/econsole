<?php

namespace app\modules\konsolidasi\controllers;

use Yii;
use app\models\EliminationAccount;
use app\modules\konsolidasi\models\EliminationAccountSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/* (C) Copyright 2017 Heru Arief Wijaya (http://belajararief.com/) untuk DJPK Kemenkeu.*/

class EliminasiController extends Controller
{

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
        $searchModel = new EliminationAccountSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['tahun' => $Tahun]);
        if(isset(Yii::$app->user->identity->pemda_id)) $dataProvider->query->andWhere(['kd_pemda' => Yii::$app->user->identity->pemda_id]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'Tahun' => $Tahun,
        ]);
    }

    public function actionView($tahun, $kd_pemda, $kd_rek_1, $kd_rek_2, $kd_rek_3, $kd_rek_4, $kd_rek_5)
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
        return $this->renderAjax('view', [
            'model' => $this->findModel($tahun, $kd_pemda, $kd_rek_1, $kd_rek_2, $kd_rek_3, $kd_rek_4, $kd_rek_5),
        ]);
    }

    public function actionCreate()
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

        Yii::$app->user->identity->pemda_id ?  $kd_pemda = Yii::$app->user->identity->pemda_id : $kd_pemda = NULL; 
        // generate array for dropdownlist Rek3 --@hoaaah
        $dropDownRek3 = Yii::$app->db->createCommand("
                SELECT 
                CONCAT(kd_rek_1, '.', kd_rek_2, '.', kd_rek_3) AS kd3,
                CONCAT(kd_rek_1, '.', kd_rek_2, '.', kd_rek_3, ' ', nm_rek_3) AS akun
                FROM compilation_record5 
                WHERE tahun = :tahun AND kd_pemda = :kd_pemda AND 
                akhir_periode = (SELECT MAX(akhir_periode) FROM compilation_record5 WHERE tahun = :tahun AND kd_pemda = :kd_pemda)
                GROUP BY tahun, kd_pemda, kd_rek_1, kd_rek_2, kd_rek_3, nm_rek_3
            ", [
                ':tahun' => $Tahun,
                ':kd_pemda' => $kd_pemda,
            ])->queryAll();

        $model = new EliminationAccount();
        $model->tahun = $Tahun;
        if(Yii::$app->user->identity->pemda_id) $model->kd_pemda = $kd_pemda;

        if ($model->load(Yii::$app->request->post())) {
            list($model->kd_rek_1, $model->kd_rek_2, $model->kd_rek_3) = explode('.', $model->kd3);
            $kd4 = explode('.', $model->kd4);
            $kd5 = explode('.', $model->kd5);
            if($kd4[3] == 0){
                $model->kd_rek_4 = 0;
                $model->kd_rek_5 = 0;
            }else{
                $model->kd_rek_4 = $kd4[3];
                $model->kd_rek_5 = $kd5[4];
            }
            IF($model->save()){
                echo 1;
            }ELSE{
                echo 0;
            }
        } else {
            return $this->renderAjax('_form', [
                'model' => $model,
                'dropDownRek3' => $dropDownRek3,
            ]);
        }
    }


    public function actionUpdate($tahun, $kd_pemda, $kd_rek_1, $kd_rek_2, $kd_rek_3, $kd_rek_4, $kd_rek_5)
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

        // generate array for dropdownlist Rek3 --@hoaaah
        $dropDownRek3 = Yii::$app->db->createCommand("
                SELECT 
                CONCAT(kd_rek_1, '.', kd_rek_2, '.', kd_rek_3) AS kd3,
                CONCAT(kd_rek_1, '.', kd_rek_2, '.', kd_rek_3, ' ', nm_rek_3) AS akun
                FROM compilation_record5 
                WHERE tahun = :tahun AND kd_pemda = :kd_pemda AND 
                akhir_periode = (SELECT MAX(akhir_periode) FROM compilation_record5 WHERE tahun = :tahun AND kd_pemda = :kd_pemda)
                GROUP BY tahun, kd_pemda, kd_rek_1, kd_rek_2, kd_rek_3, nm_rek_3
            ", [
                ':tahun' => $Tahun,
                ':kd_pemda' => $kd_pemda,
            ])->queryAll();

        $dropDownRek4 = Yii::$app->db->createCommand("
                SELECT 
                CONCAT(kd_rek_1, '.', kd_rek_2, '.', kd_rek_3, '.', kd_rek_4) AS kd4,
                CONCAT(kd_rek_1, '.', kd_rek_2, '.', kd_rek_3, '.', kd_rek_4, ' ', nm_rek_4) AS akun
                FROM compilation_record5 
                WHERE tahun = :tahun AND kd_pemda = :kd_pemda AND 
                akhir_periode = (SELECT MAX(akhir_periode) FROM compilation_record5 WHERE tahun = :tahun AND kd_pemda = :kd_pemda)
                GROUP BY tahun, kd_pemda, kd_rek_1, kd_rek_2, kd_rek_3, kd_rek_4, nm_rek_4
            ", [
                ':tahun' => $Tahun,
                ':kd_pemda' => $kd_pemda,
            ])->queryAll();

        $dropDownRek5 = Yii::$app->db->createCommand("
                SELECT 
                CONCAT(kd_rek_1, '.', kd_rek_2, '.', kd_rek_3, '.', kd_rek_4, '.', kd_rek_5) AS kd5,
                CONCAT(kd_rek_1, '.', kd_rek_2, '.', kd_rek_3, '.', kd_rek_4, '.', kd_rek_5, ' ', nm_rek_5) AS akun
                FROM compilation_record5 
                WHERE tahun = :tahun AND kd_pemda = :kd_pemda AND 
                akhir_periode = (SELECT MAX(akhir_periode) FROM compilation_record5 WHERE tahun = :tahun AND kd_pemda = :kd_pemda)
                GROUP BY tahun, kd_pemda, kd_rek_1, kd_rek_2, kd_rek_3, kd_rek_4, kd_rek_5, nm_rek_5
            ", [
                ':tahun' => $Tahun,
                ':kd_pemda' => $kd_pemda,
            ])->queryAll();

        $model = $this->findModel($tahun, $kd_pemda, $kd_rek_1, $kd_rek_2, $kd_rek_3, $kd_rek_4, $kd_rek_5);

        if ($model->load(Yii::$app->request->post())) {
            list($model->kd_rek_1, $model->kd_rek_2, $model->kd_rek_3) = explode('.', $model->kd3);
            $kd4 = explode('.', $model->kd4);
            $kd5 = explode('.', $model->kd5);
            if($kd4[3] == 0){
                $model->kd_rek_4 = 0;
                $model->kd_rek_5 = 0;
            }else{
                $model->kd_rek_4 = $kd4[3];
                $model->kd_rek_5 = $kd5[4];
            }            
            IF($model->save()){
                echo 1;
            }ELSE{
                echo 0;
            }
        } else {
            return $this->renderAjax('_form', [
                'model' => $model,
                'dropDownRek3' => $dropDownRek3,
                'dropDownRek4' => $dropDownRek4,
                'dropDownRek5' => $dropDownRek5,
            ]);
        }
    }

    public function actionDelete($tahun, $kd_pemda, $kd_rek_1, $kd_rek_2, $kd_rek_3, $kd_rek_4, $kd_rek_5)
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

        $this->findModel($tahun, $kd_pemda, $kd_rek_1, $kd_rek_2, $kd_rek_3, $kd_rek_4, $kd_rek_5)->delete();

        return $this->redirect(Yii::$app->request->referrer);
    }


    protected function findModel($tahun, $kd_pemda, $kd_rek_1, $kd_rek_2, $kd_rek_3, $kd_rek_4, $kd_rek_5)
    {
        if (($model = EliminationAccount::findOne(['tahun' => $tahun, 'kd_pemda' => $kd_pemda, 'kd_rek_1' => $kd_rek_1, 'kd_rek_2' => $kd_rek_2, 'kd_rek_3' => $kd_rek_3, 'kd_rek_4' => $kd_rek_4, 'kd_rek_5' => $kd_rek_5])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    // populate pemda --@hoaaah
    public function actionRek3($tahun = null, $kd_pemda = null){
        IF(Yii::$app->session->get('tahun'))
        {
            $tahun = Yii::$app->session->get('tahun');
        }ELSE{
            $tahun = DATE('Y');
        }

        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $id = end($_POST['depdrop_parents']);
            
            $list = Yii::$app->db->createCommand("
                SELECT 
                CONCAT(kd_rek_1, '.', kd_rek_2, '.', kd_rek_3) AS id,
                CONCAT(kd_rek_1, '.', kd_rek_2, '.', kd_rek_3, ' ', nm_rek_3) AS name
                FROM compilation_record5 
                WHERE tahun = :tahun AND kd_pemda = :kd_pemda AND 
                akhir_periode = (SELECT MAX(akhir_periode) FROM compilation_record5 WHERE tahun = :tahun AND kd_pemda = :kd_pemda)
                GROUP BY tahun, kd_pemda, kd_rek_1, kd_rek_2, kd_rek_3, nm_rek_3
                ", [
                    ':tahun' => $tahun,
                    ':kd_pemda' => $id,
                ])->queryAll();
            $selected  = null;
            if ($id != null && count($list) > 0) {
                $selected = '';
                foreach ($list as $i => $account) {
                    $out[] = ['id' => $account['id'], 'name' => $account['name']];
                    if ($i == 0) {
                        $selected = $account['id'];
                    }
                }
                // Shows how you can preselect a value
                echo Json::encode(['output' => $out, 'selected'=>$selected]);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected'=>'']);            
    }
     
    public function actionRek4($tahun = null, $kd_pemda = null){
        IF(Yii::$app->session->get('tahun'))
        {
            $tahun = Yii::$app->session->get('tahun');
        }ELSE{
            $tahun = DATE('Y');
        }

        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $ids = $_POST['depdrop_parents'];
            $kd_pemda = empty($ids[0]) ? Yii::$app->user->identity->kd_pemda : $ids[0];
            $kd3 = empty($ids[1]) ? null : $ids[1];
            if($kd3) list($kd_rek_1, $kd_rek_2, $kd_rek_3) = explode('.', $kd3);
            if ($kd_pemda != null) {
                $list = Yii::$app->db->createCommand("
                    SELECT 
                    CONCAT(kd_rek_1, '.', kd_rek_2, '.', kd_rek_3, '.', kd_rek_4) AS id,
                    CONCAT(kd_rek_1, '.', kd_rek_2, '.', kd_rek_3, '.', kd_rek_4, ' ', nm_rek_4) AS name
                    FROM compilation_record5 
                    WHERE tahun = :tahun AND kd_pemda = :kd_pemda AND kd_rek_1 = :kd_rek_1 AND kd_rek_2 = :kd_rek_2 AND kd_rek_3 = :kd_rek_3 AND
                    akhir_periode = (SELECT MAX(akhir_periode) FROM compilation_record5 WHERE tahun = :tahun AND kd_pemda = :kd_pemda)
                    GROUP BY tahun, kd_pemda, kd_rek_1, kd_rek_2, kd_rek_3, kd_rek_4, nm_rek_4
                    ", [
                        ':tahun' => $tahun,
                        ':kd_pemda' => $kd_pemda,
                        ':kd_rek_1' => $kd_rek_1,
                        ':kd_rek_2' => $kd_rek_2,
                        ':kd_rek_3' => $kd_rek_3,
                    ])->queryAll();
                $selected  = null;
                if ($kd3 != null && count($list) > 0) {
                    $selected = '';
                    // $out[0] = ['id' => 0, 'name' => 'Semua Akun Objek'];
                    foreach ($list as $i => $account) {
                        $out[] = ['id' => $account['id'], 'name' => $account['name']];
                    }
                    $data = array_merge([0 => ['id' => '0.0.0.0', 'name' => '[--- Semua Akun Objek ---]']], $out);
                    $selected = '0.0.0.0';
                    // Shows how you can preselect a value
                    echo Json::encode(['output' => $data, 'selected'=>$selected]);
                    return;
                }
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }

    public function actionRek5($tahun = null, $kd_pemda = null){
        IF(Yii::$app->session->get('tahun'))
        {
            $tahun = Yii::$app->session->get('tahun');
        }ELSE{
            $tahun = DATE('Y');
        }

        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $ids = $_POST['depdrop_parents'];
            $kd_pemda = empty($ids[0]) ? Yii::$app->user->identity->kd_pemda : $ids[0];
            $kd3 = empty($ids[1]) ? null : $ids[1];
            $kd4 = empty($ids[2]) ? null : $ids[2];
            if($kd4) list($kd_rek_1, $kd_rek_2, $kd_rek_3, $kd_rek_4) = explode('.', $kd4);
            if ($kd_pemda != null) {
                $list = Yii::$app->db->createCommand("
                    SELECT 
                    CONCAT(kd_rek_1, '.', kd_rek_2, '.', kd_rek_3, '.', kd_rek_4, '.', kd_rek_5) AS id,
                    CONCAT(kd_rek_1, '.', kd_rek_2, '.', kd_rek_3, '.', kd_rek_4, '.', kd_rek_5, ' ', nm_rek_5) AS name
                    FROM compilation_record5 
                    WHERE tahun = :tahun AND kd_pemda = :kd_pemda AND kd_rek_1 = :kd_rek_1 AND kd_rek_2 = :kd_rek_2 AND kd_rek_3 = :kd_rek_3 AND kd_rek_4 = :kd_rek_4 AND
                    akhir_periode = (SELECT MAX(akhir_periode) FROM compilation_record5 WHERE tahun = :tahun AND kd_pemda = :kd_pemda)
                    GROUP BY tahun, kd_pemda, kd_rek_1, kd_rek_2, kd_rek_3, kd_rek_4, kd_rek_5, nm_rek_5
                    ", [
                        ':tahun' => $tahun,
                        ':kd_pemda' => $kd_pemda,
                        ':kd_rek_1' => $kd_rek_1,
                        ':kd_rek_2' => $kd_rek_2,
                        ':kd_rek_3' => $kd_rek_3,
                        ':kd_rek_4' => $kd_rek_4,
                    ])->queryAll();
                $selected  = null;
                if ($kd4 != null && count($list) > 0) {
                    $selected = '';
                    // $out[0] = ['id' => 0, 'name' => 'Semua Akun Objek'];
                    foreach ($list as $i => $account) {
                        $out[] = ['id' => $account['id'], 'name' => $account['name']];
                    }
                    $data = array_merge([0 => ['id' => '0.0.0.0.0', 'name' => '[--- Semua Akun Rincian Objek ---]']], $out);
                    $selected = '0.0.0.0.0';
                    // Shows how you can preselect a value
                    echo Json::encode(['output' => $data, 'selected'=>$selected]);
                    return;
                }
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }    

    public function actionGetrek3($q = null, $id = null, $tahun = null, $kd_pemda = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $data = Yii::$app->db->createCommand("
                SELECT 
                CONCAT(kd_rek_1, '.', kd_rek_2, '.', kd_rek_3) AS id,
                CONCAT(kd_rek_1, '.', kd_rek_2, '.', kd_rek_3, ' ', akun) AS text
                FROM compilation_records 
                WHERE tahun = :tahun AND kd_pemda = :kd_pemda AND 
                akhir_periode = (SELECT MAX(akhir_periode) FROM compilation_records WHERE tahun = :tahun AND kd_pemda = :kd_pemda)
            ", [
                ':tahun' => $tahun,
                ':kd_pemda' => $kd_pemda,
            ])->queryAll();
            $out['results'] = array_values($data);
        }
        elseif ($id > 0) {
            // $out['results'] = ['id' => $id, 'text' => City::find($id)->name];
        }
        return $out;
    }      


    protected function cekakses(){

        IF(Yii::$app->user->identity){
            $akses = \app\models\RefUserMenu::find()->where(['kd_user' => Yii::$app->user->identity->kd_user, 'menu' => 501])->one();
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
