<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use kartik\widgets\Select2;
use kartik\select2\Select2Asset;

Select2Asset::register($this);

/* (C) Copyright 2017 Heru Arief Wijaya (http://belajararief.com/) untuk DJPK Kemenkeu.*/

$this->title = 'Akun Eliminasi';
$this->params['breadcrumbs'][] = $this->title;
// if(Yii::$app->user->identity->pemda_id == "") var_dump(Yii::$app->user->identity->pemda_id);
?>
<div class="elimination-account-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Tambah Akun Eliminasi', ['create'], [
                                                    'class' => 'btn btn-xs btn-success',
                                                    'data-toggle'=>"modal",
                                                    'data-target'=>"#myModal",
                                                    'data-title'=> 'Tambah Elimination Account',
                                                    ]) ?>
    </p>
    <?= GridView::widget([
        'id' => 'elimination-account',    
        'dataProvider' => $dataProvider,
        'export' => false, 
        'responsive'=>true,
        'hover'=>true,     
        'resizableColumns'=>true,
        'panel'=>['type'=>'primary', 'heading'=>$this->title],
        'responsiveWrap' => false,        
        'toolbar' => [
            '{toggleData}',
            '{export}', 
        ],       
        'pager' => [
            'firstPageLabel' => 'Awal',
            'lastPageLabel'  => 'Akhir'
        ],
        'pjax'=>true,
        'pjaxSettings'=>[
            'options' => ['id' => 'elimination-account-pjax', 'timeout' => 5000],
        ],        
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            [
                'label' => 'Pemda',
                'attribute' => 'kd_pemda',
                'visible' => Yii::$app->user->identity->pemda_id ? false : true,
                'value' => function($model){
                    return $model->kd_pemda.'. '.$model->pemda->name;
                },
                'filter' => Select2::widget([
                    'id' => 'filterGridView',
                    'model' => $searchModel,
                    'attribute' => 'kd_pemda',
                    // 'name' => 'EliminationAccountSearch[kd_pemda]',
                    'data' => \yii\helpers\ArrayHelper::map(\app\models\RefPemda::find()->select(['id', 'CONCAT(id, \' \', name) AS name'])->all(), 'id', 'name'),
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'options' => [
                        'placeholder' => 'Nama Pemda...'
                    ]
                ]),                
            ],
            [
                'label' => 'Jenis Transfer',
                'attribute' => 'transfer_id',
                'noWrap' => true,
                'value' => 'transfer.jenis_transfer',
            ],
            [
                'label' => 'Akun',
                'value' => function($model){
                    return $model->kd_rek_1.'.'.$model->kd_rek_2.'.'.$model->kd_rek_3.'.'.$model->kd_rek_4.'.'.$model->kd_rek_5;
                }
            ],
            [
                'label' => ' Nama Akun',
                'value' => function($model){
                    if($model->kd_rek_4 == 0){
                        return $model['rek3Compilation5']['nm_rek_3'];
                    }elseif($model->kd_rek_5 == 0){
                        return $model['rek4Compilation5']['nm_rek_4'];
                    }else{
                        return $model['rek5Compilation5']['nm_rek_5'];
                    }
                }
            ],
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'noWrap' => true,
                'vAlign'=>'top',
                'buttons' => [
                        'update' => function ($url, $model) {
                          return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url,
                              [  
                                 'title' => Yii::t('yii', 'ubah'),
                                 'data-toggle'=>"modal",
                                 'data-target'=>"#myModal",
                                 'data-title'=> "Ubah",
                              ]);
                        },
                        'view' => function ($url, $model) {
                          return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url,
                              [  
                                 'title' => Yii::t('yii', 'lihat'),
                                 'data-toggle'=>"modal",
                                 'data-target'=>"#myModal",
                                 'data-title'=> "Lihat",
                              ]);
                        },                        
                ]
            ],
        ],
    ]); ?>
</div>
<?php Modal::begin([
    'id' => 'myModal',
    'header' => '<h4 class="modal-title">Lihat lebih...</h4>',
        'options' => [
            'tabindex' => false,
        ], 
]);
 
echo '...';
 
Modal::end();
$this->registerJs("
    $('#myModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var modal = $(this)
        var title = button.data('title') 
        var href = button.attr('href') 
        modal.find('.modal-title').html(title)
        modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
        $.post(href)
            .done(function( data ) {
                modal.find('.modal-body').html(data)
            });
        })
");
?>