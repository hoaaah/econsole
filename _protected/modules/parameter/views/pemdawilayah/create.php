<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PemdaWilayah */

$this->title = 'Create Pemda Wilayah';
$this->params['breadcrumbs'][] = ['label' => 'Pemda Wilayahs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pemda-wilayah-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
