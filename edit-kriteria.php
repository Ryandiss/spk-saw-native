<?php
require_once('includes/init.php');
$user_role = get_role();
if ($user_role != 'admin') {
  header('Location: login.php');
  exit();
}

$errors = array();
$id_kriteria = isset($_GET['id']) ? trim($_GET['id']) : '';

if (isset($_POST['submit'])) {
  // Data Kriteria
  $kode_kriteria = $_POST['kode_kriteria'];
  $nama = $_POST['nama'];
  $type = $_POST['type'];
  $bobot = $_POST['bobot'];
  $ada_pilihan = $_POST['ada_pilihan'];

  // Validasi
  if (!$kode_kriteria) $errors[] = 'Kode kriteria tidak boleh kosong';
  if (!$nama) $errors[] = 'Nama kriteria tidak boleh kosong';
  if (!$type) $errors[] = 'Tipe kriteria tidak boleh kosong';
  if (!$bobot) $errors[] = 'Bobot kriteria tidak boleh kosong';

  if (empty($errors)) {
    // Update kriteria
    $update = mysqli_query($koneksi, "UPDATE kriteria SET kode_kriteria = '$kode_kriteria', kriteria = '$nama', type = '$type', bobot = '$bobot', ada_pilihan = '$ada_pilihan' WHERE id_kriteria = '$id_kriteria'");

    // Subkriteria
    if (!empty($_POST['id_sub'])) {
      $id_sub = $_POST['id_sub'];
      $nama_sub = $_POST['nama_sub'];
      $nilai = $_POST['nilai'];

      for ($i = 0; $i < count($id_sub); $i++) {
        $id_s = mysqli_real_escape_string($koneksi, $id_sub[$i]);
        $nama_s = mysqli_real_escape_string($koneksi, $nama_sub[$i]);
        $nilai_s = mysqli_real_escape_string($koneksi, $nilai[$i]);

        if ($id_s == 'new' && $nama_s != '' && $nilai_s != '') {
          mysqli_query($koneksi, "INSERT INTO sub_kriteria (id_kriteria, sub_kriteria, nilai) VALUES ('$id_kriteria', '$nama_s', '$nilai_s')");
        } else {
          mysqli_query($koneksi, "UPDATE sub_kriteria SET sub_kriteria = '$nama_s', nilai = '$nilai_s' WHERE id_sub_kriteria = '$id_s'");
        }
      }
    }

    if ($update) {
      header("Location: list-kriteria.php?status=sukses-edit");
      exit();
    } else {
      $errors[] = 'Data gagal diupdate';
    }
  }
}

$page = "Kriteria";
require_once('template/header.php');
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-cube"></i> Edit Data Kriteria</h1>
  <a href="list-kriteria.php" class="btn btn-secondary btn-icon-split">
    <span class="icon text-white-50"><i class="fas fa-arrow-left"></i></span>
    <span class="text">Kembali</span>
  </a>
</div>

<?php if (isset($_GET['status']) && $_GET['status'] == 'deleted') : ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    Subkriteria berhasil dihapus.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<?php if (!empty($errors)) : ?>
  <div class="alert alert-danger">
    <?php foreach ($errors as $error) : ?>
      <div><?php echo $error; ?></div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<?php
$data = mysqli_query($koneksi, "SELECT * FROM kriteria WHERE id_kriteria='$id_kriteria'");
if (mysqli_num_rows($data) <= 0) {
  echo '<div class="alert alert-warning">Data tidak ditemukan</div>';
  require_once('template/footer.php');
  exit();
}
$d = mysqli_fetch_assoc($data);
?>

<form action="edit-kriteria.php?id=<?php echo $id_kriteria; ?>" method="post">
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-danger"><i class="fas fa-fw fa-edit"></i>Ubah Data Kriteria</h6>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="form-group col-md-6">
          <label class="font-weight-bold">Kode Kriteria</label>
          <input type="text" name="kode_kriteria" value="<?php echo $d['kode_kriteria']; ?>" class="form-control" required>
        </div>
        <div class="form-group col-md-6">
          <label class="font-weight-bold">Nama Kriteria</label>
          <input type="text" name="nama" value="<?php echo $d['kriteria']; ?>" class="form-control" required>
        </div>
        <div class="form-group col-md-6">
          <label class="font-weight-bold">Atribut</label>
          <select name="type" class="form-control" required>
            <option value="">--Pilih--</option>
            <option value="Benefit" <?php if ($d['type'] == 'Benefit') echo 'selected'; ?>>Benefit</option>
            <option value="Cost" <?php if ($d['type'] == 'Cost') echo 'selected'; ?>>Cost</option>
          </select>
        </div>
        <div class="form-group col-md-6">
          <label class="font-weight-bold">Bobot</label>
          <input type="number" step="0.01" name="bobot" value="<?php echo $d['bobot']; ?>" class="form-control" required>
        </div>
        <div class="form-group col-md-6">
          <label class="font-weight-bold">Cara Penilaian</label>
          <select name="ada_pilihan" class="form-control" required>
            <option value="">--Pilih--</option>
            <option value="0" <?php if ($d['ada_pilihan'] == "0") echo "selected"; ?>>Inputan Langsung</option>
            <option value="1" <?php if ($d['ada_pilihan'] == "1") echo "selected"; ?>>Pilihan Sub Kriteria</option>
          </select>
        </div>
      </div>
    </div>
  </div>

  <!-- SUBKRITERIA -->
  <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between">
      <h6 class="m-0 font-weight-bold text-danger"><i class="fas fa-fw fa-list"></i> Ubah Data Subkriteria</h6>
      <button type="button" class="btn btn-success btn-sm" id="tambah-subkriteria">
        <i class="fa fa-plus"></i> Tambah Subkriteria
      </button>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th class="bg-danger text-white text-center">No</th>
              <th class="bg-danger text-white text-center">Nama Subkriteria</th>
              <th class="bg-danger text-white text-center">Nilai</th>
              <th class="bg-danger text-white text-center">Aksi</th>
            </tr>
          </thead>
          <tbody id="tbody-subkriteria">
            <?php
            $sub_query = mysqli_query($koneksi, "SELECT * FROM sub_kriteria WHERE id_kriteria = '$id_kriteria'");
            $no = 1;
            while ($sub = mysqli_fetch_assoc($sub_query)) : ?>
              <tr>
                <td class="text-center"><?= $no++; ?></td>
                <td>
                  <input type="hidden" name="id_sub[]" value="<?= $sub['id_sub_kriteria']; ?>">
                  <input type="text" name="nama_sub[]" class="form-control" value="<?= $sub['sub_kriteria']; ?>">
                </td>
                <td>
                  <input type="number" name="nilai[]" step="0.01" class="form-control" value="<?= $sub['nilai']; ?>">
                </td>
                <td class="text-center">
                  <a data-toggle="tooltip" data-placement="bottom" href="hapus-sub-kriteria.php?id=<?= $sub['id_sub_kriteria']; ?>&id_kriteria=<?= $id_kriteria; ?>"
                     class="btn btn-primary btn-sm" 
                     onclick="return confirm('Apakah Anda Yakin ingin menghapus subkriteria ini?');"title="Hapus Data Subkriteria">
                     <i class="fa fa-trash"></i>
                  </a>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
    <div class="card-footer text-right">
      <button type="submit" name="submit" class="btn btn-success"><i class="fa fa-save"></i> Update</button>
    </div>
  </div>
</form>

<!-- Tambah Subkriteria JS -->
<script>
document.getElementById('tambah-subkriteria').addEventListener('click', function () {
  const tbody = document.getElementById('tbody-subkriteria');
  const newRow = document.createElement('tr');
  newRow.innerHTML = `
    <td class="text-center no-urut"></td>
    <td>
      <input type="hidden" name="id_sub[]" value="new">
      <input type="text" name="nama_sub[]" class="form-control" placeholder="Nama Subkriteria">
    </td>
    <td>
      <input type="number" name="nilai[]" step="0.01" class="form-control" placeholder="Nilai">
    </td>
    <td class="text-center">
      <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('tr').remove(); updateNoUrut();">
        <i class="fa fa-trash"></i>
      </button>
    </td>
  `;
  tbody.appendChild(newRow);
  updateNoUrut();
});

function updateNoUrut() {
  const rows = document.querySelectorAll('#tbody-subkriteria tr');
  rows.forEach((row, index) => {
    const noCell = row.querySelector('.no-urut');
    if (noCell) {
      noCell.textContent = index + 1;
    }
  });
}

// Jalankan saat halaman pertama kali dimuat, untuk koreksi urutan jika ada
document.addEventListener('DOMContentLoaded', updateNoUrut);
</script>


<?php require_once('template/footer.php'); ?>
