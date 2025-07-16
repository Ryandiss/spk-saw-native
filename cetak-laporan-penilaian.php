<?php
require_once('includes/init.php');

$user_role = get_role();
if ($user_role == 'admin' || $user_role == 'user') {

// Fungsi Tanggal Indonesia
function tanggal_indo($tanggal) {
    $bulan = [
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
             'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    $pecah = explode('-', $tanggal); // Format: Y-m-d
    return $pecah[2] . ' ' . $bulan[(int)$pecah[1]] . ' ' . $pecah[0];
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
        h3, h4 { text-align: center; margin: 1px 0; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        td { border: 1px solid #000000  ; padding: 6px;}
        th { border: 1px solid #000000  ; padding: 6px;}
        .ttd { width: 100%; margin-top: 50px; }
        .ttd td { border: none; }
        .ttd .kanan { text-align: center; width: 40%; }
        .kop { width:100%; text-align:center; border-bottom: 3px double black; padding-bottom: 40px; margin-bottom: 30px; }
        .kop img { width="15%"; text-align:left; float: left; width: 135px; }
        @media print {
            .footer-cetak {
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
        }
    </style>
</head>

<body onload="window.print()">

<!-- KOP -->
<div class="kop">
    <img src="assets/images/logokop.png">
    <h3>DEWAN PIMPINAN CABANG</h3>
    <h3>PARTAI DEMOKRASI INDONESIA PERJUANGAN</h3>
    <h3>(DPC – PDI PERJUANGAN)</h3>
    <h3>KOTA DEPOK</h3>
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
