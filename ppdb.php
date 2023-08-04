<?php

error_reporting(0);
echo '<title>PPDB SMP DKI</title>';

// ========================================== FUNCTION

$context = stream_context_create([
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
    ],
]);

function displayStatus($nama, $url){
    global $context;
    $jsonData = file_get_contents($url, false, $context);
    $data = json_decode($jsonData, true);

    $sekolah = $data['sekolah'];
    echo 'Sekolah : '.$sekolah['nama'].'<br>';
    echo 'Kota : '.$sekolah['kota'].'<br>';
    echo 'Provinsi : '.$sekolah['propinsi'].'<br>';
    echo 'Daya Tampung : '.$data['jml_pagu'].'<br><br>';

    $dataArray = $data['data'];
    foreach ($dataArray as $row) {
        if($row[5]==$nama){
            echo 'No : ' . $row[0].'<br>';
            echo 'Nama : ' . $row[5].'<br>';
            echo 'Kelurahan ' . $row[6].'<br>';
            echo 'RW/RW : '. $row[7] . '/' . $row[8].'<br>';
            echo 'Zona : ' . $row[9].'<br>';
            echo 'Umur :' . $row[10].'<br>';
            echo '<br>';
         }
    }
}

function displaySchool($url){
    global $context;
    $jsonData = file_get_contents($url, false, $context);
    $data = json_decode($jsonData, true);
    echo '<hr>';

    $sekolah = $data['sekolah'];
    echo '<b>SEKOLAH - '.$sekolah['nama'].'</b><br><br>';
    $countSisa = 0;

    echo '<table>';
    // echo '<tr><th>NO</th><th>NAMA</th><th>KEL</th><th>RT/RW</th><th>ZONA</th><th>USIA</th></tr>';
    $dataArray = $data['data'];
    foreach ($dataArray as $row) {

    // KETENTUAN SAYA SET KALAU USIA < 13th 12hr karna adik saya 13th 12hr
    // Value 0 = Angka Tahun
    // Value 1 = th
    // Value 2 = Angka Bulan / Angka Hari
    // Value 3 = bl / hr
    // Value 4 = Angka Hari / kosong
    // Value 5 = hr / kosong

         $values = explode(" ", $row[10]);
         if($values[0] < 13){
            $result = True;
         }else{
            if($values[0] == 13){
                if(($values[3]=="bl") AND ($values[2] > 0)){
                   $result = False;
                }else{
                    if($values[2] > 12){
                        $result = False;
                    }else{
                        $result = True;
                    }
                }
            }else{
                $result = False;
            }
         }

           if (($result) AND ($row[9] == 3) ){
            echo '<tr>';
            echo '<td>' . $row[0] . '</td>';
            echo '<td>' . $row[5] . '</td>';
            echo '<td>' . $row[6] . '</td>';
            echo '<td>' . $row[7] . '/' . $row[8] .'</td>';
            echo '<td>' . $row[9] . '</td>';
            echo '<td>' . $row[10] . '</td>';
            echo '</tr>';
            $countSisa += 1;
         }
    }
    echo '</table>';
    echo '<br>';
    echo '<font color=RED>Sisa Bangku : '.$countSisa.' dari Daya Tampung '.$data['jml_pagu'].'</font><br><br>';
}

// ========================================== MAIN PROGRAM

$nama = "NAMA_SISWA";
$smpn46 = 'https://ppdb.jakarta.go.id/seleksi/zonasi/smp/1-22010056-0.json';
displayStatus($nama, $smpn46);


// JSON dari Web ppdb nya cek element network nya
$smpn46 = 'https://ppdb.jakarta.go.id/seleksi/zonasi/smp/1-22010056-0.json';
$smpn182 = 'https://ppdb.jakarta.go.id/seleksi/zonasi/smp/1-22010183-0.json';
$smpn163 = 'https://ppdb.jakarta.go.id/seleksi/zonasi/smp/1-22010164-0.json';
$smpn227 = 'https://ppdb.jakarta.go.id/seleksi/zonasi/smp/1-22010227-0.json';
$smpn35 = 'https://ppdb.jakarta.go.id/seleksi/zonasi/smp/1-22010046-0.json';
$smpn107 = 'https://ppdb.jakarta.go.id/seleksi/zonasi/smp/1-22010111-0.json';
$smpn223 = 'https://ppdb.jakarta.go.id/seleksi/zonasi/smp/1-22010223-0.json';
$smpn239 = 'https://ppdb.jakarta.go.id/seleksi/zonasi/smp/1-22010239-0.json';
$smpn209 = 'https://ppdb.jakarta.go.id/seleksi/zonasi/smp/1-22010210-0.json';
$smpn126 = 'https://ppdb.jakarta.go.id/seleksi/zonasi/smp/1-22010128-0.json';

displaySchool($smpn46);
displaySchool($smpn182);
displaySchool($smpn163);
displaySchool($smpn227);
displaySchool($smpn35);
displaySchool($smpn107);
displaySchool($smpn223);
displaySchool($smpn239);
displaySchool($smpn209);
displaySchool($smpn126);

?>
