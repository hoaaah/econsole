<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\RefAkrual3 */
?>
<div class="ref-akrual3-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'kd_akrual_1',
            'kd_akrual_2',
            'kd_akrual_3',
            'nm_akrual_3',
            'saldoNorm',
        ],
    ]) ?>

</div>
