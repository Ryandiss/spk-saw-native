<?php require_once('includes/init.php'); ?>
<?php cek_login($role = array(1)); ?>

<?php
$errors = array();
$sukses = false;

$nama   = $_POST['nama'] ?? '';
$dapil  = $_POST['dapil'] ?? '';
$kta    = $_POST['kta'] ?? '';
$alamat = $_POST['alamat'] ?? '';

if (isset($_POST['submit'])) {

    // Validasi wajib
    if (!$nama)   $errors[] = 'nama_empty';
    if (!$dapil)  $errors[] = 'dapil_empty';
    if (!$kta)    $errors[] = 'kta_empty';
    if (!$alamat) $errors[] = 'alamat_empty';

    // Validasi unik No. KTA
    if (empty($errors)) {
        $cek_duplikat = mysqli_query($koneksi, "SELECT * FROM alternatif WHERE kta = '$kta'");
        if (mysqli_num_rows($cek_duplikat) > 0) {
            $errors[] = 'kta_duplicate';
        }
    }

    // Simpan ke database
    if (empty($errors)) {
        $simpan = mysqli_query($koneksi, "INSERT INTO alternatif (id_alternatif, alternatif, dapil, kta, alamat) 
                                          VALUES ('', '$nama', '$dapil', '$kta', '$alamat')");
        if ($simpan) {
            redirect_to('list-alternatif.php?status=sukses-baru');
        } else {
            $errors[] = 'save_failed';
        }
    }
}

$page = "Alternatif";
require_once('template/header.php');
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-users"></i> Data Bakal Calon Legislatif</h1>
	<a href="list-alternatif.php" class="btn btn-secondary btn-icon-split">
		<span class="icon text-white-50"><i class="fas fa-arrow-left"></i></span>
		<span class="text">Kembali</span>
	</a>
</div>

<?php if (!empty($errors)): ?>
	<div class="alert alert-danger">
		<?php foreach ($errors as $error): ?>
			<?php if ($error == 'kta_duplicate'): ?>
				<div>KTA_duplicated.</div>
			<?php elseif ($error == 'nama_empty'): ?>
				<div>Nama calon tidak boleh kosong.</div>
			<?php elseif ($error == 'dapil_empty'): ?>
				<div>Daerah pencalonan tidak boleh kosong.</div>
			<?php elseif ($error == 'kta_empty'): ?>
				<div>No. KTA tidak boleh kosong.</div>
			<?php elseif ($error == 'alamat_empty'): ?>
				<div>Alamat tidak boleh kosong.</div>
			<?php elseif ($error == 'save_failed'): ?>
				<div>Data gagal disimpan. Silakan coba lagi.</div>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>
<?php endif; ?>

<form action="tambah-alternatif.php" method="post">
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-danger"><i class="fas fa-fw fa-plus"></i> Tambah Data Bakal Calon Legislatif</h6>
		</div>
		<div class="card-body">
		    <div class="row">
		        <div class="form-group col-md-12">
		            <label class="font-weight-bold">Nama Bakal Calon</label>
		            <input type="text" name="nama" value="<?= htmlspecialchars($nama) ?>" 
                        class="form-control <?= in_array('nama_empty', $errors) ? 'is-invalid' : '' ?>" required>
		            <?php if (in_array('nama_empty', $errors)): ?>
		                <div class="invalid-feedback">Nama tidak boleh kosong.</div>
		            <?php endif; ?>
		        </div>

		        <div class="form-group col-md-12">
		            <label class="font-weight-bold">Daerah Pencalonan</label>
		            <input type="text" name="dapil" value="<?= htmlspecialchars($dapil) ?>" 
                        class="form-control <?= in_array('dapil_empty', $errors) ? 'is-invalid' : '' ?>" required>
		            <?php if (in_array('dapil_empty', $errors)): ?>
		                <div class="invalid-feedback">Daerah pencalonan tidak boleh kosong.</div>
		            <?php endif; ?>
		        </div>

		        <div class="form-group col-md-12">
		            <label class="font-weight-bold">No. KTA</label>
		            <input type="text" name="kta" value="<?= htmlspecialchars($kta) ?>" 
                        class="form-control <?= (in_array('kta_empty', $errors) || in_array('kta_duplicate', $errors)) ? 'is-invalid' : '' ?>" required>
		            <?php if (in_array('kta_empty', $errors)): ?>
		                <div class="invalid-feedback">No. KTA tidak boleh kosong.</div>
		            <?php elseif (in_array('kta_duplicate', $errors)): ?>
		                <div class="invalid-feedback">No. KTA sudah terdaftar di database.</div>
		            <?php endif; ?>
		        </div>

		        <div class="form-group col-md-12">
		            <label class="font-weight-bold">Alamat</label>
		            <textarea name="alamat" rows="3" class="form-control <?= in_array('alamat_empty', $errors) ? 'is-invalid' : '' ?>" required><?= htmlspecialchars($alamat) ?></textarea>
		            <?php if (in_array('alamat_empty', $errors)): ?>
		                <div class="invalid-feedback">Alamat tidak boleh kosong.</div>
		            <?php endif; ?>
		        </div>
		    </div>
		</div>

		<div class="card-footer text-right">
			<button name="submit" value="submit" type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
			<button type="reset" class="btn btn-info"><i class="fa fa-sync-alt"></i> Reset</button>
		</div>
	</div>
</form>

<?php require_once('template/footer.php'); ?>
