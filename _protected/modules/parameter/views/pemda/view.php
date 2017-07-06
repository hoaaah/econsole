<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\RefPemda */
?>
<div class="ref-pemda-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'province_id',
            'name',
        ],
    ]) ?>

</div>
