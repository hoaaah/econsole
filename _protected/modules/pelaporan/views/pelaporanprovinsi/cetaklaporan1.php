<?php
Use app\itbz\fpdf\src\fpdf\fpdf;


class PDF extends \fpdf\FPDF
{
    function Footer()
    {

        // $this->SetY(-15);
        // $this->SetFont('Times','I',8);
        // $this->Cell(0,10,'Printed By BosSTAN '.$this->PageNo().'/{nb}',0,0,'R');
        // $this->Image(\yii\helpers\Url::to(['/site/qr', 'url' => Yii::$app->request->absoluteUrl], true), $this->getX()-55, $this->getY()-5 , 15, 0,'PNG'); // 156, 320
    }

    function changePage($bottomMargin, $yst, $w, $marginLeft, $x)
    {
        $ylst = $bottomMargin - $yst; //207 batas margin bawah dikurang dengan y pertama
        //setiap selesai page maka buat rectangle
        $this->Rect($x, $yst, $w['0'] ,$ylst);
        $this->Rect($x+$w['0'], $yst, $w['1'] ,$ylst);
        $this->Rect($x+$w['0']+$w['1'], $yst, $w['2'] ,$ylst);
        
        //setelah buat rectangle baru kemudian addPage
        $this->AddPage();
        $this->SetAutoPageBreak(true,10);
        $this->AliasNbPages();

        $this->SetFont('Times','B',10);
        $this->SetXY($marginLeft, $this->GetY()+15);
        $this->Cell($w['0'],6,'Kode Akun','TL',0,'C');
        $this->Cell($w['1'],6,'Uraian Akun','TLR',0,'C');
        $this->Cell($w['2'],6,'Realisasi','TLR',0,'C');
    
        $this->ln();
    }

}

$pdf = new PDF('P', 'mm', 'A4');
function getAkun1($model)
{
    $kdAkun1 = $model['kd_rek_1'];
    $uraian = \app\models\RefAkrual1::findOne(['kd_akrual_1' => $kdAkun1])->nm_akrual_1;
    return $uraian;
}
function getAkun2($model)
{
    $uraian = '[--Rekening Tidak Terdaftar--]';
    $kdAkun2 = $model['kd_rek_1'].$model['kd_rek_2'];
    $refAkrual2 = \app\models\RefAkrual2::findOne(['kd_akrual_1' => $model['kd_rek_1'], 'kd_akrual_2' => $model['kd_rek_2']]);
    if($refAkrual2) $uraian = $refAkrual2->nm_akrual_2;
    return $uraian;
}
function bulan($bulan){
	Switch ($bulan){
	    case 1 : $bulan="31 Januari";
	        Break;
	    case 2 : $bulan="28 Februari";
	        Break;
	    case 3 : $bulan="31 Maret";
	        Break;
	    case 4 : $bulan="30 April";
	        Break;
	    case 5 : $bulan="31 Mei";
	        Break;
	    case 6 : $bulan="30 Juni";
	        Break;
	    case 7 : $bulan="31 Juli";
	        Break;
	    case 8 : $bulan="31 Agustus";
	        Break;
	    case 9 : $bulan="30 September";
	        Break;
	    case 10 : $bulan="31 Oktober";
	        Break;
	    case 11 : $bulan="30 November";
	        Break;
	    case 12 : $bulan="31 Desember";
            Break;
	    case 16 : $bulan="30 Juni";
            Break;
        default: $bulan="31 Desember";
            break;        
        }
        
	return $bulan;
}


function kekata($x) {
    $x = abs($x);
    $angka = array("", "satu", "dua", "tiga", "empat", "lima",
    "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($x <12) {
        $temp = " ". $angka[$x];
    } else if ($x <20) {
        $temp = kekata($x - 10). " belas";
    } else if ($x <100) {
        $temp = kekata($x/10)." puluh". kekata($x % 10);
    } else if ($x <200) {
        $temp = " seratus" . kekata($x - 100);
    } else if ($x <1000) {
        $temp = kekata($x/100) . " ratus" . kekata($x % 100);
    } else if ($x <2000) {
        $temp = " seribu" . kekata($x - 1000);
    } else if ($x <1000000) {
        $temp = kekata($x/1000) . " ribu" . kekata($x % 1000);
    } else if ($x <1000000000) {
        $temp = kekata($x/1000000) . " juta" . kekata($x % 1000000);
    } else if ($x <1000000000000) {
        $temp = kekata($x/1000000000) . " milyar" . kekata(fmod($x,1000000000));
    } else if ($x <1000000000000000) {
        $temp = kekata($x/1000000000000) . " trilyun" . kekata(fmod($x,1000000000000));
    }     
        return $temp;
}
 
 
function terbilang($x, $style=4) {
    if($x<0) {
        $hasil = "minus ". trim(kekata($x));
    } else {
        $hasil = trim(kekata($x));
    }     
    switch ($style) {
        case 1:
            $hasil = strtoupper($hasil);
            break;
        case 2:
            $hasil = strtolower($hasil);
            break;
        case 3:
            $hasil = ucwords($hasil);
            break;
        default:
            $hasil = ucfirst($hasil);
            break;
    }     
    return $hasil;
}

if($Kd_Laporan <> null){
    switch ($Kd_Laporan) {
        case 1:
            $heading = 'Laporan Realisasi Anggaran Konsolidasian Nasional ';
            break;
        case 2:
            $wilayah = \app\models\RefWilayah::findOne(['id' => $getparam['Laporan']['kd_wilayah']]);
            $heading = 'Laporan Realisasi Anggaran Konsolidasian Wilayah '.$wilayah->nama_wilayah;
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
            $heading = 'Laporan Realisasi Anggaran Konsolidasian Regional '.$provinsi['name'];
            break;
        case 4:
            $pemda = \app\models\RefPemda::findOne(['id' => $getparam['Laporan']['kd_pemda']]);
            $heading = 'Laporan Realisasi Anggaran Pemda '.$pemda['name'];
            break;
        case 5:
            $label = '';
            switch ($getparam['Laporan']['elimination_level']) {
                case 1:
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
                    $label = $provinsi['name'];
                    break;
                case 2:
                    $wilayah = \app\models\RefWilayah::findOne(['id' => $getparam['Laporan']['kd_wilayah']]);
                    $label = 'Wilayah '.$wilayah['nama_wilayah'];
                    break;
                
                default:
                    # code...
                    break;
            }
            $heading = 'Rekapitulasi Akun Elimininasi '.$label.' '.$Tahun;
            break;
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
}
//cara menambahkan image dalam dokumen. 
//Urutan data-> alamat file-posisi X- posisi Y-ukuran width - ukuran high -  
//menambahkan link bila perlu

// $pdf->SetRightMargin(180)

$border = 0;
$pdf->AddPage();
$pdf->SetAutoPageBreak(true,10);
$pdf->AliasNbPages();
$marginLeft = 15;


$pdf->SetFont('Times','B',12);
$pdf->SetXY($marginLeft,20);
$pdf->MultiCell(180,5,strtoupper($heading), '', 'C', 0);
$pdf->SetXY($marginLeft,$pdf->GetY());
$pdf->MultiCell(180,5, strtoupper('UNTUK TAHUN YANG BERAKHIR SAMPAI DENGAN '.bulan($getparam['Laporan']['periode_id']).' '.$Tahun), '', 'C', 0);


$w = [20, 125, 35]; // Tentukan width masing-masing kolom
 
$pdf->SetFont('Times','B',10);
$pdf->SetXY($marginLeft, $pdf->GetY()+10);
$pdf->Cell($w['0'],6,'Kode Akun','TL',0,'C');
$pdf->Cell($w['1'],6,'Uraian Akun','TLR',0,'C');
$pdf->Cell($w['2'],6,'Realisasi','TLR',0,'C');
$pdf->ln();

$baris1 = $y1 = $pdf->GetY(); // Untuk baris berikutnya
$y2 = $pdf->GetY(); //untuk baris berikutnya
$y3 = $pdf->GetY(); //untuk baris berikutnya
$yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
$x = 15;
$program = NULL;
$subprogram = NULL;
$kegiatan = NULL;
$rek1 = NULL;
$i = 1;

$ysisa = $y1;

$kdAkun1 = 0;
$kdAkun2 = 0;
$checkAkun4 = $checkAkun5 = $checkAkun6 = $checkAkun71 = $checkAkun72 = $checkAkun7 = false;
$totalSebelum2 = $totalSesudah2 = $totalSebelum1 = $totalSesudah1 = $totalAkun4Sebelum = $totalAkun4Sesudah = $totalAkun5Sebelum = $totalAkun5Sesudah =
$totalAkun61Sebelum = $totalAkun61Sesudah = $totalAkun62Sebelum = $totalAkun62Sesudah = $totalAkun71Sebelum = $totalAkun71Sesudah = $totalAkun72Sebelum = $totalAkun72Sesudah = 0;

foreach($data as $model){

    $y = MAX($y1, $y2, $y3);

    if($kdAkun1 != $model['kd_rek_1'] && $kdAkun1 != 0){
        IF($y2 > 275 || $y1 + (5*(strlen("Total " .getAkun2($lastModel))/35)) > 275 ){ //cek pagebreak
            $pdf->changePage(280, $yst, $w, $marginLeft, $x);
            $y1 = $pdf->GetY(); // Untuk baris berikutnya
            $y2 = $pdf->GetY(); //untuk baris berikutnya
            $y3 = $pdf->GetY(); //untuk baris berikutnya
            $yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
            $x = 15;
            $ysisa = $y1;
            $y = max($y1, $y2, $y3);
        }

        $pdf->SetFont('Times','B',10);
        $pdf->SetXY($x+3, $y);
        $xcurrent= $x;
        $pdf->MultiCell($w['0'],5,'','','L');
        $xcurrent = $xcurrent+$w['0'];
        $pdf->SetXY($xcurrent+2, $y);
        $pdf->MultiCell($w['1']-2,5,"Total " .getAkun2($lastModel),'','R');
        $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
        $xcurrent = $xcurrent+$w['1'];
         $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w['2'],5,number_format($totalSesudah2,0,',','.'),'','R');
        $y = MAX($y1, $y2, $y3);
        $ysisa = $y;
        $pdf->ln();

        $totalSebelum2 = 0; $totalSesudah2 = 0;

        IF($y2 > 275 || $y1 + (5*(strlen("Total " .getAkun1($lastModel))/35)) > 275 ){ //cek pagebreak
            $pdf->changePage(280, $yst, $w, $marginLeft, $x);
            $y1 = $pdf->GetY(); // Untuk baris berikutnya
            $y2 = $pdf->GetY(); //untuk baris berikutnya
            $y3 = $pdf->GetY(); //untuk baris berikutnya
            $yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
            $x = 15;
            $ysisa = $y1;
            $y = max($y1, $y2, $y3);
        }

        $pdf->SetFont('Times','B',10);
        $pdf->SetXY($x+3, $y);
        $xcurrent= $x;
        $pdf->MultiCell($w['0'],5,'','','L');
        $xcurrent = $xcurrent+$w['0'];
        $pdf->SetXY($xcurrent+2, $y);
        $pdf->MultiCell($w['1']-2,5,"Total " .getAkun1($lastModel),'','R');
        $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
        $xcurrent = $xcurrent+$w['1'];
         $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w['2'],5,number_format($totalSesudah1,0,',','.'),'','R');
        $y = MAX($y1, $y2, $y3);
        $ysisa = $y;
        $pdf->ln();

        $totalSebelum1 = 0; $totalSesudah1 = 0;
    }
    if($kdAkun1 != $model['kd_rek_1'] && $model['kd_rek_1'] == 7){
        $totalPendapatanSebelum = $totalAkun4Sebelum;
        $totalPendapatanSesudah = $totalAkun4Sesudah;
        $totalBelanjaSebelum = $totalAkun5Sebelum+$totalAkun61Sebelum+$totalAkun62Sebelum;
        $totalBelanjaSesudah = $totalAkun5Sesudah+$totalAkun61Sesudah+$totalAkun62Sesudah;

        IF($y2 > 275 || $y1 + (5*(strlen("Jumlah Belanja dan Transfer")/35)) > 275 ){ //cek pagebreak
            $pdf->changePage(280, $yst, $w, $marginLeft, $x);
            $y1 = $pdf->GetY(); // Untuk baris berikutnya
            $y2 = $pdf->GetY(); //untuk baris berikutnya
            $y3 = $pdf->GetY(); //untuk baris berikutnya
            $yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
            $x = 15;
            $ysisa = $y1;
            $y = max($y1, $y2, $y3);
        }


        $pdf->SetFont('Times','B',10);
        $pdf->SetXY($x, $y);
        $xcurrent= $x;
        $pdf->MultiCell($w['0'],5,'',1,'');
        $xcurrent = $xcurrent+$w['0'];
        $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w['1'],5,"Jumlah Belanja dan Transfer",1,'R');
        $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
        $xcurrent = $xcurrent+$w['1'];
         $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w['2'],5,number_format($totalBelanjaSesudah,0,',','.'),1,'R');
        $y = MAX($y1, $y2, $y3);
        $ysisa = $y;
        $pdf->ln();

        IF($y2 > 275 || $y1 + (5*(strlen("Surplus/Defisit")/35)) > 275 ){ //cek pagebreak
            $pdf->changePage(280, $yst, $w, $marginLeft, $x);
            $y1 = $pdf->GetY(); // Untuk baris berikutnya
            $y2 = $pdf->GetY(); //untuk baris berikutnya
            $y3 = $pdf->GetY(); //untuk baris berikutnya
            $yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
            $x = 15;
            $ysisa = $y1;
            $y = max($y1, $y2, $y3);
        }

        $pdf->SetFont('Times','B',10);
        $pdf->SetXY($x, $y);
        $xcurrent= $x;
        $pdf->MultiCell($w['0'],5,'',1,'L');
        $xcurrent = $xcurrent+$w['0'];
        $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w['1'],5,"Surplus/Defisit",1,'R');
        $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
        $xcurrent = $xcurrent+$w['1'];
         $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w['2'],5,number_format($totalPendapatanSesudah-$totalBelanjaSesudah,0,',','.'),1,'R');
        $y = MAX($y1, $y2, $y3);
        $ysisa = $y;
        $pdf->ln();
    }
    if($kdAkun1 != $model['kd_rek_1']) {   

        IF($y2 > 275 || $y1 + (5*(strlen($model['kd_rek_1'])/35)) > 275 ){ //cek pagebreak
            $pdf->changePage(280, $yst, $w, $marginLeft, $x);
            $y1 = $pdf->GetY(); // Untuk baris berikutnya
            $y2 = $pdf->GetY(); //untuk baris berikutnya
            $y3 = $pdf->GetY(); //untuk baris berikutnya
            $yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
            $x = 15;
            $ysisa = $y1;
            $y = max($y1, $y2, $y3);
        }

        $pdf->SetFont('Times','B',10);
        //new data		
        $pdf->SetXY($x+3, $y);
        $xcurrent= $x;
        $pdf->MultiCell($w['0'],5,$model['kd_rek_1'],'','L');
        $xcurrent = $xcurrent+$w['0'];
        $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w['1'],5,getAkun1($model),'','L');
        $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
        $xcurrent = $xcurrent+$w['1'];
         $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w['2'],5,'','','R');
        $y = MAX($y1, $y2, $y3);
        $ysisa = $y;
        $pdf->ln();
    }
    if($kdAkun2 != $model['kd_rek_1'].$model['kd_rek_2'] && $kdAkun1 == $model['kd_rek_1'] && $kdAkun2 != 0){

        IF($y2 > 275 || $y1 + (5*(strlen("Total " .getAkun2($lastModel))/35)) > 275 ){ //cek pagebreak
            $pdf->changePage(280, $yst, $w, $marginLeft, $x);
            $y1 = $pdf->GetY(); // Untuk baris berikutnya
            $y2 = $pdf->GetY(); //untuk baris berikutnya
            $y3 = $pdf->GetY(); //untuk baris berikutnya
            $yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
            $x = 15;
            $ysisa = $y1;
            $y = max($y1, $y2, $y3);
        }

        $pdf->SetFont('Times','B',10);
        $pdf->SetXY($x+3, $y);
        $xcurrent= $x;
        $pdf->MultiCell($w['0'],5,'','','L');
        $xcurrent = $xcurrent+$w['0'];
        $pdf->SetXY($xcurrent+2, $y);
        $pdf->MultiCell($w['1']-2,5,"Total " .getAkun2($lastModel),'','R');
        $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
        $xcurrent = $xcurrent+$w['1'];
         $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w['2'],5,number_format($totalSesudah2,0,',','.'),'','R');
        $y = MAX($y1, $y2, $y3);
        $ysisa = $y;
        $pdf->ln();
        // echo renderTotalAkun2($lastModel, number_format($totalSebelum2), number_format($totalSesudah2));
        $totalSebelum2 = 0; $totalSesudah2 = 0;
    }
    if($kdAkun2 != $model['kd_rek_1'].$model['kd_rek_2']){
        IF($y2 > 275 || $y1 + (5*(strlen(getAkun2($model))/35)) > 275 ){ //cek pagebreak
            $pdf->changePage(280, $yst, $w, $marginLeft, $x);
            $y1 = $pdf->GetY(); // Untuk baris berikutnya
            $y2 = $pdf->GetY(); //untuk baris berikutnya
            $y3 = $pdf->GetY(); //untuk baris berikutnya
            $yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
            $x = 15;
            $ysisa = $y1;
            $y = max($y1, $y2, $y3);
        }

        $pdf->SetFont('Times','B',10);
        //new data		
        $pdf->SetXY($x+3, $y);
        $xcurrent= $x;
        $pdf->MultiCell($w['0'],5,$model['kd_rek_1'].'.'.substr('0'.$model['kd_rek_2'], -2),'','L');
        $xcurrent = $xcurrent+$w['0'];
        $pdf->SetXY($xcurrent+2, $y);
        $pdf->MultiCell($w['1']-2,5,getAkun2($model),'','L');
        $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
        $xcurrent = $xcurrent+$w['1'];
         $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w['2'],5,'','','R');
        $y = MAX($y1, $y2, $y3);
        $ysisa = $y;
        $pdf->ln();
    }

	IF($y2 > 275 || $y1 + (5*(strlen($model['nm_akrual_3'])/35)) > 275 ){ //cek pagebreak
		$pdf->changePage(280, $yst, $w, $marginLeft, $x);
		$y1 = $pdf->GetY(); // Untuk baris berikutnya
		$y2 = $pdf->GetY(); //untuk baris berikutnya
		$y3 = $pdf->GetY(); //untuk baris berikutnya
		$yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
		$x = 15;
		$ysisa = $y1;
        $y = max($y1, $y2, $y3);
	}

    $pdf->SetFont('Times','',10);
	//new data		
	$pdf->SetXY($x+3, $y);
	$xcurrent= $x;
	$pdf->MultiCell($w['0'],5,$model['kd_rek_1'].'.'.substr('0'.$model['kd_rek_2'], -2).'.'.substr('0'.$model['kd_rek_3'], -2),'','L');
	$xcurrent = $xcurrent+$w['0'];
	$pdf->SetXY($xcurrent+4, $y);
	$pdf->MultiCell($w['1']-4,5,$model['nm_akrual_3'],'','L');
    $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
	$xcurrent = $xcurrent+$w['1'];
 	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['2'],5,number_format($model['realisasi_sesudah'],0,',','.'),'','R');
	
	$ysisa = $y;

	$i++; //Untuk urutan nomor
    $pdf->ln();
    
    $totalSebelum1 += $model['realisasi_sebelum'];
    $totalSesudah1 += $model['realisasi_sesudah'];
    $totalSebelum2 += $model['realisasi_sebelum'];
    $totalSesudah2 += $model['realisasi_sesudah'];
    if($model['kd_rek_1'] == 4){
        $checkAkun4 = true;
        $totalAkun4Sebelum += $model['realisasi_sebelum'];
        $totalAkun4Sesudah += $model['realisasi_sesudah'];
    }
    if($model['kd_rek_1'] == 5){
        $checkAkun5 = true;
        $totalAkun5Sebelum += $model['realisasi_sebelum'];
        $totalAkun5Sesudah += $model['realisasi_sesudah'];
    }
    if($model['kd_rek_1'] == 6 && $model['kd_rek_2'] == 1){
        $checkAkun6 = true;
        $totalAkun61Sebelum += $model['realisasi_sebelum'];
        $totalAkun61Sesudah += $model['realisasi_sesudah'];
    }
    if($model['kd_rek_1'] == 6 && $model['kd_rek_2'] == 2){
        $checkAkun6 = true;
        $totalAkun62Sebelum += $model['realisasi_sebelum'];
        $totalAkun62Sesudah += $model['realisasi_sesudah'];
    }
    if($model['kd_rek_1'] == 7 && $model['kd_rek_2'] == 1){
        $checkAkun7 = true;
        $totalAkun71Sebelum += $model['realisasi_sebelum'];
        $totalAkun71Sesudah += $model['realisasi_sesudah'];
    }
    if($model['kd_rek_1'] == 7 && $model['kd_rek_2'] == 2){
        $checkAkun7 = true;
        $totalAkun72Sebelum += $model['realisasi_sebelum'];
        $totalAkun72Sesudah += $model['realisasi_sesudah'];
    }
    $kdAkun1 = $model['kd_rek_1'];
    $kdAkun2 = $model['kd_rek_1'].$model['kd_rek_2'];
    $lastModel = $model;

}
// if account 7 not exist
if($checkAkun7 === false){
    IF($y2 > 275 || $y1 + (5*(strlen("Total " .getAkun2($lastModel))/35)) > 275 ){ //cek pagebreak
		$pdf->changePage(280, $yst, $w, $marginLeft, $x);
		$y1 = $pdf->GetY(); // Untuk baris berikutnya
		$y2 = $pdf->GetY(); //untuk baris berikutnya
		$y3 = $pdf->GetY(); //untuk baris berikutnya
		$yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
		$x = 15;
		$ysisa = $y1;
        $y = max($y1, $y2, $y3);
    }
    
    $y = MAX($y1, $y2, $y3);
    $pdf->SetFont('Times','B',10);
    $pdf->SetXY($x+3, $y);
    $xcurrent= $x;
    $pdf->MultiCell($w['0'],5,'','','L');
    $xcurrent = $xcurrent+$w['0'];
    $pdf->SetXY($xcurrent+2, $y);
    $pdf->MultiCell($w['1']-2,5,"Total " .getAkun2($lastModel),'','R');
    $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent+$w['1'];
     $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w['2'],5,number_format($totalSesudah2,0,',','.'),'','R');
    $y = MAX($y1, $y2, $y3);
    $ysisa = $y;
    $pdf->ln();

    IF($y2 > 275 || $y1 + (5*(strlen("Total " .getAkun1($lastModel))/35)) > 275 ){ //cek pagebreak
		$pdf->changePage(280, $yst, $w, $marginLeft, $x);
		$y1 = $pdf->GetY(); // Untuk baris berikutnya
		$y2 = $pdf->GetY(); //untuk baris berikutnya
		$y3 = $pdf->GetY(); //untuk baris berikutnya
		$yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
		$x = 15;
		$ysisa = $y1;
        $y = max($y1, $y2, $y3);
    }

    $totalSebelum2 = 0; $totalSesudah2 = 0;
    $pdf->SetFont('Times','B',10);
    $pdf->SetXY($x+3, $y);
    $xcurrent= $x;
    $pdf->MultiCell($w['0'],5,'','','L');
    $xcurrent = $xcurrent+$w['0'];
    $pdf->SetXY($xcurrent+2, $y);
    $pdf->MultiCell($w['1']-2,5,"Total " .getAkun1($lastModel),'','R');
    $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent+$w['1'];
     $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w['2'],5,number_format($totalSesudah1,0,',','.'),'','R');
    $y = MAX($y1, $y2, $y3);
    $ysisa = $y;
    $pdf->ln();

    $totalSebelum1 = 0; $totalSesudah1 = 0;
    // -------------------------------------------
    $y = MAX($y1, $y2, $y3);
    $totalPendapatanSebelum = $totalAkun4Sebelum;
    $totalPendapatanSesudah = $totalAkun4Sesudah;
    $totalBelanjaSebelum = $totalAkun5Sebelum+$totalAkun61Sebelum+$totalAkun62Sebelum;
    $totalBelanjaSesudah = $totalAkun5Sesudah+$totalAkun61Sesudah+$totalAkun62Sesudah;

    IF($y2 > 275 || $y1 + (5*(strlen("Jumlah Belanja dan Transfer")/35)) > 275 ){ //cek pagebreak
		$pdf->changePage(280, $yst, $w, $marginLeft, $x);
		$y1 = $pdf->GetY(); // Untuk baris berikutnya
		$y2 = $pdf->GetY(); //untuk baris berikutnya
		$y3 = $pdf->GetY(); //untuk baris berikutnya
		$yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
		$x = 15;
		$ysisa = $y1;
        $y = max($y1, $y2, $y3);
    }

    $pdf->SetFont('Times','B',10);
    $pdf->SetXY($x, $y);
    $xcurrent= $x;
    $pdf->MultiCell($w['0'],5,'',1,'');
    $xcurrent = $xcurrent+$w['0'];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w['1'],5,"Jumlah Belanja dan Transfer",1,'R');
    $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent+$w['1'];
     $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w['2'],5,number_format($totalBelanjaSesudah,0,',','.'),1,'R');
    $y = MAX($y1, $y2, $y3);
    $ysisa = $y;
    $pdf->ln();

    IF($y2 > 275 || $y1 + (5*(strlen("Surplus/Defisit")/35)) > 275 ){ //cek pagebreak
		$pdf->changePage(280, $yst, $w, $marginLeft, $x);
		$y1 = $pdf->GetY(); // Untuk baris berikutnya
		$y2 = $pdf->GetY(); //untuk baris berikutnya
		$y3 = $pdf->GetY(); //untuk baris berikutnya
		$yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
		$x = 15;
		$ysisa = $y1;
        $y = max($y1, $y2, $y3);
    }

    $pdf->SetFont('Times','B',10);
    $pdf->SetXY($x, $y);
    $xcurrent= $x;
    $pdf->MultiCell($w['0'],5,'',1,'L');
    $xcurrent = $xcurrent+$w['0'];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w['1'],5,"Surplus/Defisit",1,'R');
    $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent+$w['1'];
     $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w['2'],5,number_format($totalPendapatanSesudah-$totalBelanjaSesudah,0,',','.'),1,'R');
    $y = MAX($y1, $y2, $y3);
    $ysisa = $y;
    $pdf->ln();
    $totalPembiayaanSebelum = $totalPembiayaanSesudah = 0;
}else{
    // if account 7 exist will follow this result
    
    IF($y2 > 275 || $y1 + (5*(strlen("Total " .getAkun2($lastModel))/35)) > 275 ){ //cek pagebreak
		$pdf->changePage(280, $yst, $w, $marginLeft, $x);
		$y1 = $pdf->GetY(); // Untuk baris berikutnya
		$y2 = $pdf->GetY(); //untuk baris berikutnya
		$y3 = $pdf->GetY(); //untuk baris berikutnya
		$yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
		$x = 15;
		$ysisa = $y1;
        $y = max($y1, $y2, $y3);
    }

    $y = MAX($y1, $y2, $y3);
    $pdf->SetFont('Times','B',10);
    $pdf->SetXY($x+3, $y);
    $xcurrent= $x;
    $pdf->MultiCell($w['0'],5,'','','L');
    $xcurrent = $xcurrent+$w['0'];
    $pdf->SetXY($xcurrent+2, $y);
    $pdf->MultiCell($w['1']-2,5,"Total " .getAkun2($lastModel),'','R');
    $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent+$w['1'];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w['2'],5,number_format($totalSesudah2,0,',','.'),'','R');
    $y = MAX($y1, $y2, $y3);
    $ysisa = $y;
    $pdf->ln();
    $totalSebelum2 = 0; $totalSesudah2 = 0;

    $totalPembiayaanSebelum = $totalAkun71Sebelum - $totalAkun72Sebelum;
    $totalPembiayaanSesudah = $totalAkun71Sesudah - $totalAkun72Sesudah;

    IF($y2 > 275 || $y1 + (5*(strlen("Total " .getAkun1($lastModel))/35)) > 275 ){ //cek pagebreak
		$pdf->changePage(280, $yst, $w, $marginLeft, $x);
		$y1 = $pdf->GetY(); // Untuk baris berikutnya
		$y2 = $pdf->GetY(); //untuk baris berikutnya
		$y3 = $pdf->GetY(); //untuk baris berikutnya
		$yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
		$x = 15;
		$ysisa = $y1;
        $y = max($y1, $y2, $y3);
    }


    $pdf->SetFont('Times','B',10);
    $pdf->SetXY($x+3, $y);
    $xcurrent= $x;
    $pdf->MultiCell($w['0'],5,'','','L');
    $xcurrent = $xcurrent+$w['0'];
    $pdf->SetXY($xcurrent+2, $y);
    $pdf->MultiCell($w['1']-2,5,"Total " .getAkun1($lastModel),'','R');
    $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent+$w['1'];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w['2'],5,number_format($totalPembiayaanSesudah,0,',','.'),'','R');
    $y = MAX($y1, $y2, $y3);
    $ysisa = $y;
    $pdf->ln();
}

IF($y2 > 275 || $y1 + (5*(strlen("Sisa Lebih/Kurang Pembiayaan Anggaran")/35)) > 275 ){ //cek pagebreak
    $pdf->changePage(280, $yst, $w, $marginLeft, $x);
    $y1 = $pdf->GetY(); // Untuk baris berikutnya
    $y2 = $pdf->GetY(); //untuk baris berikutnya
    $y3 = $pdf->GetY(); //untuk baris berikutnya
    $yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
    $x = 15;
    $ysisa = $y1;
    $y = max($y1, $y2, $y3);
}


$pdf->SetFont('Times','B',10);
$pdf->SetXY($x, $y);
$xcurrent= $x;
$pdf->MultiCell($w['0'],5,'',1,'L');
$xcurrent = $xcurrent+$w['0'];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w['1'],5,"Sisa Lebih/Kurang Pembiayaan Anggaran",1,'R');
$y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$xcurrent = $xcurrent+$w['1'];
$pdf->SetXY($xcurrent, $y);
// $pdf->MultiCell($w['2'],5,number_format(($totalAkun4Sesudah-($totalAkun5Sesudah+$totalAkun61Sesudah+$totalAkun62Sesudah))+$totalPembiayaanSesudah,0,',','.'),1,'R');
$pdf->MultiCell($w['2'],5,number_format(($totalPendapatanSesudah-$totalBelanjaSesudah)+$totalPembiayaanSesudah,0,',','.'),1,'R');
$y = MAX($y1, $y2, $y3);
$ysisa = $y;
$pdf->ln();

//membuat kotak di halaman terakhir
$y = MAX($y1, $y2, $y3);
$ylst = $y - $yst;  //$y batas marjin bawah dikurangi dengan y pertama
$pdf->Rect($x, $yst, $w['0'] ,$ylst);
$pdf->Rect($x+$w['0'], $yst, $w['1'] ,$ylst);
$pdf->Rect($x+$w['0']+$w['1'], $yst, $w['2'] ,$ylst);

//Untuk mengakhiri dokumen pdf, dan mengirim dokumen ke output
$pdf->Output();
exit;
?>