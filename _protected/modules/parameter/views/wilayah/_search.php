<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\parameter\models\RefWilayahSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ref-wilayah-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'id')])->label(false) ?>

    <?= $form->field($model, 'kodifikasi')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'kodifikasi')])->label(false) ?>

    <?= $form->field($model, 'nama_wilayah')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'nama_wilayah')])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
