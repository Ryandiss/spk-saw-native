<?php require_once('includes/init.php'); ?>

<?php
$errors = array();
$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['username']) ? trim($_POST['password']) : '';

if (isset($_POST['submit'])) :

    // Validasi
    if (!$username) {
        $errors[] = 'Username tidak boleh kosong';
    }
    if (!$password) {
        $errors[] = 'Password tidak boleh kosong';
    }

    if (empty($errors)) :
        $query = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$username'");
        $cek = mysqli_num_rows($query);
        $data = mysqli_fetch_array($query);

        if ($cek > 0) {
            $hashed_password = sha1($password);
            if ($data['password'] === $hashed_password) {
                $_SESSION["user_id"] = $data["id_user"];
                $_SESSION["username"] = $data["username"];
                $_SESSION["role"] = $data["role"];
                redirect_to("dashboard.php");
            } else {
                $errors[] = 'password salah!';
            }
        } else {
            $errors[] = 'Username atau password salah!';
        }

    endif;

endif;
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>Log-In SPK</title>

    <!-- Custom fonts for this template-->
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />

    <!-- Custom styles for this template-->
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet" />
    <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">
    <link rel="icon" href="assets/img/favicon.ico" type="image/x-icon">
</head>
    
    <body class="bg-gradient-purple">
    <!--
    <nav class="navbar navbar-expand-lg navbar-dark bg-white shadow-lg pb-3 pt-3 font-weight-bold">
        <div class="container">
            <a class="navbar-brand text-dark" style="font-weight: 900;" href="login.php">
                <img src="assets/images/Logo PDI Perjuangan DPP hitam resize.png" class="mr-2" width="60" alt=""> Sistem Pendukung Keputusan Metode SAW
            </a>
        </div>
    </nav>
    -->
    <div class="container">
        <!-- Outer Row -->
        <body class="bg-light">
            <div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center">
                <div class="col-md-5">
                    <div class="card shadow-lg p-4">
                        <div class="text-center mb-4">
                            <img src="assets/images/Logo PDI Perjuangan DPP hitam resize.png" alt="Logo" width="80" class="mb-3">
                            <h4>SPK Pemilihan Calon Legislatif</h4>
                        </div>
                        <?php if (!empty($errors)) : ?>
                            <?php foreach ($errors as $error) : ?>
                                <div class="alert alert-danger text-center"><?php echo $error; ?></div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <form action="login.php" method="post">
                            <div class="form-group mb-3">
                                <input type="text" name="username" class="form-control" placeholder="Username" required />
                            </div>
                            <div class="form-group mb-4">
                                <input type="password" name="password" class="form-control" placeholder="Password" required />
                            </div>
                            <button type="submit" name="submit" class="btn btn-danger w-100">
                                <i class="fas fa-sign-in-alt mr-1"></i> Masuk
                            </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="assets/js/sb-admin-2.min.js"></script>
</body>

</html>