<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Periode */
?>
<div class="periode-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'akhir_periode',
        ],
    ]) ?>

</div>
