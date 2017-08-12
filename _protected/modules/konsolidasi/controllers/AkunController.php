<?php

namespace app\modules\konsolidasi\controllers;

use Yii;
use app\models\EliminationAccount;
use app\modules\konsolidasi\models\EliminationAccountSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * AkunController implements the CRUD actions for EliminationAccount model.
 */
class AkunController extends Controller
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

    /**
     * Lists all EliminationAccount models.
     * @return mixed
     */
    public function actionIndex()
    {
        IF($this->cekakses() !== true){
            Yii::$app->getSession()->setFlash('warning',  'Anda tidak memiliki hak akses');
            return $this->redirect(Yii::$app->request->referrer);
        }    
        IF(Yii::$app->session->get('tahun'))
        {
            $tahun = Yii::$app->session->get('tahun');
        }ELSE{
            $tahun = DATE('Y');
        }
        $searchModel = new EliminationAccountSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'tahun' => $tahun,
        ]);
    }

    /**
     * Displays a single EliminationAccount model.
     * @param string $tahun
     * @param integer $el_id
     * @param string $kd_pemda
     * @param integer $category
     * @return mixed
     */
    public function actionView($tahun, $el_id, $kd_pemda, $category, $kd_rek_1, $kd_rek_2, $kd_rek_3)
    {
        IF($this->cekakses() !== true){
            Yii::$app->getSession()->setFlash('warning',  'Anda tidak memiliki hak akses');
            return $this->redirect(Yii::$app->request->referrer);
        }    
        IF(Yii::$app->session->get('tahun'))
        {
            $tahun = Yii::$app->session->get('tahun');
        }ELSE{
            $tahun = DATE('Y');
        }   
        return $this->renderAjax('view', [
            'model' => $this->findModel($tahun, $el_id, $kd_pemda, $category, $kd_rek_1, $kd_rek_2, $kd_rek_3),
        ]);
    }

    /**
     * Creates a new EliminationAccount model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        IF($this->cekakses() !== true){
            Yii::$app->getSession()->setFlash('warning',  'Anda tidak memiliki hak akses');
            return $this->redirect(Yii::$app->request->referrer);
        }    
        IF(Yii::$app->session->get('tahun'))
        {
            $tahun = Yii::$app->session->get('tahun');
        }ELSE{
            $tahun = DATE('Y');
        }

        $elRecord = \app\models\EliminationRecord::findOne(['id' => $id]);
        $dropDownRek3 = Yii::$app->db->createCommand("
                SELECT 
                CONCAT(kd_rek_1, '.', kd_rek_2, '.', kd_rek_3) AS kd3,
                CONCAT(kd_rek_1, '.', kd_rek_2, '.', kd_rek_3, ' ', akun) AS akun
                FROM compilation_records 
                WHERE tahun = :tahun AND kd_pemda = :kd_pemda AND 
                akhir_periode = (SELECT MAX(akhir_periode) FROM compilation_records WHERE tahun = :tahun AND kd_pemda = :kd_pemda)
            ", [
                ':tahun' => $elRecord->tahun,
                ':kd_pemda' => Yii::$app->user->identity->pemda_id,
            ])->queryAll();
        $model = new EliminationAccount();
        $model->tahun = $elRecord->tahun;
        $model->el_id = $id;
        if(Yii::$app->user->identity->pemda_id) $model->kd_pemda = Yii::$app->user->identity->pemda_id;

        if ($model->load(Yii::$app->request->post())) {
            list($model->kd_rek_1, $model->kd_rek_2, $model->kd_rek_3) = explode('.', $model->kd3);
            IF($model->save()){
                echo 1;
            }ELSE{
                echo 0;
            }
        } else {
            return $this->renderAjax('_form', [
                'model' => $model,
                'elRecord' => $elRecord,
                'dropDownRek3' => $dropDownRek3,
            ]);
        }
    }

    /**
     * Updates an existing EliminationAccount model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $tahun
     * @param integer $el_id
     * @param string $kd_pemda
     * @param integer $category
     * @return mixed
     */
    public function actionUpdate($tahun, $el_id, $kd_pemda, $category, $kd_rek_1, $kd_rek_2, $kd_rek_3)
    {
        IF($this->cekakses() !== true){
            Yii::$app->getSession()->setFlash('warning',  'Anda tidak memiliki hak akses');
            return $this->redirect(Yii::$app->request->referrer);
        }    

        $model = $this->findModel($tahun, $el_id, $kd_pemda, $category, $kd_rek_1, $kd_rek_2, $kd_rek_3);
        $dropDownRek3 = Yii::$app->db->createCommand("
                SELECT 
                CONCAT(kd_rek_1, '.', kd_rek_2, '.', kd_rek_3) AS kd3,
                CONCAT(kd_rek_1, '.', kd_rek_2, '.', kd_rek_3, ' ', akun) AS akun
                FROM compilation_records 
                WHERE tahun = :tahun AND kd_pemda = :kd_pemda AND 
                akhir_periode = (SELECT MAX(akhir_periode) FROM compilation_records WHERE tahun = :tahun AND kd_pemda = :kd_pemda)
            ", [
                ':tahun' => $tahun,
                ':kd_pemda' => $kd_pemda,
            ])->queryAll();        

        if ($model->load(Yii::$app->request->post())) {
            list($model->kd_rek_1, $model->kd_rek_2, $model->kd_rek_3) = explode('.', $model->kd3);
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

    /**
     * Deletes an existing EliminationAccount model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $tahun
     * @param integer $el_id
     * @param string $kd_pemda
     * @param integer $category
     * @return mixed
     */
    public function actionDelete($tahun, $el_id, $kd_pemda, $category, $kd_rek_1, $kd_rek_2, $kd_rek_3)
    {
        IF($this->cekakses() !== true){
            Yii::$app->getSession()->setFlash('warning',  'Anda tidak memiliki hak akses');
            return $this->redirect(Yii::$app->request->referrer);
        }    
        IF(Yii::$app->session->get('tahun'))
        {
            $tahun = Yii::$app->session->get('tahun');
        }ELSE{
            $tahun = DATE('Y');
        }

        $this->findModel($tahun, $el_id, $kd_pemda, $category, $kd_rek_1, $kd_rek_2, $kd_rek_3)->delete();

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the EliminationAccount model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $tahun
     * @param integer $el_id
     * @param string $kd_pemda
     * @param integer $category
     * @return EliminationAccount the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($tahun, $el_id, $kd_pemda, $category, $kd_rek_1, $kd_rek_2, $kd_rek_3)
    {
        if (($model = EliminationAccount::findOne(['tahun' => $tahun, 'el_id' => $el_id, 'kd_pemda' => $kd_pemda, 'category' => $category, 'kd_rek_1' => $kd_rek_1, 'kd_rek_2' => $kd_rek_2, 'kd_rek_3' => $kd_rek_3])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    // populate pemda
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
            /* this query use for rek5 group by
            *we will replace this later
                SELECT 
                CONCAT(kd_rek_1, '.', kd_rek_2, '.', kd_rek_3) AS id,
                CONCAT(kd_rek_1, '.', kd_rek_2, '.', kd_rek_3, ' ', nm_rek_3) AS NAME
                FROM compilation_record5
                WHERE tahun = 2016 AND kd_pemda = '30.04' AND 
                akhir_periode = (SELECT MAX(akhir_periode) FROM compilation_record5 WHERE tahun = 2016 AND kd_pemda = '30.04')
                GROUP BY kd_rek_1, kd_rek_2, kd_rek_3, nm_rek_3
            */            
            $list = Yii::$app->db->createCommand("
                    SELECT 
                    CONCAT(kd_rek_1, '.', kd_rek_2, '.', kd_rek_3) AS id,
                    CONCAT(kd_rek_1, '.', kd_rek_2, '.', kd_rek_3, ' ', akun) AS name
                    FROM compilation_records 
                    WHERE tahun = :tahun AND kd_pemda = :kd_pemda AND 
                    akhir_periode = (SELECT MAX(akhir_periode) FROM compilation_records WHERE tahun = :tahun AND kd_pemda = :kd_pemda)
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

        // IF(Yii::$app->user->identity){
        //     $akses = \app\models\RefUserMenu::find()->where(['kd_user' => Yii::$app->user->identity->kd_user, 'menu' => 401])->one();
        //     IF($akses){
        //         return true;
        //     }else{
        //         return false;
        //     }
        // }ELSE{
        //     return false;
        // }
        return true;
    }  

}
