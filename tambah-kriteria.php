<?php
require_once('includes/init.php');
cek_login($role = array(1));
$page = "Tambah Kriteria";
require_once('template/header.php');

$id_kriteria_baru = null;
$success_msg = '';
$errors = [];

// STEP 1: Simpan Kriteria
if (isset($_POST['submit_kriteria'])) {
    $kode_kriteria = $_POST['kode_kriteria'];
    $nama = $_POST['nama'];
    $type = $_POST['type'];
    $bobot = $_POST['bobot'];

    // Validasi
    if (!$kode_kriteria || !$nama || !$type || !$bobot) {
        $errors[] = 'Semua field wajib diisi';
    } else {
        // Cek kode kriteria duplikat
        $cek_duplikat = mysqli_query($koneksi, "SELECT * FROM kriteria WHERE kode_kriteria = '$kode_kriteria'");
        if (mysqli_num_rows($cek_duplikat) > 0) {
            $errors[] = 'kode_kriteria_duplicated';
        } else {
            $simpan = mysqli_query($koneksi, "INSERT INTO kriteria (kode_kriteria, kriteria, type, bobot, ada_pilihan) 
                        VALUES ('$kode_kriteria', '$nama', '$type', '$bobot', '1')");
            if ($simpan) {
                $id_kriteria_baru = mysqli_insert_id($koneksi);
                $success_msg = 'Kriteria berhasil disimpan. Silakan tambahkan subkriteria.';
            } else {
                $errors[] = 'Gagal menyimpan data kriteria';
            }
        }
    }
}

// STEP 2: Simpan Subkriteria
if (isset($_POST['submit_sub'])) {
    $id_kriteria = $_POST['id_kriteria'];
    $nama_sub = $_POST['nama_sub'];
    $nilai = $_POST['nilai'];

    if (!$nama_sub || !$nilai) {
        $errors[] = 'Nama subkriteria dan nilai wajib diisi';
    } else {
        $simpan_sub = mysqli_query($koneksi, "INSERT INTO sub_kriteria (id_kriteria, sub_kriteria, nilai) 
                    VALUES ('$id_kriteria', '$nama_sub', '$nilai')");
        if ($simpan_sub) {
            $success_msg = 'Subkriteria berhasil ditambahkan';
            $id_kriteria_baru = $id_kriteria; // agar tetap di halaman subkriteria
        } else {
            $errors[] = 'Gagal menyimpan data subkriteria';
        }
    }
}
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-cube"></i> Data Kriteria</h1>
    <a href="list-kriteria.php" class="btn btn-secondary btn-icon-split">
                <span class="icon text-white-100"><i class="fas fa-arrow-left"></i></span>
                <span class="text">Kembali</span>
            </a>
</div>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <?php foreach ($errors as $e): ?>
            <?php if ($e == 'kode_kriteria_duplicated'): ?>
                <div>kode_kriteria_duplicated.</div>
            <?php else: ?>
                <div><?= $e ?></div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
<?php elseif ($success_msg): ?>
    <div class="alert alert-success">
        <?= $success_msg ?>
    </div>
<?php endif; ?>

<?php if (!$id_kriteria_baru): ?>
<!-- FORM TAMBAH KRITERIA -->
<form method="post" action="">
    <div class="card mb-4">
        <div class="card-header text-danger"><i class="fas fa-fw fa-plus"></i><strong>Tambah Data Kriteria</strong></div>
        <div class="card-body">
            <div class="form-group">
                <label>Kode Kriteria</label>
                <input type="text" 
                    name="kode_kriteria" 
                    value="<?= htmlspecialchars($_POST['kode_kriteria'] ?? '') ?>" 
                    class="form-control <?= in_array('kode_kriteria_duplicated', $errors) ? 'is-invalid' : '' ?>" 
                    required>
                <?php if (in_array('kode_kriteria_duplicated', $errors)): ?>
                    <div class="invalid-feedback">
                        Kode Kriteria sudah terdaftar di database.
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label>Nama Kriteria</label>
                <input type="text" name="nama" value="<?= htmlspecialchars($_POST['nama'] ?? '') ?>" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Atribut / Type</label>
                <select class="form-control" name="type" required>
                    <option value="">--Pilih--</option>
                    <option value="benefit" <?= (($_POST['type'] ?? '') == 'benefit') ? 'selected' : '' ?>>Benefit</option>
                    <option value="cost" <?= (($_POST['type'] ?? '') == 'cost') ? 'selected' : '' ?>>Cost</option>
                </select>
            </div>

            <div class="form-group">
                <label>Bobot</label>
                <input type="number" step="0.001" name="bobot" value="<?= htmlspecialchars($_POST['bobot'] ?? '') ?>" class="form-control" required>
                <small class="form-text text-muted">
                *Bobot menggunakan skala 0–1, dan total seluruh bobot harus berjumlah 1.0.
            </small>
            </div>
        </div>

        <div class="card-footer text-right">
            <button name="submit_kriteria" class="btn btn-success"><i class="fa fa-save"></i> Simpan dan Lanjut</button>
            
        </div>
    </div>
</form>

<?php else: ?>
<!-- FORM TAMBAH SUBKRITERIA -->
<form method="post" action="">
    <input type="hidden" name="id_kriteria" value="<?= $id_kriteria_baru; ?>">
    <div class="card mb-4">
        <div class="card-header"><strong> Tambah Data Subkriteria</strong></div>
        <div class="card-body">
            <div class="form-group">
                <label>Nama Subkriteria</label>
                <input type="text" name="nama_sub" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Nilai</label>
                <input type="number" step="0.001" name="nilai" class="form-control" required>
            </div>
        </div>
        <div class="card-footer text-right">
            <button name="submit_sub" class="btn btn-success"><i class="fa fa-save"></i> Simpan </button>
            <a href="list-kriteria.php?status=sukses-tambah" class="btn btn-secondary">
                <span class="icon text-white-100"><i class="fas fa-fw fa-check mr-1"></i></span>
                <span class="text">Selesai</span>
            </a>
        </div>
    </div>
</form>

<!-- TABEL SUBKRITERIA YANG SUDAH DITAMBAHKAN -->
<?php
$q_sub = mysqli_query($koneksi, "SELECT * FROM sub_kriteria WHERE id_kriteria = '$id_kriteria_baru' ORDER BY nilai DESC");
if (mysqli_num_rows($q_sub) > 0): ?>
    <div class="card shadow mb-4">
        <div class="card-header"><strong>Daftar Subkriteria yang Ditambahkan</strong></div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead class="bg-danger text-white">
                    <tr align="center">
                        <th>No</th>
                        <th>Nama Subkriteria</th>
                        <th>Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; while ($sub = mysqli_fetch_array($q_sub)): ?>
                        <tr align="center">
                            <td><?= $no++; ?></td>
                            <td align="left"><?= $sub['sub_kriteria']; ?></td>
                            <td><?= $sub['nilai']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>
<?php endif; ?>

<?php require_once('template/footer.php'); ?>