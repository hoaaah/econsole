<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\EliminationAccount */

$this->title = 'Create Elimination Account';
$this->params['breadcrumbs'][] = ['label' => 'Elimination Accounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="elimination-account-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
