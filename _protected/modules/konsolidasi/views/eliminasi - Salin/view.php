<?php

use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\EliminationRecord */

$this->title = 'Elimination Accounts: '.$model->no_elim;
$this->params['breadcrumbs'][] = ['label' => 'Elimination Records', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="elimination-record-view">
    <div class="row">
        <div class="col-sm-12 col-md-10 col-lg-8">
            <?= DetailView::widget([
                    'model' => $model,
                    'condensed'=>true,
                    'hover'=>true,
                    'mode'=>DetailView::MODE_VIEW,
                    'enableEditMode' => false,
                    'hideIfEmpty' => false, //sembunyikan row ketika kosong
                    'panel'=>[
                        'heading'=>'<i class="fa fa-tag"></i> '.$this->title.'</h3>',
                        'type'=>'primary',
                        'headingOptions' => [
                            'tag' => 'h3', //tag untuk heading
                        ],
                    ],
                    'buttons1' => '{update}', // tombol mode default, default '{update} {delete}'
                    'buttons2' => '{save} {view}', // tombol mode kedua, default '{view} {reset} {save}'
                    'viewOptions' => [
                        'label' => '<span class="glyphicon glyphicon-remove-circle"></span>',
                    ],   
                'attributes' => [
                    'id',
                    'tahun',
                    'no_elim',
                    'tgl_tetap',
                    'kd_provinsi',
                    'kd_pemda',
                    'user_id',
                    'created_at:date',
                    'updated_at:date',
                ],
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12"> 
            <?=
                $this->render('/akun/index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'model' => $model,
                ]);
            ?>    
        </div>
    </div>
</div>
