<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\controlhutang\models\RekananSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pelaporan';
$this->params['breadcrumbs'][] = 'Pelaporan';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
<?php echo $this->render('_search', ['model' => $get, 'Tahun' => $Tahun]); ?>
</div>
<?php IF($Kd_Laporan <> NULL) : ?>

                <?php 
	                switch ($Kd_Laporan) {
	                    case 1:
	                        $heading = 'LRA Nasional '.$Tahun;
	                        break;
						case 2:
							$wilayah = \app\models\RefWilayah::findOne(['id' => $getparam['Laporan']['kd_wilayah']]);
	                        $heading = 'LRA Wilayah '.$wilayah->nama_wilayah.' '.$Tahun;
	                        break;	                	
						case 3:
							$provinsi =  Yii::$app->db->createCommand("
							SELECT a.province_id,  b.name
							FROM ref_pemda a INNER JOIN
							(
								SELECT a.id, RIGHT(a.id,2) AS province_flag, a.name, a.province_id FROM ref_pemda a
								WHERE province_id = :province_id
								HAVING province_flag = '00'
							)b ON a.id = b.id
							GROUP BY a.province_id, b.name
							ORDER BY province_id
							")->bindValues([':province_id' => $getparam['Laporan']['kd_provinsi']])->queryOne();
	                        $heading = 'LRA Regional '.$provinsi['name'].' '.$Tahun;
	                        break;
						case 4:
							$pemda = \app\models\RefPemda::findOne(['id' => $getparam['Laporan']['kd_pemda']]);
	                        $heading = 'LRA Pemda '.$pemda['name'].' '.$Tahun;
	                        break;
                        // case 5:
                        //     $heading = 'Rekapitulasi SP3B dan SP2B '.$Tahun;
                        //     break;
                        // case 6:
                        //     $heading = 'Rekapitulasi Sisa dana BOS '.$Tahun;
                        //     break;
                        // case 7:
                        //     $heading = 'BOS-K7A Realisasi Penggunaan Dana Tiap Komponen BOS '.$Tahun;
                        //     break;
	                    default:
	                        # code...
	                        break;
	                }
                ?>
   
                <?php echo $this->render($render, [
                	'data' => $data, 
		            'data1' => $data1,
		            'data2' => $data2,
		            'data3' => $data3,
		            'data4' => $data4,
		            'data5' => $data5,
		            'data6' => $data6,
                	'heading' => $heading, 
                	'getparam' => $getparam]); ?>

<?php endif; ?>
