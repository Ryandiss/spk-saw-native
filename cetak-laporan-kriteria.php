<?php
require_once('includes/init.php');
$user_role = get_role();

if ($user_role == 'admin' || $user_role == 'user') {

function tanggal_indo($tanggal) {
    $bulan = [
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
             'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    $pecah = explode('-', $tanggal);
    return $pecah[2] . ' ' . $bulan[(int)$pecah[1]] . ' ' . $pecah[0];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Kriteria</title>
    <style>
        h3, h4 { text-align: center; margin: 1px 0; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        td { border: 1px solid #000000  ; padding: 6px;}
        th { border: 1px solid #000000  ; padding: 6px; }
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
    <h4>Laporan Data Kriteria</h4>
  </div>

  <!-- Tabel Kriteria -->
  <table width="100%" cellspacing="0" cellpadding="5" border="1">
    <thead>
      <tr align="center">
        <th>No</th>
        <th>Kode Kriteria</th>
        <th>Nama Kriteria</th>
        <th>Atribut</th>
        <th>Bobot</th>
        <th>Cara Penilaian</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $no = 1;
      $query = mysqli_query($koneksi, "SELECT * FROM kriteria ORDER BY kode_kriteria ASC");
      while ($data = mysqli_fetch_array($query)) {
      ?>
        <tr>
          <td align="center"><?= $no++; ?></td>
          <td><?= $data['kode_kriteria']; ?></td>
          <td><?= $data['kriteria']; ?></td>
          <td><?= $data['type']; ?></td>
          <td><?= $data['bobot']; ?></td>
          <td><?= ($data['ada_pilihan']) ? 'Pilihan Sub Kriteria' : 'Input Langsung'; ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>

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
  </div>

  <!-- Footer -->
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
