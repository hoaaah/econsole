<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RefAkrual3 */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ref-akrual3-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'kd_akrual_1')->textInput() ?>

    <?= $form->field($model, 'kd_akrual_2')->textInput() ?>

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
