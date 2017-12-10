<?php

namespace app\modules\parameter\controllers;

use Yii;
use app\models\RefAkrual3;
use app\modules\parameter\models\RefAkrual3Search;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\helpers\Json;

/* (C) Copyright 2017 Heru Arief Wijaya (http://belajararief.com/) untuk DJPK Kemenkeu.*/

class BasController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'bulk-delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {    
        $searchModel = new RefAkrual3Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($kd_akrual_1, $kd_akrual_2, $kd_akrual_3)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "RefAkrual3 #".$kd_akrual_1, $kd_akrual_2, $kd_akrual_3,
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($kd_akrual_1, $kd_akrual_2, $kd_akrual_3),
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','kd_akrual_1, $kd_akrual_2, $kd_akrual_3'=>$kd_akrual_1, $kd_akrual_2, $kd_akrual_3],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($kd_akrual_1, $kd_akrual_2, $kd_akrual_3),
            ]);
        }
    }

    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new RefAkrual3();  

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Create new RefAkrual3",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Create new RefAkrual3",
                    'content'=>'<span class="text-success">Create RefAkrual3 success</span>',
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Create More',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> "Create new RefAkrual3",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'kd_akrual_1' => $model->kd_akrual_1, 'kd_akrual_2' => $model->kd_akrual_2, 'kd_akrual_3' => $model->kd_akrual_3]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
       
    }

    public function actionUpdate($kd_akrual_1, $kd_akrual_2, $kd_akrual_3)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($kd_akrual_1, $kd_akrual_2, $kd_akrual_3);       

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Update RefAkrual3 #".$kd_akrual_1, $kd_akrual_2, $kd_akrual_3,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "RefAkrual3 #".$kd_akrual_1, $kd_akrual_2, $kd_akrual_3,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','kd_akrual_1, $kd_akrual_2, $kd_akrual_3'=>$kd_akrual_1, $kd_akrual_2, $kd_akrual_3],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> "Update RefAkrual3 #".$kd_akrual_1, $kd_akrual_2, $kd_akrual_3,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];        
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'kd_akrual_1' => $model->kd_akrual_1, 'kd_akrual_2' => $model->kd_akrual_2, 'kd_akrual_3' => $model->kd_akrual_3]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    public function actionDelete($kd_akrual_1, $kd_akrual_2, $kd_akrual_3)
    {
        $request = Yii::$app->request;
        $this->findModel($kd_akrual_1, $kd_akrual_2, $kd_akrual_3)->delete();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }


    }

    public function actionBulkDelete()
    {        
        $request = Yii::$app->request;
        $pks = explode(',', $request->post( 'pks' )); // Array or selected records primary keys
        foreach ( $pks as $pk ) {
            $model = $this->findModel($pk);
            $model->delete();
        }

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
       
    }

    protected function findModel($kd_akrual_1, $kd_akrual_2, $kd_akrual_3)
    {
        if (($model = RefAkrual3::findOne(['kd_akrual_1' => $kd_akrual_1, 'kd_akrual_2' => $kd_akrual_2, 'kd_akrual_3' => $kd_akrual_3])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionRek2($tahun = null, $kd_pemda = null){
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
                kd_akrual_2 AS id,
                CONCAT(kd_akrual_1, '.', kd_akrual_2, ' ', IFNULL(nm_akrual_2, 'Tidak Ada Keterangan')) AS name
                FROM ref_akrual_2 
                WHERE kd_akrual_1 = :kd_akrual_1
                ", [
                    ':kd_akrual_1' => $id,
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
}
