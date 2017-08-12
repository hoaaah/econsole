<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\EliminationAccount */

$this->title = 'Update Elimination Account: ' . $model->tahun;
$this->params['breadcrumbs'][] = ['label' => 'Elimination Accounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->tahun, 'url' => ['view', 'tahun' => $model->tahun, 'kd_pemda' => $model->kd_pemda, 'kd_rek_1' => $model->kd_rek_1, 'kd_rek_2' => $model->kd_rek_2, 'kd_rek_3' => $model->kd_rek_3, 'kd_rek_4' => $model->kd_rek_4, 'kd_rek_5' => $model->kd_rek_5]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="elimination-account-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
