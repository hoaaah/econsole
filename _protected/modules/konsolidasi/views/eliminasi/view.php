<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\EliminationAccount */

$this->title = $model->tahun;
$this->params['breadcrumbs'][] = ['label' => 'Elimination Accounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="elimination-account-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'tahun' => $model->tahun, 'kd_pemda' => $model->kd_pemda, 'kd_rek_1' => $model->kd_rek_1, 'kd_rek_2' => $model->kd_rek_2, 'kd_rek_3' => $model->kd_rek_3, 'kd_rek_4' => $model->kd_rek_4, 'kd_rek_5' => $model->kd_rek_5], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'tahun' => $model->tahun, 'kd_pemda' => $model->kd_pemda, 'kd_rek_1' => $model->kd_rek_1, 'kd_rek_2' => $model->kd_rek_2, 'kd_rek_3' => $model->kd_rek_3, 'kd_rek_4' => $model->kd_rek_4, 'kd_rek_5' => $model->kd_rek_5], [
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
            'tahun',
            'kd_pemda',
            'kd_rek_1',
            'kd_rek_2',
            'kd_rek_3',
            'kd_rek_4',
            'kd_rek_5',
        ],
    ]) ?>

</div>
