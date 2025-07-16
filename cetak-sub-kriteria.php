<?php
require_once('includes/init.php');
$user_role = get_role();

if ($user_role == 'admin' || $user_role == 'user') {

function tanggal_indo($tanggal) {
    $bulan = [1 => 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    $pecah = explode('-', $tanggal);
    return $pecah[2] . ' ' . $bulan[(int)$pecah[1]] . ' ' . $pecah[0];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Sub Kriteria</title>
    <style>
        h3, h4 { text-align: center; margin: 1px 0; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        td { border: 1px solid #000000  ; padding: 6px;}
        th { border: 1px solid #000000  ; padding: 6px; }
        .ttd { width: 100%; margin-top: 50px; }
        .ttd { width: 100%; margin-top: 50px; }
        .ttd td { border: none; }
        .ttd .kanan { text-align: center; width: 40%; }
        .kop { width:100%; text-align:center; border-bottom: 3px double black; padding-bottom: 40px; margin-bottom: 30px; }
        .kop img { width="15%"; text-align:left; float: left; width: 135px; }
        @media print {
      	.footer-cetak {
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
<div class="kop">
    <img src="assets/images/logokop.png">
    <h3>DEWAN PIMPINAN CABANG</h3>
    <h3>PARTAI DEMOKRASI INDONESIA PERJUANGAN</h3>
    <h3>(DPC – PDI PERJUANGAN)</h3>
    <h3>KOTA DEPOK</h3>
</div>
<h4>Laporan Data Sub Kriteria</h4>

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

<!-- TANDA TANGAN -->
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

  <div class="footer-cetak">
    Sekretariat : Komplek Ruko Grand Depok City, Sektor Anggrek 1, Blok C1 No. 25, Kota Depok, Jawa Barat <br>
    Email : dpcpdiperjuangankotadepok@gmail.com &nbsp; | &nbsp; @pdiperjuangan.depok
  </div>

</div>

</body>
</html>

<?php
} else {
  header('Location: login.php');
}
?>
