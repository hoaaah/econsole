<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\RefWilayah */

$this->title = 'Create Ref Wilayah';
$this->params['breadcrumbs'][] = ['label' => 'Ref Wilayahs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ref-wilayah-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
