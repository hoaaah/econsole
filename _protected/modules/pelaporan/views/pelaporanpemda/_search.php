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
<div class="col-md-12">
<div class="box box-primary">
<div class="box-body">
<div class="row col-md-12">
    <div class="col-md-3">
        <?php

            $model->Kd_Laporan = isset(Yii::$app->request->queryParams['Laporan']['Kd_Laporan']) ? Yii::$app->request->queryParams['Laporan']['Kd_Laporan'] : '';
            echo $form->field($model, 'Kd_Laporan')->widget(Select2::classname(), [
                'data' => [
                    4 => 'LRA Pemda',
                    5 => 'Rekapitulasi Akun Eliminasi',
                    // 6 => 'LRA Per Level Rekening',               
                ],
                'options' => ['class' =>'form-control input-sm' ,'placeholder' => 'Pilih Jenis Laporan ...', 'id' => 'field-kd_laporan'
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label(false);
        ?>
    </div>
    <div style="display:<?= isset(Yii::$app->request->queryParams['Laporan']['Kd_Laporan']) && (Yii::$app->request->queryParams['Laporan']['Kd_Laporan'] == 4 || Yii::$app->request->queryParams['Laporan']['Kd_Laporan'] == 5) ? 'block' : 'none' ?>;" id="block-pemda" class="col-md-4">
        <?php 
            if(isset(Yii::$app->request->queryParams['Laporan']['kd_pemda'])){
                $model->kd_pemda = Yii::$app->request->queryParams['Laporan']['kd_pemda'];             
            }
            $dropdownPemda = \app\models\RefPemda::find()->select(['id', 'CONCAT(id, \' \', name) AS name']);
            if(isset(Yii::$app->user->identity->pemda_id) && Yii::$app->user->identity->pemda_id != NULL){
                $dropdownPemda->andWhere(['id' => Yii::$app->user->identity->pemda_id]);
            }
            $dropdownPemda = $dropdownPemda->all();
            $data = ArrayHelper::map($dropdownPemda,'id','name');
            // $data = array_merge(['%' => 'Tampilkan Semua'], $data);
            echo $form->field($model, 'kd_pemda')->widget(Select2::classname(), [
                'data' => $data,
                'options' => [
                    'placeholder' => 'Pilih Pemda', 
                    // 'multiple' => true
                ],
                // 'showToggleAll' => false,
                'pluginOptions' => [
                    // 'tags' => true,
                    // 'tokenSeparators' => [',', ' '],
                    // 'maximumInputLength' => 100
                ],
            ])->label(false);        
        ?>
    </div>

</div>
<div class="row col-md-12">   
    <div class="col-md-2">
        <?php
            if(isset(Yii::$app->request->queryParams['Laporan']['periode_id'])){
                $model->periode_id = Yii::$app->request->queryParams['Laporan']['periode_id'];             
            }
            $periodeList = ArrayHelper::map(\app\models\Periode::find()->select(['id', 'CONCAT(id, \'. \', name) AS name'])->all(),'id','name');
            // $data = array_merge(['%' => 'Tampilkan Semua'], $data);
            echo $form->field($model, 'periode_id')->widget(Select2::classname(), [
                'data' => $periodeList,
                'options' => [
                    'placeholder' => 'Pilih Periode Pelaporan',
                ],
                'pluginOptions' => [
                    // 'tags' => true,
                    // 'tokenSeparators' => [',', ' '],
                    // 'maximumInputLength' => 100
                ],
            ])->label(false);              
        ?>    
    </div>    
    <div class="col-md-2 pull-right">
        <?= Html::submitButton( 'Pilih', ['class' => 'btn btn-default']) ?>        
    </div>
</div>
</div> <!--box-body-->
</div> <!--box-->
</div> <!--col-->

<?php ActiveForm::end(); ?>

<?php 
$this->registerJs(<<<JS
    $("#field-kd_laporan").on("change", function(){
        // hide all first
        $("#block-wilayah").hide();
        $("#block-provinsi").hide();
        $("#block-pemda").hide();
        $("#block-elim").hide();

        var kdLaporan = $(this).val() - 0; // convert to number first, not work in certain browser
        
        // then show it
        switch(kdLaporan) {
            case 2:
                $("#block-wilayah").show();
                break;
            case 3:
                $("#block-provinsi").show();
                break;
            case 4:
                $("#block-pemda").show();
                break;
            case 5:
                $("#block-pemda").show();
                break;
            default:
                // code block
        }
    })

    $("#field-block-elim").on("change", function(){
        // hide all first
        $("#block-wilayah").hide();
        $("#block-provinsi").hide();
        $("#block-pemda").hide();

        var kdElim = $(this).val() - 0; // convert to number first, not work in certain browser
        
        // then show it
        switch(kdElim) {
            case 2:
                $("#block-wilayah").show();
                break;
            case 1:
                $("#block-provinsi").show();
                break;
            default:
                // code block
        }
    })    
JS
);
?>