<?php
require_once('includes/init.php');
cek_login($role = array(1));
$page = "Kriteria";
require_once('template/header.php');
?>
	<style>
	.search-wrapper {
 	 text-align: right;
 	 margin-bottom: 1rem;
	}
	.search-label {
	  margin-right: 10px;
	  font-weight: normal;
	  line-height: 1.2;
	}
	.search-input {
	  width: 180px;
	  display: inline-block;
	  padding: 2px 8px;
	  font-size: 11px;
	  line-height: 1.1;
	  vertical-align: middle;
	  border-radius: 3px;
	}
	</style>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-cube"></i> Data Kriteria & Subkriteria</h1>
	<a href="tambah-kriteria.php" class="btn btn-success"> <i class="fa fa-plus"></i> Tambah Data </a>
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
		case 'sukses-tambah':
		$msg = 'Data Kriteria dan Subkriteria berhasil ditambahkan';
		break;
endswitch;

	if ($msg) :
	echo '<div class="alert alert-info">' . $msg . '</div>';
	endif;
	?>
	<div class="card shadow mb-4">
	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold"><i class="fa fa-table"></i> Daftar Data Kriteria & Subkriteria</h6>
	</div>
	<div class="card-body">
		<div class="table-responsive">
		<div class="search-wrapper text-right">
  		<label for="searchInput" class="search-label">Search:</label>
  		<input type="text" id="searchInput" class="form-control search-input" />
	</div>

			<table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0" style="border: 1px solid #dee2e6;">
				<thead class="bg-danger text-white">
					<tr align="center">
						<th>No</th>
						<th>Kode Kriteria</th>
						<th>Nama Kriteria</th>
						<th>Nama Subkriteria</th>
						<th>Nilai Subkriteria</th>
						<th>Atribut</th>
						<th>Bobot</th>
						<th width="10%">Aksi</th>
					</tr>
				</thead>
				<tbody>
				<?php
				$no = 1;
				$last_id = null;
				function getJumlahSubkriteria($koneksi, $id_kriteria) {
					$query = mysqli_query($koneksi, "SELECT COUNT(*) as jumlah FROM sub_kriteria WHERE id_kriteria = $id_kriteria");
					$data = mysqli_fetch_assoc($query);
					return max(1, $data['jumlah']);
				}
				$query = mysqli_query($koneksi, "SELECT k.*, s.sub_kriteria, s.nilai 
    FROM kriteria k 
    LEFT JOIN sub_kriteria s ON k.id_kriteria = s.id_kriteria 
    ORDER BY CAST(SUBSTRING(k.kode_kriteria, 2) AS UNSIGNED) ASC, s.nilai DESC");

				while ($data = mysqli_fetch_array($query)) :
					$is_new_kriteria = $last_id !== $data['id_kriteria'];
					if ($is_new_kriteria) {
						$rowspan = getJumlahSubkriteria($koneksi, $data['id_kriteria']);
					}
				?>
				<tr align="center" data-group="kriteria-<?= $data['id_kriteria']; ?>">
					<?php if ($is_new_kriteria): ?>
						<td rowspan="<?= $rowspan; ?>"><?php echo $no; ?></td>
						<td rowspan="<?= $rowspan; ?>"><?php echo $data['kode_kriteria']; ?></td>
						<td align="left" rowspan="<?= $rowspan; ?>"><?php echo $data['kriteria']; ?></td>
					<?php endif; ?>

					<td align="left"><?php echo $data['sub_kriteria'] ?? '-'; ?></td>
					<td><?php echo $data['nilai'] ?? '-'; ?></td>

					<?php if ($is_new_kriteria): ?>
						<td rowspan="<?= $rowspan; ?>"><?php echo $data['type']; ?></td>
						<td rowspan="<?= $rowspan; ?>"><?php echo $data['bobot']; ?></td>
						<td rowspan="<?= $rowspan; ?>">
							<div class="btn-group" role="group">
								<a data-toggle="tooltip" data-placement="bottom" title="Ubah Data" href="edit-kriteria.php?id=<?php echo $data['id_kriteria']; ?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
								<a data-toggle="tooltip" data-placement="bottom" title="Hapus Data Kriteria" href="hapus-kriteria.php?id=<?php echo $data['id_kriteria']; ?>" onclick="return confirm('Apakah anda yakin untuk meghapus data ini')" class="btn btn-primary btn-sm"><i class="fa fa-trash"></i></a>
							</div>
						</td>
					<?php endif; ?>
					</tr>
					<?php
						if ($is_new_kriteria) {
							$no++;
							$last_id = $data['id_kriteria'];
						}
					endwhile;
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
document.getElementById('searchInput').addEventListener('keyup', function () {
	const keyword = this.value.toLowerCase();
	const rows = document.querySelectorAll('#dataTable tbody tr');

	// Reset tampilan dan hilangkan highlight
	rows.forEach(row => {
		row.style.display = 'none';
		row.querySelectorAll('td').forEach(td => {
			td.innerHTML = td.textContent; // remove highlight
		});
	});
	// Group rows by kriteria id
	const grouped = {};
	rows.forEach(row => {
		const group = row.dataset.group;
		if (!group) return;
		if (!grouped[group]) grouped[group] = [];
		grouped[group].push(row);
	});

	Object.keys(grouped).forEach(group => {
		const groupRows = grouped[group];
		let matchFound = false;

		groupRows.forEach(row => {
			const rowText = row.textContent.toLowerCase();
			if (rowText.includes(keyword)) {
				matchFound = true;
				row.querySelectorAll('td').forEach(td => {
					const text = td.textContent;
					const regex = new RegExp(`(${keyword})`, 'gi');
					td.innerHTML = text.replace(regex, '<span style="background-color: yellow;">$1</span>');
				});
			}
		});

		if (matchFound) {
			groupRows.forEach(row => {
				row.style.display = '';
			});
		}
	});
});
</script>

<?php
require_once('template/footer.php');
?>
