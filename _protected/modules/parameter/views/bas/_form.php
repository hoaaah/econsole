<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\JsExpression;
use kartik\widgets\DepDrop;

/* @var $this yii\web\View */
/* @var $model app\models\RefAkrual3 */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ref-akrual3-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php 
        // Child level 1
        echo $form->field($model, 'kd_akrual_1')->widget(Select2::classname(), [
            'data'=> ArrayHelper::map(\app\models\RefAkrual1::find()->select(['kd_akrual_1', 'CONCAT(kd_akrual_1, \' \', nm_akrual_1) AS nm_akrual_1'])->all(),'kd_akrual_1','nm_akrual_1'),
            'options' => ['placeholder' => 'Pilih Akun ...'],
            'pluginOptions'=>['allowClear'=>true],
            ]); 

        if(isset($model->kd_akrual_2)){
            $dropDownRek2 = \app\models\RefAkrual2::find()->select(['kd_akrual_2', 'CONCAT(kd_akrual_1, \'.\', kd_akrual_2, \' \', nm_akrual_2) AS nm_akrual_2'])->where(['kd_akrual_1'=> $model->kd_akrual_1])->all();
        };
        echo $form->field($model, 'kd_akrual_2')->widget(DepDrop::classname(), [
            'data'=> $model->isNewRecord ? [] : ArrayHelper::map($dropDownRek2,'kd_akrual_2','nm_akrual_2'),
            'options' => ['placeholder' => 'Pilih Kelompok ...'],
            'type' => DepDrop::TYPE_SELECT2,
            'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
            'pluginOptions'=>[
                'depends'=>['refakrual3-kd_akrual_1'],
                'url' => Url::to(['/parameter/bas/rek2']),
                'loadingText' => 'Loading ...',
            ]
        ]);         
    ?>

    <?= $form->field($model, 'kd_akrual_3')->textInput() ?>

    <?= $form->field($model, 'nm_akrual_3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'saldoNorm')->textInput(['maxlength' => true]) ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
