<?php
require_once('includes/init.php');

$user_role = get_role();
if ($user_role !== 'admin' && $user_role !== 'user') {
    header('Location: login.php');
    exit;
}// Sesuaikan hak akses admin
$page = "Laporan Penilaian";
require_once('template/header.php');

// Ambil data kriteria
$kriteria = array();
$q1 = mysqli_query($koneksi, "SELECT * FROM kriteria ORDER BY kode_kriteria ASC");
while ($krit = mysqli_fetch_array($q1)) {
    $kriteria[$krit['id_kriteria']] = $krit;
}

// Ambil data alternatif
$alternatif = array();
$q2 = mysqli_query($koneksi, "SELECT * FROM alternatif ORDER BY id_alternatif ASC");
while ($alt = mysqli_fetch_array($q2)) {
    $alternatif[$alt['id_alternatif']] = $alt;
}
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-table"></i> Laporan Penilaian</h1>
    <a href="cetak-laporan-penilaian.php" target="_blank" class="btn btn-success"><i class="fa fa-file-pdf"></i> Cetak Data</a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold"><i class="fa fa-table"></i> Matriks Keputusan (X)</h6>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead class="bg-danger text-white text-center">
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama Alternatif</th>
                        <?php foreach ($kriteria as $key) : ?>
                            <th><?= $key['kode_kriteria'] ?></th>
                        <?php endforeach ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($alternatif as $alt) :
                    ?>
                        <tr align="center">
                            <td><?= $no++; ?></td>
                            <td align="left"><?= $alt['alternatif'] ?></td>
                            <?php foreach ($kriteria as $k) : ?>
                                <td><?= get_matriks_keputusan($alt['id_alternatif'], $k['id_kriteria']) ?? 'n/a'; ?></td>
                            <?php endforeach ?>
                        </tr>
                    <?php endforeach ?>
                    <!-- Baris Max & Min disembunyikan -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
require_once('template/footer.php');
?>
