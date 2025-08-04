<?php
require_once('includes/init.php');

if (!isset($_GET['id']) || !isset($_GET['id_kriteria'])) {
  header('Location: list-kriteria.php');
  exit();
}

$id_sub = $_GET['id'];
$id_kriteria = $_GET['id_kriteria'];

// Hapus subkriteria
mysqli_query($koneksi, "DELETE FROM sub_kriteria WHERE id_sub_kriteria = '$id_sub'");

// Redirect dengan pesan sukses
header("Location: edit-kriteria.php?id=$id_kriteria&status=deleted");
exit();
?>
