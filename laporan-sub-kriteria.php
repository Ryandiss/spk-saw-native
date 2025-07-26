<?php
require_once('includes/init.php');

$user_role = get_role();
if ($user_role !== 'admin' && $user_role !== 'user') {
    header('Location: login.php');
    exit;
}
$page = "Laporan Sub Kriteria";
require_once('template/header.php');
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-cubes"></i> Laporan Data Subkriteria</h1>
	<a href="cetak-sub-kriteria.php" target="_blank" class="btn btn-success"><i class="fa fa-file-pdf"></i> Cetak Data</a>
</div>

<?php
$query = mysqli_query($koneksi, "SELECT * FROM kriteria WHERE ada_pilihan='1' ORDER BY kode_kriteria ASC");
$cek = mysqli_num_rows($query);
if ($cek <= 0) {
?>
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold"><i class="fa fa-table"></i> Daftar Data Sub Kriteria</h6>
		</div>

		<div class="card-body">
			<div class="alert alert-info">
				Tidak ada kriteria dengan pilihan sub kriteria. Silakan ubah cara penilaian pada menu kriteria.
			</div>
		</div>
	</div>
<?php
} else {
	while ($data = mysqli_fetch_array($query)) {
?>
		<div class="card shadow mb-4">
			<div class="card-header py-3">
				<h6 class="m-0 font-weight-bold"><i class="fa fa-table"></i> <?= $data['kriteria'] . " (" . $data['kode_kriteria'] . ")" ?></h6>
			</div>

			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered" width="100%" cellspacing="0">
						<thead class="bg-danger text-white">
							<tr align="center">
								<th width="5%">No</th>
								<th>Nama Sub Kriteria</th>
								<th>Nilai</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no = 1;
							$id_kriteria = $data['id_kriteria'];
							$q = mysqli_query($koneksi, "SELECT * FROM sub_kriteria WHERE id_kriteria = '$id_kriteria' ORDER BY nilai DESC");
							while ($d = mysqli_fetch_array($q)) {
							?>
								<tr align="center">
									<td><?= $no ?></td>
									<td align="left"><?= $d['sub_kriteria'] ?></td>
									<td><?= $d['nilai'] ?></td>
								</tr>
							<?php
								$no++;
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
<?php
	}
}
require_once('template/footer.php');
?>
