<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Periode */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="periode-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

	<?= DatePicker::widget([
			'model' => $model,
			'attribute' => 'akhir_periode',
			'type' => DatePicker::TYPE_INPUT,
			'options' => ['placeholder' => 'Akhir Periode'],              
			'pluginOptions' => [
				'autoclose'=>true,
				'format' => 'yyyy-mm-dd',
			],
		])
	?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
