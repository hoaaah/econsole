<?php 
use yii\helpers\Html;
use kartik\grid\GridView;
use dosamigos\chartjs\ChartJs;
?>
<div class="row">
<div class="col-md-12">
    <?php
    echo GridView::widget([
        'dataProvider' => $data,
        //'filterModel' => $searchModel,
        // 'export' => true, 
        'responsive'=>true,
        'hover'=>true,     
        'resizableColumns'=>false,
        'panel'=>['type'=>'primary', 'heading'=>$heading],
        'responsiveWrap' => false,        
        'toolbar' => [
                '{toggleData}',
                '{export}',
                // [
                //     'content' =>    Html::a('<i class="glyphicon glyphicon-print"></i> Cetak', ['cetak', 'Laporan' => [
                //                         'Kd_Laporan' => $getparam['Laporan']['Kd_Laporan'], 
                //                         'Kd_Sumber' => $getparam['Laporan']['Kd_Sumber'],
                //                         'Tgl_1' => $getparam['Laporan']['Tgl_1'],
                //                         'Tgl_2' => $getparam['Laporan']['Tgl_2'],
                //                         'Tgl_Laporan' => $getparam['Laporan']['Tgl_Laporan'],
                //                         'perubahan_id' => $getparam['Laporan']['perubahan_id']
                //                     ] ], [
                //                         'class' => 'btn btn btn-default pull-right',
                //                         'onClick' => "return !window.open(this.href, 'SPH', 'width=1024,height=600,scrollbars=1')"
                //                             ]) 
                // ],           
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
            // [
            //     'label' => 'Tingkat',
            //     'value' =>function($model){
            //         return $model['jenis'];
            //     },
            //     'group'=>true,  // enable grouping,
            //     // 'groupedRow'=>true,                    // move grouped column to a single grouped row
            //     // 'groupOddCssClass'=>'kv-grouped-row',  // configure odd group cell css class
            //     // 'groupEvenCssClass'=>'kv-grouped-row', // configure even group cell css class
            // ],
            // [
            //     'label' => 'Sekolah',
            //     'value' =>function($model){
            //         return $model['nama_sekolah'];
            //     },
            //     // 'group'=>true,  // enable grouping,
            //     // 'groupedRow'=>true,                    // move grouped column to a single grouped row
            //     // 'groupOddCssClass'=>'kv-grouped-row',  // configure odd group cell css class
            //     // 'groupEvenCssClass'=>'kv-grouped-row', // configure even group cell css class
            // ],
            // [
            //     'label' => 'No Peraturan',
            //     'width'=>'20%',
            //     'value' =>function($model){
            //         return $model['no_peraturan'];
            //     },
            //     // 'group'=>true,  // enable grouping,
            //     // 'groupedRow'=>true,                    // move grouped column to a single grouped row
            //     // 'groupOddCssClass'=>'kv-grouped-row',  // configure odd group cell css class
            //     // 'groupEvenCssClass'=>'kv-grouped-row', // configure even group cell css class
            // ],        
            // [
            //     'label' => 'Tgl Peraturan',
            //     // 'width'=>'20%',
            //     'format' => 'date',
            //     'value' =>function($model){
            //         return $model['tgl_peraturan'];
            //     },
            //     // 'group'=>true,  // enable grouping,
            //     // 'groupedRow'=>true,                    // move grouped column to a single grouped row
            //     // 'groupOddCssClass'=>'kv-grouped-row',  // configure odd group cell css class
            //     // 'groupEvenCssClass'=>'kv-grouped-row', // configure even group cell css class
            // ],	
            [
                'label' => 'Kode Rekening',
                'width' => '10%',
                'hAlign' => 'center',
                'value' => function($model){
                    return $model['kd_rek_1'].$model['kd_rek_2'].$model['kd_rek_3'];
                }
            ],
            [
                'label' => 'Uraian',
                'attribute' => 'nm_akrual_3',
                'format' => 'raw',
                'value' => function($model){
                    if($model['nm_akrual_3'] == '[--Rekening Tidak Terdaftar--]'){
                        return '<code>'.$model['nm_akrual_3'].'</code>';
                    }
                    return $model['nm_akrual_3'];
                }
            ],
            [
                'attribute' => 'realisasi',
                'label' => 'Saldo',
                'format' => 'decimal',
                'hAlign' => 'right',
                'value' => function($model){
                    return $model['realisasi'];
                }
            ],
        ],
    ]); 
    ?>
</div>
<?php
// prepare for chart
/*
<div class="col-md-3">
<?= ChartJs::widget([
    'type' => 'doughnut',
    'options' => [
        'height' => 400,
        'width' => 400
    ],
    'data' => [
        'labels' => ["January", "February", "March", "April", "May", "June", "July"],
        'datasets' => [
            [
                'label' => "My First dataset",
                'backgroundColor' => ["#ff6384", "#36a2eb","#cc65fe", "#ffce56","#3B56BF", "#ffce56","#3B56BF"],
                'data' => [65, 59, 90, 81, 56, 55, 40]
            ],
        ]
    ]
]);
?>
</div>
*/
?>
</div>