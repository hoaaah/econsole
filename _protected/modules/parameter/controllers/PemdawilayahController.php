<?php

namespace app\modules\parameter\controllers;

use Yii;
use app\models\PemdaWilayah;
use app\modules\parameter\models\PemdaWilayahSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/* (C) Copyright 2017 Heru Arief Wijaya (http://belajararief.com/) untuk Indonesia.*/
class PemdawilayahController extends Controller
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
     * Displays a single PemdaWilayah model.
     * @param integer $wilayah_id
     * @param string $pemda_id
     * @return mixed
     */
    public function actionView($wilayah_id, $pemda_id)
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
            'model' => $this->findModel($wilayah_id, $pemda_id),
        ]);
    }

    /**
     * Creates a new PemdaWilayah model.
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

        $dropdownPemda = \app\models\RefPemda::find()->select(['id', 'CONCAT(id, \' \', name) AS name'])->all();

        $model = new PemdaWilayah();
        $model->wilayah_id = $id;

        if ($model->load(Yii::$app->request->post())) {
            IF($model->save()){
                echo 1;
            }ELSE{
                echo 0;
            }
        } else {
            return $this->renderAjax('_form', [
                'model' => $model,
                'dropdownPemda' => $dropdownPemda,
                'wilayah_id' => $id,
            ]);
        }
    }

    /**
     * Updates an existing PemdaWilayah model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $wilayah_id
     * @param string $pemda_id
     * @return mixed
     */
    public function actionUpdate($wilayah_id, $pemda_id)
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
        
        $dropdownPemda = \app\models\RefPemda::find()->select(['id', 'CONCAT(id, \' \', name) AS name'])->all();

        $model = $this->findModel($wilayah_id, $pemda_id);

        if ($model->load(Yii::$app->request->post())) {
            IF($model->save()){
                echo 1;
            }ELSE{
                echo 0;
            }
        } else {
            return $this->renderAjax('_form', [
                'model' => $model,
                'dropdownPemda' => $dropdownPemda,
                'wilayah_id' => $id,
            ]);
        }
    }

    /**
     * Deletes an existing PemdaWilayah model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $wilayah_id
     * @param string $pemda_id
     * @return mixed
     */
    public function actionDelete($wilayah_id, $pemda_id)
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

        $this->findModel($wilayah_id, $pemda_id)->delete();

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the PemdaWilayah model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $wilayah_id
     * @param string $pemda_id
     * @return PemdaWilayah the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($wilayah_id, $pemda_id)
    {
        if (($model = PemdaWilayah::findOne(['wilayah_id' => $wilayah_id, 'pemda_id' => $pemda_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    protected function cekakses(){

        IF(Yii::$app->user->identity){
            $akses = \app\models\RefUserMenu::find()->where(['kd_user' => Yii::$app->user->identity->kd_user, 'menu' => 205])->one();
            IF($akses){
                return true;
            }else{
                return false;
            }
        }
        return false;
    }  

}
