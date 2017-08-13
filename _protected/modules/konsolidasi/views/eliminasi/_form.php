<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\widgets\DatePicker;
use yii\helpers\Url;
use yii\web\JsExpression;
use kartik\widgets\DepDrop;

/* @var $this yii\web\View */
/* @var $model app\models\EliminationAccount */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="elimination-account-form">

    <?php $form = ActiveForm::begin(['id' => $model->formName()]); ?>

    <?php
        echo $form->field($model, 'transfer_id')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(\app\models\RefTransfer::find()->all(), 'id','jenis_transfer'),
            'options' => ['placeholder' => 'Pilih Kategori Transfer ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);

        // $url = Url::toRoute(['/konsolidasi/akun/getrek3', 'tahun' => $elRecord->tahun, 'kd_pemda' => $elRecord->kd_pemda], true);
        if(!Yii::$app->user->identity->pemda_id){
            $dataPemda = ArrayHelper::map(\app\models\RefPemda::find()->select(['id', 'CONCAT(id, \' \', name) AS name'])->all(),'id','name');
        }else{
            $dataPemda = ArrayHelper::map(\app\models\RefPemda::find()->where(['id' => Yii::$app->user->identity->pemda_id])->select(['id', 'CONCAT(id, \' \', name) AS name'])->all(),'id','name');
            $dataPemda = array_merge(['0.0' => '0.0 [--- Pilih Pemda ---]'], $dataPemda);
            $model->kd_pemda = '0.0';
        }
        
        echo $form->field($model, 'kd_pemda')->widget(Select2::classname(), [
            'data' => $dataPemda,
            'options' => ['placeholder' => 'Pilih Pemda ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        // this is depdrop ways
        // Child level 1
        if(isset($model->kd_rek_1)) $model->kd3 = $model->kd_rek_1.'.'.$model->kd_rek_2.'.'.$model->kd_rek_3;
        echo $form->field($model, 'kd3')->widget(DepDrop::classname(), [
            'data'=> ArrayHelper::map($dropDownRek3,'kd3','akun'),
            'options' => ['placeholder' => 'Pilih Jenis Akun ...'],
            'type' => DepDrop::TYPE_SELECT2,
            'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
            'pluginOptions'=>[
                'depends'=>['eliminationaccount-kd_pemda'],
                'url' => Url::to(['/konsolidasi/eliminasi/rek3']),
                'loadingText' => 'Loading ...',
            ]
        ]); 

        // Child level 2
        if(isset($model->kd_rek_1)) $model->kd4 = $model->kd_rek_1.'.'.$model->kd_rek_2.'.'.$model->kd_rek_3.'.'.$model->kd_rek_4;
        echo $form->field($model, 'kd4')->widget(DepDrop::classname(), [
            'data'=> $model->isNewRecord ? [] : ArrayHelper::map($dropDownRek4,'kd4','akun'),
            'options' => ['placeholder' => 'Pilih Objek ...'],
            'type' => DepDrop::TYPE_SELECT2,
            'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
            'pluginOptions'=>[
                'depends'=>['eliminationaccount-kd_pemda', 'eliminationaccount-kd3'],
                'url' => Url::to(['/konsolidasi/eliminasi/rek4']),
                'loadingText' => 'Loading ...',
            ]
        ]); 

        // Child level 3
        if(isset($model->kd_rek_1)) $model->kd5 = $model->kd_rek_1.'.'.$model->kd_rek_2.'.'.$model->kd_rek_3.'.'.$model->kd_rek_4.'.'.$model->kd_rek_5;
        echo $form->field($model, 'kd5')->widget(DepDrop::classname(), [
            'data'=> $model->isNewRecord ? [] :  ArrayHelper::map($dropDownRek5,'kd5','akun'),
            'options' => ['placeholder' => 'Pilih Rincian Objek ...'],
            'type' => DepDrop::TYPE_SELECT2,
            'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
            'pluginOptions'=>[
                'depends'=>['eliminationaccount-kd_pemda', 'eliminationaccount-kd3', 'eliminationaccount-kd4'],
                'url' => Url::to(['/konsolidasi/eliminasi/rek5']),
                'loadingText' => 'Loading ...',
            ]
        ]);
    
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php $script = <<<JS
$('form#{$model->formName()}').on('beforeSubmit',function(e)
{
    var \$form = $(this);
    $.post(
        \$form.attr("action"), //serialize Yii2 form 
        \$form.serialize()
    )
        .done(function(result){
            if(result == 1)
            {
                $("#myModal").modal('hide'); //hide modal after submit
                //$(\$form).trigger("reset"); //reset form to reuse it to input
                $.pjax.reload({container:'#elimination-account-pjax'});
            }else
            {
                $("#message").html(result);
            }
        }).fail(function(){
            console.log("server error");
        });
    return false;
});

JS;
$this->registerJs($script);
?>