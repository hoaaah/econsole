<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\EliminationAccount */

$this->title = 'Update Elimination Account: ' . $model->tahun;
$this->params['breadcrumbs'][] = ['label' => 'Elimination Accounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->tahun, 'url' => ['view', 'tahun' => $model->tahun, 'el_id' => $model->el_id, 'kd_pemda' => $model->kd_pemda, 'category' => $model->category]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="elimination-account-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
