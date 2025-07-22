<?php
require_once('includes/init.php');
date_default_timezone_set('Asia/Jakarta');
$user_role = get_role();
if ($user_role == 'admin' || $user_role == 'user') {

// Fungsi Tanggal Indonesia
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

// Ambil data kriteria dan alternatif
$kriteria = [];
$q1 = mysqli_query($koneksi, "SELECT * FROM kriteria ORDER BY kode_kriteria ASC");
while ($krit = mysqli_fetch_array($q1)) {
    $kriteria[$krit['id_kriteria']] = $krit;
}

$alternatif = [];
$q2 = mysqli_query($koneksi, "SELECT * FROM alternatif ORDER BY id_alternatif ASC");
while ($alt = mysqli_fetch_array($q2)) {
    $alternatif[$alt['id_alternatif']] = $alt;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penilaian</title>
    <style>
      body {
            font-family: Arial, sans-serif;
            font-size: 14px; /* ukuran dasar */
        }

        h3, h4 { text-align: center; margin: 1px 0; font-family: Arial, sans-serif;}
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        td { border: 1px solid #000000  ; padding: 6px;}
        th { border: 1px solid #000000  ; padding: 6px; }
        .ttd { width: 100%; margin-top: 50px; }
        .ttd td { border: none; }
        .ttd .kanan { text-align: center; width: 40%; }
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
              width: 130px;          /* ukuran logo */
              margin-right: 5px;    /* jarak antara logo dan teks */
              margin-left: 15px;     /* geser ke kanan dari sisi kiri kertas */
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
      @media print {
      .footer-cetak {
              font-family: Arial, sans-serif;
              position: fixed;
              bottom: 0;
              left: 0;
              width: 100%;
              font-size: 15px;
              text-align: center;
              border-top: 1px solid black;
              padding-top: 5px;
              margin: 0;
        }
    </style>
</head>

<body onload="window.print()">

<!-- KOP -->
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
<div style="text-align:center; margin-bottom: 20px;">
    <h4>Matriks Penilaian Alternatif Terhadap Kriteria</h4>
</div>

<!-- Tabel Penilaian -->
<table width="100%" cellspacing="0" cellpadding="5" border="1">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Alternatif</th>
            <?php foreach ($kriteria as $k) : ?>
                <th><?= $k['kode_kriteria'] ?></th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($alternatif as $alt) :
        ?>
        <tr>
            <td style="text-align: center;"><?= $no++ ?></td>
            <td><?= $alt['alternatif'] ?></td>
            <?php foreach ($kriteria as $k) : ?>
                <td style="text-align: center;"><?= get_matriks_keputusan($alt['id_alternatif'], $k['id_kriteria']) ?? 'n/a'; ?></td>
            <?php endforeach; ?>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- TTD -->
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
      </div>
        <div style="float:left; text-align:left;">
    Dicetak pada <?= date('H:i:s') ?>
  </div>

<!-- Footer -->
<div class="footer-cetak">
    Sekretariat : Komplek Ruko Grand Depok City, Sektor Anggrek 1, Blok C1 No. 25, Kota Depok, Jawa Barat <br>
    Email : dpcpdiperjuangankotadepok@gmail.com &nbsp; | &nbsp; @pdiperjuangan.depok
</div>

</body>
</html>

<?php
} else {
    header('Location: login.php');
}
?>
