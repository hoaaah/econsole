<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;

/* (C) Copyright 2017 Heru Arief Wijaya (http://belajararief.com/) untuk Indonesia.*/
?>

<p>
    <?= Html::a('Tambah Pemda', ['/parameter/pemdawilayah/create', 'id' => $wilayah_id], [
                            'class' => 'btn btn-xs btn-success',
                            'data-toggle'=>"modal",
                            'data-target'=>"#myModal",
                            'data-title'=>"Tambah",
                            ]) ?>
</p>
<?= GridView::widget([
    'id' => 'pemda-wilayah-'.$wilayah_id,    
    'dataProvider' => ${'dataProvider'.$wilayah_id},
    'export' => false, 
    'responsive'=>true,
    'hover'=>true,     
    'resizableColumns'=>true,
    // 'panel'=>['type'=>'primary', 'heading'=>$this->title],
    'responsiveWrap' => false,
    'pager' => [
        'firstPageLabel' => 'Awal',
        'lastPageLabel'  => 'Akhir'
    ],
    'pjax'=>true,
    'pjaxSettings'=>[
        'options' => ['id' => 'pemda-wilayah-pjax'.$wilayah_id, 'timeout' => 5000],
    ],        
    // 'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'kartik\grid\SerialColumn'],
        'pemda.name',
        [
            'class' => 'kartik\grid\ActionColumn',
            'template' => '{delete}',
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