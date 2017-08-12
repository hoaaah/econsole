<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\konsolidasi\models\EliminationAccountSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="elimination-account-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'tahun')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'tahun')])->label(false) ?>

    <?= $form->field($model, 'kd_pemda')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'kd_pemda')])->label(false) ?>

    <?= $form->field($model, 'kd_rek_1')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'kd_rek_1')])->label(false) ?>

    <?= $form->field($model, 'kd_rek_2')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'kd_rek_2')])->label(false) ?>

    <?= $form->field($model, 'kd_rek_3')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'kd_rek_3')])->label(false) ?>

    <?php // echo $form->field($model, 'kd_rek_4') ?>

    <?php // echo $form->field($model, 'kd_rek_5') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
