<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\widgets\DatePicker;
use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model app\models\EliminationAccount */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="elimination-account-form">

    <?php $form = ActiveForm::begin(['id' => $model->formName()]); ?>

    <?php               
        if(!Yii::$app->user->identity->pemda_id) 
        echo $form->field($model, 'kd_pemda')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(\app\models\RefPemda::find()->select(['id', 'CONCAT(id, \' \', name) AS name'])->all(),'id','name'),
            'options' => ['placeholder' => 'Pilih Pemda ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
    ?>

    <?= $form->field($model, 'category')->widget(Select2::classname(), [
            'data' => [
                1 => 'Parent / Belanja',
                2 => 'Child / Pendapatan',
            ],
            'options' => ['placeholder' => 'Pilih Kategori ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]); ?>
    
    <?php
        $url = Url::toRoute(['/konsolidasi/akun/rek3', 'tahun' => $elRecord->tahun, 'kd_pemda' => $elRecord->kd_pemda], true);
    /*        
        echo $form->field($model, 'kd3')->widget(Select2::classname(), [
            'options' => ['placeholder' => 'Pilih Rekening ...'],
            'pluginOptions' => [
                'allowClear' => true,
                'minimumInputLength' => 1,
                'language' => [
                    'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                ],
                'ajax' => [
                    'url' => $url,
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                ],
                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                'templateResult' => new JsExpression('function(kd3) { return kd3.text; }'),
                'templateSelection' => new JsExpression('function (kd3) { return kd3.text; }'),
            ],
        ]);
    */ 

    echo  $form->field($model, 'kd3')->widget(Select2::classname(), [
            'data' => ArrayHelper::map($dropDownRek3,'kd3','akun'),
            'options' => ['placeholder' => 'Pilih Rekening ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
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

$script = <<<JS
    // $.ajax({
    //     url: "$url",
    //     type: "GET",
    //     dataType: "html",
    //     success:function(data) {                   
    //         $('select[name="kd3"]').empty();
    //         $('select[name="kd3"]').append('<option selected="selected" value="">Pilih Rekening ...</option>');
    //         $.each(data, function(key, value) {
    //             $('select[name="kd3"]').append('<option value="'+ key +'">'+ value +'</option>');
    //             console.log('append');
    //         });
    //     }
    // });
JS;
$this->registerJs($script);
?>