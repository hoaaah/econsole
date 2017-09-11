<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\parameter\models\RefWilayahSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

/* (C) Copyright 2017 Heru Arief Wijaya (http://belajararief.com/) untuk Indonesia.*/

$this->title = 'Wilayah';
$this->params['breadcrumbs'][] = 'Parameter';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ref-wilayah-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Tambah Wilayah', ['create'], [
                                'class' => 'btn btn-xs btn-success',
                                'data-toggle'=>"modal",
                                'data-target'=>"#myModal",
                                'data-title'=>"Tambah",
                                ]) ?>
    </p>
    <?= GridView::widget([
        'id' => 'ref-wilayah',    
        'dataProvider' => $dataProvider,
        'export' => false, 
        'responsive'=>true,
        'hover'=>true,     
        'resizableColumns'=>true,
        'panel'=>['type'=>'primary', 'heading'=>$this->title],
        'responsiveWrap' => false,        
        'toolbar' => [
            [
                '{toggleData}',
                '{export}',
                // 'content' => $this->render('_search', ['model' => $searchModel, 'Tahun' => $Tahun]),
            ],
        ],       
        'pager' => [
            'firstPageLabel' => 'Awal',
            'lastPageLabel'  => 'Akhir'
        ],
        'pjax'=>true,
        'pjaxSettings'=>[
            'options' => ['id' => 'ref-wilayah-pjax', 'timeout' => 5000],
        ],        
        // 'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => '\kartik\grid\ExpandRowColumn',
                'value'=>function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                'detail' => function($model) {
                    $wilayah_id = $model->id;
        
                    $searchModel = new \app\modules\parameter\models\PemdaWilayahSearch();
                    ${'dataProvider'.$wilayah_id} = $searchModel->search(Yii::$app->request->queryParams);
                    ${'dataProvider'.$wilayah_id}->query->andWhere(['wilayah_id' => $wilayah_id]);
                    // $data2Provider->pagination->pageSize = 1;
        
                    // multiple griviews
                    ${'dataProvider'.$wilayah_id}->pagination->pageParam = 'pemda-page-'.$wilayah_id;
                    ${'dataProvider'.$wilayah_id}->sort->sortParam = 'pemda-sort-'.$wilayah_id;
                    return $this->render('_pemda', [
                        'searchModel' => $searchModel,
                        'dataProvider'.$wilayah_id => ${'dataProvider'.$wilayah_id},
                        'wilayah_id' => $wilayah_id,
                    ]);
                },
                'expandOneOnly' => true
            ],
            'kodifikasi',
            'nama_wilayah',
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{pemda} {view} {update} {delete}',
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
    ]) ?>
</div>
<?php 
Modal::begin([
    'id' => 'myModal',
    'header' => '<h4 class="modal-title">Lihat lebih...</h4>',
        'options' => [
            'tabindex' => false // important for Select2 to work properly
        ], 
]);
 
echo '...';
 
Modal::end();

$this->registerJs(<<<JS
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
JS
);
?>