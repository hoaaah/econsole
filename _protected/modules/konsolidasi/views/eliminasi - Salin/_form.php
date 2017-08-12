<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\EliminationRecord */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="elimination-record-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'no_elim')->textInput(['maxlength' => true]) ?>

	<?= DatePicker::widget([
			'model' => $model,
			'attribute' => 'tgl_tetap',
			'type' => DatePicker::TYPE_INPUT,
			'options' => ['placeholder' => 'Penetapan'],              
			'pluginOptions' => [
				'autoclose'=>true,
				'format' => 'yyyy-mm-dd',
			],
		])
	?>    

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

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
