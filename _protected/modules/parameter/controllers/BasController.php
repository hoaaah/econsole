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

/**
 * BasController implements the CRUD actions for RefAkrual3 model.
 */
class BasController extends Controller
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
                    'delete' => ['post'],
                    'bulk-delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all RefAkrual3 models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new RefAkrual3Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single RefAkrual3 model.
     * @param integer $kd_akrual_1
     * @param integer $kd_akrual_2
     * @param integer $kd_akrual_3
     * @return mixed
     */
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

    /**
     * Creates a new RefAkrual3 model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
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

    /**
     * Updates an existing RefAkrual3 model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $kd_akrual_1
     * @param integer $kd_akrual_2
     * @param integer $kd_akrual_3
     * @return mixed
     */
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

    /**
     * Delete an existing RefAkrual3 model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $kd_akrual_1
     * @param integer $kd_akrual_2
     * @param integer $kd_akrual_3
     * @return mixed
     */
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

     /**
     * Delete multiple existing RefAkrual3 model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $kd_akrual_1
     * @param integer $kd_akrual_2
     * @param integer $kd_akrual_3
     * @return mixed
     */
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

    /**
     * Finds the RefAkrual3 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $kd_akrual_1
     * @param integer $kd_akrual_2
     * @param integer $kd_akrual_3
     * @return RefAkrual3 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($kd_akrual_1, $kd_akrual_2, $kd_akrual_3)
    {
        if (($model = RefAkrual3::findOne(['kd_akrual_1' => $kd_akrual_1, 'kd_akrual_2' => $kd_akrual_2, 'kd_akrual_3' => $kd_akrual_3])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
