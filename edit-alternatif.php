<?php require_once('includes/init.php'); ?>
<?php cek_login($role = array(1)); ?>

<?php
$errors = array();
$sukses = false;

$id_alternatif = isset($_POST['id']) ? trim($_POST['id']) : (isset($_GET['id']) ? trim($_GET['id']) : '');

// Ambil data sebelumnya jika tersedia
$nama = $dapil = $kta = $alamat = '';
if ($id_alternatif) {
    $data = mysqli_query($koneksi, "SELECT * FROM alternatif WHERE id_alternatif='$id_alternatif'");
    if ($d = mysqli_fetch_assoc($data)) {
        $nama = $d['alternatif'];
        $dapil = $d['dapil'];
        $kta = $d['kta'];
        $alamat = $d['alamat'];
    }
}

if (isset($_POST['submit'])) :
    // Ambil semua data dari form
    $nama   = htmlspecialchars($_POST['nama']);
    $dapil  = htmlspecialchars($_POST['dapil']);
    $kta    = htmlspecialchars($_POST['kta']);
    $alamat = htmlspecialchars($_POST['alamat']);

    // Validasi
    if (!$nama) $errors[] = 'Nama tidak boleh kosong';
    if (!$dapil) $errors[] = 'Daerah pencalonan tidak boleh kosong';
    if (!$kta) $errors[] = 'No. KTA tidak boleh kosong';
    if (!$alamat) $errors[] = 'Alamat tidak boleh kosong';

    // Validasi unik KTA
	if (empty($errors)) {
	    $cek_kta = mysqli_query($koneksi, "SELECT * FROM alternatif WHERE kta = '$kta' AND id_alternatif != '$id_alternatif'");
	    if (mysqli_num_rows($cek_kta) > 0) {
	        $errors[] = 'kta_duplicated';
	    }
	}
    // Proses update
    if (empty($errors)) {
        $update = mysqli_query($koneksi, "UPDATE alternatif SET 
            alternatif = '$nama',
            dapil = '$dapil',
            kta = '$kta',
            alamat = '$alamat'
            WHERE id_alternatif = '$id_alternatif'");

        if ($update) {
            redirect_to('list-alternatif.php?status=sukses-edit');
        } else {
            $errors[] = 'Data gagal diupdate';
        }
    }
endif;
?>

<?php $page = "Alternatif"; require_once('template/header.php'); ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-users"></i> Ubah Data Bakal Calon Legislatif</h1>
	<a href="list-alternatif.php" class="btn btn-secondary btn-icon-split">
		<span class="icon text-white-50"><i class="fas fa-arrow-left"></i></span>
		<span class="text">Kembali</span>
	</a>
</div>

<?php if (!empty($errors)) : ?>
	<div class="alert alert-danger">
		<?php foreach ($errors as $error) : ?>
			<div><?php echo $error; ?></div>
		<?php endforeach; ?>
	</div>
<?php endif; ?>

<form action="edit-alternatif.php?id=<?php echo $id_alternatif; ?>" method="post">
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-fw fa-edit"></i> Formulir Ubah Data</h6>
		</div>
		<div class="card-body">
			<input type="hidden" name="id" value="<?php echo $id_alternatif; ?>">
			<div class="form-group">
				<label class="font-weight-bold">Nama Bakal Calon</label>
				<input type="text" name="nama" required value="<?php echo htmlspecialchars($nama); ?>" class="form-control" />
			</div>
			<div class="form-group">
				<label class="font-weight-bold">Daerah Pencalonan</label>
				<input type="text" name="dapil" required value="<?php echo htmlspecialchars($dapil); ?>" class="form-control" />
			</div>
			<div class="form-group">
				<label class="font-weight-bold">No. KTA</label>
				<input autocomplete="off" type="text" name="kta" 
        		required 
        		value="<?php echo isset($_POST['kta']) ? htmlspecialchars($_POST['kta']) : $d['kta']; ?>" 
       			 class="form-control <?php echo in_array('kta_duplicated', $errors) ? 'is-invalid' : ''; ?>" />
    		<?php if (in_array('kta_duplicated', $errors)) : ?>
        	<div class="invalid-feedback">
            No. KTA ini sudah digunakan oleh calon lain.
        </div>
   			 <?php endif; ?>
			</div>
			<div class="form-group">
				<label class="font-weight-bold">Alamat</label>
				<textarea name="alamat" rows="3" required class="form-control"><?php echo htmlspecialchars($alamat); ?></textarea>
			</div>
		</div>
		<div class="card-footer text-right">
			<button 
			  type="submit" 
			  name="submit" 
			  class="btn btn-success" 
			  onclick="return confirm('Apakah Anda yakin ingin mengupdate data ini?');">
			  <i class="fa fa-save"></i> Update
			</button>

			<button type="reset" class="btn btn-info"><i class="fa fa-sync-alt"></i> Reset</button>
		</div>
	</div>
</form>

<?php require_once('template/footer.php'); ?>
