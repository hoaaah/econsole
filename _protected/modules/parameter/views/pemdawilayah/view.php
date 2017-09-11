<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\PemdaWilayah */

$this->title = $model->wilayah_id;
$this->params['breadcrumbs'][] = ['label' => 'Pemda Wilayahs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pemda-wilayah-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'wilayah_id' => $model->wilayah_id, 'pemda_id' => $model->pemda_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'wilayah_id' => $model->wilayah_id, 'pemda_id' => $model->pemda_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'wilayah_id',
            'pemda_id',
        ],
    ]) ?>

</div>
