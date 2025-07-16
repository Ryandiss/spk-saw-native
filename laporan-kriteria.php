<?php
require_once('includes/init.php');

$user_role = get_role();
if ($user_role !== 'admin' && $user_role !== 'user') {
    header('Location: login.php');
    exit;
}
$page = "Laporan Kriteria";
require_once('template/header.php');
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-cube"></i> Laporan Data Kriteria</h1>
    <a href="cetak-laporan-kriteria.php" target="_blank" class="btn btn-success"><i class="fa fa-file-pdf"></i> Cetak Data</a>
</div>

<?php
$status = isset($_GET['status']) ? $_GET['status'] : '';
$msg = '';
switch ($status):
    case 'sukses-baru':
        $msg = 'Data berhasil disimpan';
        break;
    case 'sukses-hapus':
        $msg = 'Data behasil dihapus';
        break;
    case 'sukses-edit':
        $msg = 'Data behasil diupdate';
        break;
endswitch;

if ($msg) :
    echo '<div class="alert alert-info">' . $msg . '</div>';
endif;
?>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold"><i class="fa fa-table"></i> Daftar Data Kriteria</h6>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead class="bg-danger text-white">
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
                    while ($data = mysqli_fetch_array($query)) :
                    ?>
                        <tr align="center">
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $data['kode_kriteria']; ?></td>
                            <td align="left"><?php echo $data['kriteria']; ?></td>
                            <td><?php echo $data['type']; ?></td>
                            <td><?php echo $data['bobot']; ?></td>
                            <td><?php echo ($data['ada_pilihan']) ? 'Pilihan Sub Kriteria' : 'Input Langsung'; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
require_once('template/footer.php');
?>
