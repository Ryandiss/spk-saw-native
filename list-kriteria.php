<?php
require_once('includes/init.php');
cek_login($role = array(1));
$page = "Kriteria";
require_once('template/header.php');
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-cube"></i> Data Kriteria</h1>

<div class="dropdown">
  <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown">
    Tambah Data
  </button>
  <div class="dropdown-menu">
    <a class="dropdown-item" href="tambah-kriteria.php">Tambah Kriteria</a>
    <a class="dropdown-item" href="list-sub-kriteria.php">Tambah Subkriteria</a>
  </div>
</div>
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
	<!-- /.card-header -->
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
      <th>Kode Subkriteria</th>
      <th>Nama Subkriteria</th>
      <th>Nilai Subkriteria</th>
      <th>Atribut</th>
      <th>Bobot</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $no = 1;
    $query = mysqli_query($koneksi, "SELECT * FROM kriteria ORDER BY kode_kriteria ASC");
    while ($kriteria = mysqli_fetch_array($query)) :
      $sub_query = mysqli_query($koneksi, "SELECT * FROM sub_kriteria WHERE id_kriteria = '{$kriteria['id_kriteria']}' ORDER BY nilai DESC");
      $first = true;
      while ($sub = mysqli_fetch_array($sub_query)) :
    ?>
        <tr align="center">
          <td><?= $no++ ?></td>
          <td><?= $first ? $kriteria['kode_kriteria'] : '' ?></td>
          <td align="left"><?= $first ? $kriteria['kriteria'] : '' ?></td>
          <td><?= $sub['kode_sub'] ?? '' ?></td>
          <td align="left"><?= $sub['sub_kriteria'] ?></td>
          <td><?= $sub['nilai'] ?></td>
          <td><?= $first ? $kriteria['type'] : '' ?></td>
          <td><?= $first ? $kriteria['bobot'] : '' ?></td>
          <td>
            <?php if ($first) : ?>
              <div class="dropdown">
                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                  Edit
                </button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="edit-kriteria.php?id=<?= $kriteria['id_kriteria'] ?>">Edit Data Kriteria</a>
                  <a class="dropdown-item" href="list-sub-kriteria.php?id=<?= $sub['id_sub_kriteria'] ?>">Edit Data Subkriteria</a>
                </div>
              </div>
            <?php endif; ?>
          </td>
        </tr>
    <?php
        $first = false;
      endwhile;
    endwhile;
    ?>
  </tbody>
</table>
		</div>
	</div>
</div>

<?php
require_once('template/footer.php');
?>