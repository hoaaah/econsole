<?php
use yii\helpers\Url;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
        [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'kd_akrual_1',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'kd_akrual_2',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'kd_akrual_3',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'nm_akrual_3',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'saldoNorm',
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        // 'urlCreator' => function($action, $model, $key, $index) { 
        //         return Url::to([$action,'kd_akrual_1, $kd_akrual_2, $kd_akrual_3'=>$key]);
        // },
        'viewOptions'=>['role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete', 
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Are you sure?',
                          'data-confirm-message'=>'Are you sure want to delete this item'], 
    ],

];   