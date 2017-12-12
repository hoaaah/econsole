<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use xj\bootbox\BootboxAsset;
use yii\bootstrap\Modal;
use yii\web\Controller;
?>
<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?php 
    echo GridView::widget([
        'dataProvider' => $data,
        //'filterModel' => $searchModel,
        // 'export' => true, 
        'responsive'=>true,
        'hover'=>true,     
        'resizableColumns'=>false,
        'panel'=>['type'=>'primary', 'heading'=> $heading       
        ],
        'responsiveWrap' => false,        
        'toolbar' => [
            '{toggleData}',
            '{export}',
        ],
        'exportConfig' => [
            GridView::HTML => ['filename' => $heading,],
            GridView::CSV => ['filename' => $heading,],
            GridView::TEXT => ['filename' => $heading,],
            GridView::EXCEL => ['filename' => $heading,], 
            GridView::PDF => [
                'label' => 'PDF',
                'showHeader' => true,
                'showPageSummary' => true,
                'showFooter' => true,
                'showCaption' => true,
                'filename' => $heading,
                'alertMsg' => 'The PDF export file will be generated for download.',
                'options' => ['title' => 'Portable Document Format'],
                'mime' => 'application/pdf',
                'config' => [
                    'mode' => 'c',
                    'format' => 'A4-L',
                    'destination' => 'D',
                    'marginTop' => 20,
                    'marginBottom' => 20,
                    'cssInline' => '.kv-wrap{padding:20px;}' .
                        '.kv-align-center{text-align:center;}' .
                        '.kv-align-left{text-align:left;}' .
                        '.kv-align-right{text-align:right;}' .
                        '.kv-align-top{vertical-align:top!important;}' .
                        '.kv-align-bottom{vertical-align:bottom!important;}' .
                        '.kv-align-middle{vertical-align:middle!important;}' .
                        '.kv-page-summary{border-top:4px double #ddd;font-weight: bold;}' .
                        '.kv-table-footer{border-top:4px double #ddd;font-weight: bold;}' .
                        '.kv-table-caption{font-size:1.5em;padding:8px;border:1px solid #ddd;border-bottom:none;}',
                    'methods' => [
                        'SetHeader' => $heading,
                        'SetFooter' => '<li role="presentation" class="dropdown-footer">Generated by econsole, '.date('Y-m-d H-i-s T').'</li>',
                    ],
                    'options' => [
                        'title' => $heading,
                        'subject' => 'PDF export generated by econsole',
                        'keywords' => 'grid, export, yii2-grid, pdf'
                    ],
                    'contentBefore'=>'',
                    'contentAfter'=>''
                ]
            ],
            GridView::JSON => ['filename' => $heading,],
        ],          
        'pager' => [
            'firstPageLabel' => 'Awal',
            'lastPageLabel'  => 'Akhir'
        ],
        'pjax'=>true,
        'pjaxSettings'=>[
            'options' => ['id' => 'laporan1-pjax', 'timeout' => 5000],
        ],
        'showPageSummary'=>true,         
        'columns' => [
            // ['class' => 'kartik\grid\SerialColumn'],            
            [
                'label' => 'Tingkat',
                'value' =>function($model){
                    return $model['transfer']['jenis_transfer'];
                },
                'group'=>true,  // enable grouping,
                // 'groupedRow'=>true,                    // move grouped column to a single grouped row
                // 'groupOddCssClass'=>'kv-grouped-row',  // configure odd group cell css class
                // 'groupEvenCssClass'=>'kv-grouped-row', // configure even group cell css class
            ],
            [
                'label' => 'Pemda',
                'value' =>function($model){
                    return $model['pemda']['name'];
                },
                'group'=>true,  // enable grouping,
                // 'groupedRow'=>true,                    // move grouped column to a single grouped row
                // 'groupOddCssClass'=>'kv-grouped-row',  // configure odd group cell css class
                // 'groupEvenCssClass'=>'kv-grouped-row', // configure even group cell css class
            ],
            [
                'label' => 'Rekening',
                'width'=>'20%',
                'value' =>function($model){
                    return $model['kd_rek_1'].'.'.
                    $model['kd_rek_2'].'.'.
                    $model['kd_rek_3'].'.'.
                    substr('0'.$model['kd_rek_4'], -2).'.'.
                    substr('0'.$model['kd_rek_5'], -2)
                    ;
                },
                // 'group'=>true,  // enable grouping,
                // 'groupedRow'=>true,                    // move grouped column to a single grouped row
                // 'groupOddCssClass'=>'kv-grouped-row',  // configure odd group cell css class
                // 'groupEvenCssClass'=>'kv-grouped-row', // configure even group cell css class
            ],        
            [
                'label' => 'Keterangan',
                // 'width'=>'20%',
                'value' =>function($model){
                    if($model->kd_rek_4 == 0){
                        return $model['rek3Compilation5']['nm_rek_3'];
                    }elseif($model->kd_rek_5 == 0){
                        return $model['rek4Compilation5']['nm_rek_4'];
                    }else{
                        return $model['rek5Compilation5']['nm_rek_5'];
                    }
                },
                // 'group'=>true,  // enable grouping,
                // 'groupedRow'=>true,                    // move grouped column to a single grouped row
                // 'groupOddCssClass'=>'kv-grouped-row',  // configure odd group cell css class
                // 'groupEvenCssClass'=>'kv-grouped-row', // configure even group cell css class
            ],
            [
                'label'=>'Saldo',
                'noWrap' => true,                
                'width'=>'5%',
                'hAlign'=>'right',
                'format'=>['decimal', 0],
                'value' => function($model) use($getparam){
                    if($model->kd_rek_4 == 0){
                        $saldo = \app\models\CompilationRecord5::find()->where([
                            'tahun' => $model->tahun,
                            'periode_id' => $getparam['Laporan']['periode_id'],
                            'kd_pemda' => $model->kd_pemda,
                            'kd_rek_1' => $model->kd_rek_1,
                            'kd_rek_2' => $model->kd_rek_2,
                            'kd_rek_3' => $model->kd_rek_3,
                        ])->sum('realisasi');
                        return $saldo ? $saldo : 0;
                    }elseif($model->kd_rek_5 == 0){
                        $saldo = \app\models\CompilationRecord5::find()->where([
                            'tahun' => $model->tahun,
                            'periode_id' => $getparam['Laporan']['periode_id'],
                            'kd_pemda' => $model->kd_pemda,
                            'kd_rek_1' => $model->kd_rek_1,
                            'kd_rek_2' => $model->kd_rek_2,
                            'kd_rek_3' => $model->kd_rek_3,
                            'kd_rek_4' => $model->kd_rek_4,
                        ])->sum('realisasi');
                        return $saldo ? $saldo : 0;
                    }else{
                        $saldo = \app\models\CompilationRecord5::find()->where([
                            'tahun' => $model->tahun,
                            'periode_id' => $getparam['Laporan']['periode_id'],
                            'kd_pemda' => $model->kd_pemda,
                            'kd_rek_1' => $model->kd_rek_1,
                            'kd_rek_2' => $model->kd_rek_2,
                            'kd_rek_3' => $model->kd_rek_3,
                            'kd_rek_4' => $model->kd_rek_4,
                            'kd_rek_5' => $model->kd_rek_5,
                        ])->one();
                        return $saldo['realisasi'] ? $saldo->realisasi : 0;
                    }
                },
                'pageSummary'=>true
            ],                                    
        ],
    ]); 
?>
