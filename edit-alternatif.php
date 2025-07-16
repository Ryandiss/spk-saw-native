<?php require_once('includes/init.php'); ?>
<?php cek_login($role = array(1)); ?>

<?php
$errors = array();
$sukses = false;

$ada_error = false;
$result = '';

$id_alternatif = isset($_POST['id']) ? trim($_POST['id']) : (isset($_GET['id']) ? trim($_GET['id']) : '');


if (isset($_POST['submit'])) :

	// Ambil semua data dari form
	$nama   = htmlspecialchars($_POST['nama']);
	$dapil  = htmlspecialchars($_POST['dapil']);
	$kta    = htmlspecialchars($_POST['kta']);
	$alamat = htmlspecialchars($_POST['alamat']);

	// Validasi
	if (!$nama) {
		$errors[] = 'Nama tidak boleh kosong';
	}

	// Jika lolos validasi, lakukan update
	if (empty($errors)) :

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
	endif;

endif;
?>


<?php
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

<?php if ($sukses) : ?>
	<div class="alert alert-success">
		Data berhasil disimpan
	</div>
<?php elseif ($ada_error) : ?>
	<div class="alert alert-info">
		<?php echo $ada_error; ?>
	</div>
<?php else : ?>

	<form action="edit-alternatif.php?id=<?php echo $id_alternatif; ?>" method="post">
		<div class="card shadow mb-4">
			<div class="card-header py-3">
				<h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-fw fa-edit"></i> Edit Data Bakal Calon Legislatif</h6>
			</div>
			<?php
			if (!$id_alternatif) {
			?>
				<div class="card-body">
					<div class="alert alert-primary">Data tidak ada</div>
				</div>
				<?php
			} else {
				$data = mysqli_query($koneksi, "SELECT * FROM alternatif WHERE id_alternatif='$id_alternatif'");
				$cek = mysqli_num_rows($data);
				if ($cek <= 0) {
				?>
					<div class="card-body">
						<div class="alert alert-primary">Data tidak ada</div>
					</div>
					<?php
				} else {
					while ($d = mysqli_fetch_array($data)) {
					?>
						<div class="card-body">
							<div class="row">
								<form method="post" action="">
    							<input type="hidden" name="id" value="<?php echo $d['id_alternatif']; ?>">
								<div class="form-group col-md-12">
									<!--<input autocomplete="off" type="hidden" name="id" required value="<?php echo $d['id_alternatif']; ?>" class="form-control" />-->
									<label class="font-weight-bold">Nama Bakal Calon </label>
									<input autocomplete="off" type="text" name="nama" required value="<?php echo $d['alternatif']; ?>" class="form-control" />
									</div>
									<div class="form-group col-md-12">
									<!--<input autocomplete="off" type="hidden" name="id" required value="<?php echo $d['id_alternatif']; ?>" class="form-control" />-->
		           			 		<label class="font-weight-bold">Daerah Pencalonan</label>
		            				<input autocomplete="off" type="text" name="dapil" required value="<?php echo $d['dapil']; ?>" class="form-control" />
		        					</div>
		        					<div class="form-group col-md-12">
		        					<!--<input autocomplete="off" type="hidden" name="id" required value="<?php echo $d['id_alternatif']; ?>" class="form-control" />-->
		            				<label class="font-weight-bold">No. KTA</label>
		            				<input autocomplete="off" type="text" name="kta" required value="<?php echo $d['kta']; ?>" class="form-control" />
		        					</div>
		        					<div class="form-group col-md-12">
		        					<!--<input autocomplete="off" type="hidden" name="id" required value="<?php echo $d['id_alternatif']; ?>" class="form-control" />-->
		            				<label class="font-weight-bold">Alamat</label>
		            				<textarea name="alamat" rows="3" required class="form-control"><?php echo $d['alamat']; ?></textarea>
		            			</form>
		        			</div>
		    				</div>
							</div>
						<div class="card-footer text-right">
							<button name="submit" value="submit" type="submit" class="btn btn-success"><i class="fa fa-save"></i> Update</button>
							<button type="reset" class="btn btn-info"><i class="fa fa-sync-alt"></i> Reset</button>
						</div>
			<?php
					}
				}
			}
			?>
		</div>
	</form>

<?php
endif;
require_once('template/footer.php');
?>