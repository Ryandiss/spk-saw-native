<?php

require_once('includes/init.php');

function redirect_to($url = '')
{
	header('Location: ' . $url);
	exit();
}

function cek_login($role = array())
{

	if (isset($_SESSION['user_id']) && isset($_SESSION['role']) && in_array($_SESSION['role'], $role)) {
		// do nothing
	} else {
		redirect_to("login.php");
	}
}

function get_role()
{

	if (isset($_SESSION['user_id']) && isset($_SESSION['role'])) {
		if ($_SESSION['role'] == '1') {
			return 'admin';
		} else {
			return 'user';
		}
	} else {
		return false;
	}
}

// custom number format
function custom_number_format($number)
{
	return (intval($number) == $number) ? intval($number) : number_format($number, 3);
}

function get_kriteria()
{
	global $koneksi;

	$kriteriaQuery = mysqli_query($koneksi, "SELECT * FROM kriteria");
	$kriteria = []; // inisialisasi array kosong
	while ($row = mysqli_fetch_assoc($kriteriaQuery)) {
		$kriteria[] = $row;
	}

	return $kriteria;
}


function get_IDkriteria()
{
	global $koneksi;

	$query = mysqli_query($koneksi, "SELECT id_kriteria FROM kriteria ORDER BY id_kriteria ASC");
	$kriteriaID = []; // inisialisasi array kosong
	while ($row = mysqli_fetch_assoc($query)) {
		$kriteriaID[] = $row['id_kriteria'];
	}

	return $kriteriaID;
}

function get_alternatif()
{
	global $koneksi;

	$alternatifQuery = mysqli_query($koneksi, "SELECT * FROM alternatif");
	$alternatif = []; // inisialisasi array kosong
	while ($row = mysqli_fetch_assoc($alternatifQuery)) {
		$alternatif[] = $row;
	}

	return $alternatif;
}

// fungsi get matriks keputusan	mengembalikan 1 nilai bukan array
function get_matriks_keputusan($id_alternatif, $id_kriteria)
{
	global $koneksi;

	$query = mysqli_query($koneksi, "SELECT 
					COALESCE(s.nilai, p.nilai) AS nilai_akhir
				FROM penilaian p
				LEFT JOIN sub_kriteria s ON p.id_sub_kriteria = s.id_sub_kriteria
				WHERE p.id_alternatif = '$id_alternatif' AND p.id_kriteria = '$id_kriteria'");

	if (!$query) {
		die('Query Error: ' . mysqli_error($koneksi));
	}

	$data = mysqli_fetch_assoc($query);
	return $data ? $data['nilai_akhir'] : null;
}

// get max min
function get_max_min($id_kriteria)
{
	global $koneksi;
	$query = "SELECT 
                MAX(COALESCE(s.nilai, p.nilai)) AS max, 
                MIN(COALESCE(s.nilai, p.nilai)) AS min, 
                k.type 
            FROM penilaian p
            LEFT JOIN sub_kriteria s ON p.id_sub_kriteria = s.id_sub_kriteria
            JOIN kriteria k ON p.id_kriteria = k.id_kriteria
            WHERE p.id_kriteria = '$id_kriteria'";
	$result = mysqli_query($koneksi, $query);
	if (!$result) {
		die('Query Error: ' . mysqli_error($koneksi));
	}
	$data = mysqli_fetch_assoc($result);
	return [
		'max' => $data['max'],
		'min' => $data['min'],
	];
}

function save_hasil($id_alternatif, $nilai)
{
	global $koneksi;
	// mysqli_query($koneksi, "TRUNCATE TABLE hasil"); // Hapus data sebelumnya
	// Insert data baru
	$query = "INSERT INTO hasil (id_hasil, id_alternatif, nilai) VALUES ('','$id_alternatif', '$nilai')";
	$result = mysqli_query($koneksi, $query);
	if (!$result) {
		die('Query Error: ' . mysqli_error($koneksi));
	}
	return $result;
}
