<?php
require_once('includes/init.php');

$user_role = get_role();
if ($user_role == 'admin' || $user_role == 'user') {

	$page = "Hasil Akhir";
	require_once('template/header.php');
?>

	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-chart-area"></i> Data Hasil Akhir</h1>

		<a href="cetak-hasil-akhir.php" target="_blank" class="btn btn-success"> <i class="fa fa-file-pdf"></i> Cetak Data </a>
	</div>

	<div class="card shadow mb-4">
		<!-- /.card-header -->
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold"><i class="fa fa-table"></i> Hasil Akhir Perankingan</h6>
		</div>

		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" width="100%" cellspacing="0">
					<thead class="bg-danger text-white">
						<tr align="center">
							<th>Nama Bakal Calon Legislatif</th>
							<th>Nilai</th>
							<th width="15%">Rank</th>
					</thead>
					<tbody>
						<?php
						$no = 0;
						$rank = [];
						$nilai = [];
						$query = mysqli_query($koneksi, "SELECT * FROM hasil JOIN alternatif ON hasil.id_alternatif=alternatif.id_alternatif ORDER BY hasil.nilai DESC");
						while ($data = mysqli_fetch_array($query)) {
							$no++;
							$rank[] = $data['alternatif'];
							$nilai[] = $data['nilai'];
						?>
							<tr align="center">
								<td align="left"><?= $data['alternatif'] ?></td>
								<td><?= custom_number_format($data['nilai']) ?></td>
								<td><?= $no; ?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
				<p><b>Note:</b> Berdasarkan perankingan alternatif terbaik yaitu <b><?= $rank[0] ?></b>, dengan nilai preferensi atau skor <b><?= custom_number_format($nilai[0]) ?></b></p>
			</div>
		</div>
	</div>

<?php
	require_once('template/footer.php');
} else {
	header('Location: login.php');
}
?>