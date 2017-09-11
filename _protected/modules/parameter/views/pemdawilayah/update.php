<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PemdaWilayah */

$this->title = 'Update Pemda Wilayah: ' . $model->wilayah_id;
$this->params['breadcrumbs'][] = ['label' => 'Pemda Wilayahs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->wilayah_id, 'url' => ['view', 'wilayah_id' => $model->wilayah_id, 'pemda_id' => $model->pemda_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pemda-wilayah-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
