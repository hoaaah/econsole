<?php 
use yii\bootstrap\BootstrapAsset;
use kartik\export\ExportMenu;
?>
<div class="panel panel-primary">
    <!-- Default panel contents -->
    <div class="panel-heading"> <h3 class="panel-title"><?= $heading ?></h3></div>
    <div class="panel-body">
        <?php 
        echo ExportMenu::widget([
            'dataProvider' => $data,
            'columns' => [
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
                    'attribute' => 'realisasi_sebelum',
                    'label' => 'Sebelum Eliminasi',
                    'format' => 'decimal',
                    'hAlign' => 'right',
                    'pageSummary' => true,
                    'value' => function($model){
                        return $model['realisasi_sebelum'] ? $model['realisasi_sebelum'] : 0;
                    }
                ],
                [
                    'attribute' => 'realisasi_sesudah',
                    'label' => 'Sesudah Eliminasi',
                    'format' => 'decimal',
                    'hAlign' => 'right',
                    'pageSummary' => true,
                    'value' => function($model){
                        return $model['realisasi_sesudah'] ? $model['realisasi_sesudah'] : 0;
                    }
                ],
            ]
        ]);
        ?>    
        <p>...</p>
    </div>

    <!-- Table -->
    <table class="table table-striped table-bordered table-hover"> 
        <thead> 
            <tr> 
                <th style="text-align:center;">Kode Akun</th> 
                <th style="text-align:center;">Uraian</th> 
                <th style="text-align:right;">Saldo Awal</th> 
                <!-- <th style="text-align:right;">Eliminasi</th> -->
                <th style="text-align:right;">Saldo Konsolidasi</th> 
            </tr> 
        </thead> 
        <tbody>
            <?php
                $kdAkun1 = 0;
                $kdAkun2 = 0;
                foreach($data->getModels() as $model):
                    if($kdAkun1 != $model['kd_rek_1']) echo renderAkun1($model);
                    if($kdAkun2 != $model['kd_rek_1'].$model['kd_rek_2']) echo renderAkun2($model);
            ?>
            <tr> 
                <td><?= $model['kd_rek_1'].$model['kd_rek_2'].$model['kd_rek_3'] ?></td> 
                <td><?= $model['nm_akrual_3'] ?></td> 
                <td style="text-align:right;"><?= number_format($model['realisasi_sebelum']) ?></td> 
                <td style="text-align:right;"><?= number_format($model['realisasi_sesudah']) ?></td> 
            </tr>
            <?php 
                $kdAkun1 = $model['kd_rek_1'];
                $kdAkun2 = $model['kd_rek_1'].$model['kd_rek_2'];
                endforeach;
            ?>
        </tbody> 
    </table>
</div>

<?php

function renderAkun1($model)
{
    $kdAkun1 = $model['kd_rek_1'];
    $uraian = \app\models\RefAkrual1::findOne(['kd_akrual_1' => $kdAkun1])->nm_akrual_1;
return <<<HTML
<tr> 
    <th>$kdAkun1</th> 
    <th>$uraian</th> 
    <th style="text-align:right;"></th> 
    <!-- <th style="text-align:right;">Eliminasi</th> -->
    <th style="text-align:right;"></th> 
</tr> 
HTML;
}
function renderAkun2($model)
{
    $kdAkun2 = $model['kd_rek_1'].$model['kd_rek_2'];
    $uraian = \app\models\RefAkrual2::findOne(['kd_akrual_1' => $model['kd_rek_1'], 'kd_akrual_2' => $model['kd_rek_2']])->nm_akrual_2;
return <<<HTML
<tr> 
    <th>$kdAkun2</th> 
    <th>$uraian</th> 
    <th style="text-align:right;"></th> 
    <!-- <th style="text-align:right;">Eliminasi</th> -->
    <th style="text-align:right;"></th> 
</tr> 
HTML;
}
?>