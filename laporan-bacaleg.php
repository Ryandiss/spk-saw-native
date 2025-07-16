<?php
require_once('includes/init.php');

$user_role = get_role();
if ($user_role !== 'admin' && $user_role !== 'user') {
    header('Location: login.php');
    exit;
}
?>

<?php
$page = "Laporan Bacaleg";
require_once('template/header.php');
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-print"></i> Laporan Data Bacaleg</h1>
    
    <a href="cetak-laporan-bacaleg.php" class="btn btn-success" target="_blank">
        <i class="fa fa-file-pdf"></i> Cetak Data
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold"><i class="fa fa-table"></i> Data Bacaleg</h6>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead class="bg-danger text-white">
                    <tr align="center">
                        <th width="5%">No</th>
                        <th>Nama Bakal Calon</th>
                        <th>Daerah Pencalonan</th>
                        <th>No. KTA</th>
                        <th>Alamat</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 0;
                    $query = mysqli_query($koneksi, "SELECT * FROM alternatif");
                    while ($data = mysqli_fetch_array($query)) :
                        $no++;
                    ?>
                        <tr align="center">
                            <td><?php echo $no; ?></td>
                            <td align="left"><?php echo $data['alternatif']; ?></td>
                            <td><?php echo $data['dapil']; ?></td>
                            <td><?php echo $data['kta']; ?></td>
                            <td align="left"><?php echo $data['alamat']; ?></td>
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
