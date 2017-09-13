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
                    1 => 'LRA Nasional',
                    2 => 'LRA Wilayah',               
                    3 => 'LRA Regional Provinsi',
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
    <div id="block-elim" style="display:<?= isset(Yii::$app->request->queryParams['Laporan']['Kd_Laporan']) && Yii::$app->request->queryParams['Laporan']['Kd_Laporan'] == 5 ? 'block' : 'none' ?>;" class="col-md-4">
        <?php 
            if(isset(Yii::$app->request->queryParams['Laporan']['elimination_level'])){
                $model->elimination_level = Yii::$app->request->queryParams['Laporan']['elimination_level'];             
            }
            $dropDownTransfer = ArrayHelper::map(\app\models\RefTransfer::find()->select(['id', 'CONCAT(id, \'. \', jenis_transfer) AS jenis_transfer'])->all(),'id','jenis_transfer');
            echo $form->field($model, 'elimination_level')->widget(Select2::classname(), [
                'data' => $dropDownTransfer,
                'options' => ['id' => 'field-block-elim', 'placeholder' => 'Tingkat Eliminasi'],
            ])->label(false);        
        ?>
    </div>    
    <div id="block-wilayah" style="display:<?= (isset(Yii::$app->request->queryParams['Laporan']['Kd_Laporan']) && Yii::$app->request->queryParams['Laporan']['Kd_Laporan'] == 2) || (isset(Yii::$app->request->queryParams['Laporan']['elimination_level']) && Yii::$app->request->queryParams['Laporan']['elimination_level'] == 2) ? 'block' : 'none' ?>;" class="col-md-4">
        <?php 
            if(isset(Yii::$app->request->queryParams['Laporan']['kd_wilayah'])){
                $model->kd_wilayah = Yii::$app->request->queryParams['Laporan']['kd_wilayah'];             
            }
            $dropDownWilayah = ArrayHelper::map(\app\models\RefWilayah::find()->select(['id', 'CONCAT(id, \'. \', nama_wilayah) AS nama_wilayah'])->all(),'id','nama_wilayah');
            echo $form->field($model, 'kd_wilayah')->widget(Select2::classname(), [
                'data' => $dropDownWilayah,
                'options' => ['placeholder' => 'Pilih Wilayah'],
                'pluginOptions' => [
                    // 'tags' => true,
                    // 'tokenSeparators' => [',', ' '],
                    // 'maximumInputLength' => 100
                ],
            ])->label(false);        
        ?>
    </div>
    <div id="block-provinsi" style="display:<?= (isset(Yii::$app->request->queryParams['Laporan']['Kd_Laporan']) && Yii::$app->request->queryParams['Laporan']['Kd_Laporan'] == 3) || (isset(Yii::$app->request->queryParams['Laporan']['elimination_level']) && Yii::$app->request->queryParams['Laporan']['elimination_level'] == 1) ? 'block' : 'none' ?>;" class="col-md-4">
        <?php 
            if(isset(Yii::$app->request->queryParams['Laporan']['kd_provinsi'])){
                $model->kd_provinsi = Yii::$app->request->queryParams['Laporan']['kd_provinsi'];             
            }
$query =  Yii::$app->db->createCommand(<<<SQL
SELECT CONVERT(a.province_id, UNSIGNED integer) AS province_id,  CONCAT(a.province_id, '. ', b.name) as name
FROM ref_pemda a INNER JOIN
(
	SELECT a.id, RIGHT(a.id,2) AS province_flag, a.name, a.province_id FROM ref_pemda a
	HAVING province_flag = '00'
)b ON a.id = b.id
GROUP BY a.province_id, b.name
ORDER BY province_id
SQL
)->queryAll();
            $dropDownProvinsi = ArrayHelper::map($query,'province_id','name');
            echo $form->field($model, 'kd_provinsi')->widget(Select2::classname(), [
                'data' => $dropDownProvinsi,
                'options' => ['placeholder' => 'Pilih Provinsi'],
                'pluginOptions' => [
                    // 'tags' => true,
                    // 'tokenSeparators' => [',', ' '],
                    // 'maximumInputLength' => 100
                ],
            ])->label(false);        
        ?>
    </div> 
    <div style="display:<?= isset(Yii::$app->request->queryParams['Laporan']['Kd_Laporan']) && Yii::$app->request->queryParams['Laporan']['Kd_Laporan'] == 4 ? 'block' : 'none' ?>;" id="block-pemda" class="col-md-4">
        <?php 
            if(isset(Yii::$app->request->queryParams['Laporan']['kd_pemda'])){
                $model->kd_pemda = Yii::$app->request->queryParams['Laporan']['kd_pemda'];             
            }
            $data = ArrayHelper::map(\app\models\RefPemda::find()->select(['id', 'CONCAT(id, \' \', name) AS name'])->all(),'id','name');
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
                $("#block-elim").show();
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