<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\TaProgram;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\modules\controlhutang\models\TaRASKArsipSearch */
/* @var $form yii\widgets\ActiveForm */
?>

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

<div class="row col-md-12">
    <div class="col-md-4">
        <?php

            $model->Kd_Laporan = isset(Yii::$app->request->queryParams['Laporan']['Kd_Laporan']) ? Yii::$app->request->queryParams['Laporan']['Kd_Laporan'] : '';
            echo $form->field($model, 'Kd_Laporan')->widget(Select2::classname(), [
                'data' => [
                    '1' => 'LRA Konsolidasi',
                    '2' => 'Rekapitulasi RKAS-APBS',               
                    '3' => 'Rekapitulasi Pembuatan SPJ',
                    '4' => 'Rekapitulasi Realisasi Pendapatan dan Belanja',
                    '5' => 'Rekapitulasi SP3B dan SP2B',
                    '6' => 'Rekapitulasi Sisa dana BOS',
                    // '7' => 'BOS-K7A Realisasi Penggunaan Dana Tiap Komponen BOS',
                    // '8' => 'BOS-03 Rencana Penggunaan dana BOS per Periode',                 
                ],
                'options' => ['class' =>'form-control input-sm' ,'placeholder' => 'Pilih Jenis Laporan ...', 
                // 'onchange'=> 'this.form.submit()'
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label(false);
        ?>
    </div>
    <div class="col-md-4">
        <?php 
            // echo $form->field($model, 'kd_pemda')->widget(Select2::classname(), [
            //     'data' => ArrayHelper::map(\app\models\RefPemda::find()->select(['id', 'CONCAT(id, \' \', name) AS name'])->all(),'id','name'),
            //     'options' => ['placeholder' => 'Pilih Pemda ...'],
            //     'pluginOptions' => [
            //         'allowClear' => true
            //     ],
            // ])->label(false);
            if(isset(Yii::$app->request->queryParams['Laporan']['kd_pemda'])){
                $model->kd_pemda = Yii::$app->request->queryParams['Laporan']['kd_pemda'];             
            }
            $data = ArrayHelper::map(\app\models\RefPemda::find()->select(['id', 'CONCAT(id, \' \', name) AS name'])->all(),'id','name');
            $data = array_merge(['%' => 'Tampilkan Semua'], $data);
            echo $form->field($model, 'kd_pemda')->widget(Select2::classname(), [
                'data' => $data,
                'options' => ['placeholder' => 'Pilih Pemda', 'multiple' => true],
                'showToggleAll' => false,
                'pluginOptions' => [
                    'tags' => true,
                    'tokenSeparators' => [',', ' '],
                    // 'maximumInputLength' => 100
                ],
            ])->label(false);            
        ?>
    </div>
    <div class="col-md-2">
        <?php
            if(isset(Yii::$app->request->queryParams['Laporan']['Tgl_Laporan'])){
                $model->Tgl_Laporan = Yii::$app->request->queryParams['Laporan']['Tgl_Laporan'];             
            }ELSE{
                $model->Tgl_Laporan = $Tahun.'-12-31';
            }

            echo DatePicker::widget([
                'model' => $model,
                'attribute' => 'Tgl_Laporan',
                'type' => DatePicker::TYPE_INPUT,
                'options' => ['placeholder' => 'Berakhir Pada'],              
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'yyyy-mm-dd',
                ],
            ]);               
        ?>    
    </div>    
</div>
<div class="row col-md-12">   
    <div class="col-md-2 pull-right">
        <?= Html::submitButton( 'Pilih', ['class' => 'btn btn-default']) ?>        
    </div>
</div>

    <?php ActiveForm::end(); ?>
