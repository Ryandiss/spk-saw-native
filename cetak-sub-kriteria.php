<?php
require_once('includes/init.php');
date_default_timezone_set('Asia/Jakarta');
$user_role = get_role();

if ($user_role == 'admin' || $user_role == 'user') {

function tanggal_indo($tanggal, $tampil_hari = true) {
    $hari = [
        'Sunday' => 'Minggu',
        'Monday' => 'Senin',
        'Tuesday' => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday' => 'Kamis',
        'Friday' => 'Jumat',
        'Saturday' => 'Sabtu'
    ];
    
    $bulan = [
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
             'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];

    $tanggal_obj = date_create($tanggal);
    $hari_text = $hari[date_format($tanggal_obj, 'l')];
    $tgl = date_format($tanggal_obj, 'd');
    $bln = $bulan[(int)date_format($tanggal_obj, 'm')];
    $thn = date_format($tanggal_obj, 'Y');

    return $tampil_hari ? "$hari_text, $tgl $bln $thn" : "$tgl $bln $thn";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Subkriteria</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            padding-bottom: 120px; /* beri ruang agar konten tidak tabrakan dengan footer */
        }

        h3, h4 {
            text-align: center;
            margin: 1px 0;
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        td, th {
            border: 1px solid #000;
            padding: 6px;
        }

        .ttd {
            width: 100%;
            margin-top: 50px;
        }

        .ttd td {
            border: none;
        }

        .ttd .kanan {
            text-align: center;
            width: 40%;
        }

        .kop-surat {
            width: 100%;
            font-family: Arial, sans-serif;
            font-size: 20px;
            border-bottom: 3px double black;
            padding-bottom: 10px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .kop-logo {
            width: 130px;
            margin-right: 15px;
            margin-left: 10px;
        }

        .kop-text {
            text-align: center;
            flex: 1;
        }

        .kop-text h3 {
            margin: 2px 0;
            font-weight: bold;
            font-size: 20px;
        }

        .footer-cetak {
            font-family: Arial, sans-serif;
            font-size: 13px;
            bottom: 30;
            left: 0;
            width: 100%;
            position: static;
            text-align: center;
            border-top: 1px solid black;
            padding-top: 8px;
            margin-top: 20px;
        }
        

        .waktu-cetak {
            font-size: 13px;
            text-align: left;
            margin-bottom: 10px;
        }
    </style>
</head>

<body onload="window.print()">

<!-- KOP SURAT -->
<div class="kop-surat">
    <img src="assets/images/logokop.png" alt="Logo" class="kop-logo">
    <div class="kop-text">
        <h3>DEWAN PIMPINAN CABANG</h3>
        <h3>PARTAI DEMOKRASI INDONESIA PERJUANGAN</h3>
        <h3>(DPC – PDI PERJUANGAN)</h3>
        <h3>KOTA DEPOK</h3>
    </div>
</div>
<!-- Judul -->
<h4>Laporan Data Sub Kriteria</h4>

<!-- Konten Data -->
<?php
$query = mysqli_query($koneksi, "SELECT * FROM kriteria WHERE ada_pilihan='1' ORDER BY kode_kriteria ASC");
if (mysqli_num_rows($query) <= 0) {
    echo "<p>Tidak ada data.</p>";
} else {
    while ($data = mysqli_fetch_array($query)) {
        echo "<b>{$data['kriteria']} ({$data['kode_kriteria']})</b>";

        $id_kriteria = $data['id_kriteria'];
        $subq = mysqli_query($koneksi, "SELECT * FROM sub_kriteria WHERE id_kriteria = '$id_kriteria' ORDER BY nilai DESC");

        echo "<table>
                <tr>
                    <th width='5%'>No</th>
                    <th>Nama Sub Kriteria</th>
                    <th width='10%'>Nilai</th>
                </tr>";
        $no = 1;
        while ($d = mysqli_fetch_array($subq)) {
            echo "<tr>
                    <td align='center'>$no</td>
                    <td>{$d['sub_kriteria']}</td>
                    <td align='center'>{$d['nilai']}</td>
                  </tr>";
            $no++;
        }
        echo "</table>";
    }
} 
?>
<!-- Tanda Tangan -->
<table class="ttd">
    <tr>
        <td></td>
        <td class="kanan">
            Depok, <?= tanggal_indo(date('Y-m-d')) ?><br><br><br><br>
            <b><u>Hendrik Tangke Allo, S.Sos.</u></b><br>
            Ketua DPC PDI Perjuangan Kota Depok
        </td>
    </tr>
</table>
<div class="waktu-cetak">
    Dicetak pada <?= date('H:i:s') ?>
</div>

<!-- Footer (Hanya di Halaman Pertama) -->
<div class="footer-cetak">
    Sekretariat: Komplek Ruko Grand Depok City, Sektor Anggrek 1, Blok C1 No. 25, Kota Depok, Jawa Barat <br>
    Email: dpcpdiperjuangankotadepok@gmail.com &nbsp; | &nbsp; @pdiperjuangan.depok
</div>

</body>
</html>

<?php
} else {
  header('Location: login.php');
}
?>
