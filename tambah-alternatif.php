<?php require_once('includes/init.php'); ?>
<?php cek_login($role = array(1)); ?>

<?php
$errors = array();
$sukses = false;

$nama   = (isset($_POST['nama'])) ? trim($_POST['nama']) : '';
$dapil  = (isset($_POST['dapil'])) ? trim($_POST['dapil']) : '';
$kta    = (isset($_POST['kta'])) ? trim($_POST['kta']) : '';
$alamat = (isset($_POST['alamat'])) ? trim($_POST['alamat']) : '';

if (isset($_POST['submit'])) :

    // Validasi
    if (!$nama) $errors[] = 'Nama calon tidak boleh kosong';
    if (!$dapil) $errors[] = 'Daerah pencalonan tidak boleh kosong';
    if (!$kta) $errors[] = 'No. KTA tidak boleh kosong';
    if (!$alamat) $errors[] = 'Alamat tidak boleh kosong';
        // Validasi unik KTA
    if (empty($errors)) {
        $cek_duplikat = mysqli_query($koneksi, "SELECT * FROM alternatif WHERE kta = '$kta'");
        if (mysqli_num_rows($cek_duplikat) > 0) {
            $errors[] = 'No. KTA yang dimasukkan sudah terdaftar di database';
        }
    }
    // Jika lolos validasi lakukan penyimpanan
    if (empty($errors)) :
        $simpan = mysqli_query($koneksi, "INSERT INTO alternatif (id_alternatif, alternatif, dapil, kta, alamat) 
                                          VALUES ('', '$nama', '$dapil', '$kta', '$alamat')");
        if ($simpan) {
            redirect_to('list-alternatif.php?status=sukses-baru');
        } else {
            $errors[] = 'Data gagal disimpan';
        }
    endif;

endif;

$page = "Alternatif";
require_once('template/header.php');
?>


<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-users"></i> Data Bakal Calon Legislatif</h1>

	<a href="list-alternatif.php" class="btn btn-secondary btn-icon-split"><span class="icon text-white-50"><i class="fas fa-arrow-left"></i></span>
		<span class="text">Kembali</span>
	</a>
</div>

<?php if (!empty($errors)) : ?>
	<div class="alert alert-info">
		<?php foreach ($errors as $error) : ?>
			<?php echo $error; ?>
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
		            <input autocomplete="off" type="text" name="nama" required value="<?php echo $nama; ?>" class="form-control" />
		        </div>
		        <div class="form-group col-md-12">
		            <label class="font-weight-bold">Daerah Pencalonan</label>
		            <input autocomplete="off" type="text" name="dapil" required value="<?php echo $dapil; ?>" class="form-control" />
		        </div>
		        <div class="form-group col-md-12">
		            <label class="font-weight-bold">No. KTA</label>
		            <input autocomplete="off" type="text" name="kta" required value="<?php echo $kta; ?>" class="
		            form-control" />
		        </div>
		        <div class="form-group col-md-12">
		            <label class="font-weight-bold">Alamat</label>
		            <textarea name="alamat" rows="3" required class="form-control"><?php echo $alamat; ?></textarea>
		        </div>
		    </div>
		</div>

		<div class="card-footer text-right">
			<button name="submit" value="submit" type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
			<button type="reset" class="btn btn-info"><i class="fa fa-sync-alt"></i> Reset</button>
		</div>
	</div>
</form>

<?php
require_once('template/footer.php');
?>