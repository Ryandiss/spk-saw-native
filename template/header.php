<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SPK BACALEG</title>

  <!-- Custom fonts for this template-->
  <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">
  <link href="assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <script src="assets/vendor/jquery/jquery.min.js"></script>
  <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">
  <link rel="icon" href="assets/img/favicon.ico" type="image/x-icon">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-danger sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon -rotate-n-15">
          <!-- <i class="fas fa-database"></i> -->
          <img src="assets/img/Logo PDI Perjuangan DPP Putih.png" class="mr-2" width="50" alt="">
        </div>
        <div class="sidebar-brand-text mx-3">
          SPK Bacaleg
        </div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item <?= ($page == 'Dashboard') ? 'active' : '' ?>">
        <a class="nav-link" href="index.php">
          <i class="fas fa-fw fa-home"></i>
          <span>Dashboard</span></a>
      </li>

      <?php
      $user_role = get_role();
      if ($user_role == 'admin') {
      ?>
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
          Master Data
        </div>

        <li class="nav-item <?= ($page == "Alternatif") ? "active" : '' ?>">
          <a class="nav-link" href="list-alternatif.php">
            <i class="fas fa-fw fa-users"></i>
            <span>Data Bacaleg</span></a>
        </li>

        <li class="nav-item <?= ($page == "Kriteria") ? "active" : '' ?>">
          <a class="nav-link" href="list-kriteria.php">
            <i class="fas fa-fw fa-cube"></i>
            <span>Data Kriteria</span></a>
        </li>

        <li class="nav-item <?= ($page == "Sub Kriteria") ? "active" : '' ?>">
          <a class="nav-link" href="list-sub-kriteria.php">
            <i class="fas fa-fw fa-cubes"></i>
            <span>Data Subkriteria</span></a>
        </li>

        <li class="nav-item <?= ($page == "Penilaian" || $page == "Perhitungan") ? "active" : '' ?>">
          <a class="nav-link collapsed navbar-toggler" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Proses SAW</span>
          </a>
          <div id="collapseTwo" class="collapse  <?= ($page == "Penilaian" || $page == "Perhitungan") ? "show" : "" ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <!-- <h6 class="collapse-header">Custom Components:</h6> -->
              <a class="collapse-item <?= ($page == 'Penilaian') ? 'active' : '' ?>" href="list-penilaian.php">Penilaian Bacaleg</a>
              <a class="collapse-item <?= ($page == 'Perhitungan') ? 'active' : '' ?>" href="perhitungan.php">Perhitungan</a>
            </div>
          </div>
        </li>
     <li class="nav-item <?= (
    $page == "Laporan Bacaleg" || 
    $page == "Laporan Kriteria" || 
    $page == "Laporan Sub Kriteria" || 
    $page == "Laporan Penilaian" || 
    $page == "Hasil Akhir"
  ) ? "active" : '' ?>">
  <a class="nav-link collapsed navbar-toggler" href="#" data-toggle="collapse" data-target="#collapseLaporan" aria-expanded="true" aria-controls="collapseLaporan">
    <i class="fas fa-fw fa-file-alt"></i>
    <span>Laporan</span>
  </a>
  <div id="collapseLaporan" class="collapse <?= (
    $page == "Laporan Bacaleg" || 
    $page == "Laporan Kriteria" || 
    $page == "Laporan Sub Kriteria" || 
    $page == "Laporan Penilaian" || 
    $page == "Hasil Akhir"
    ) ? "show" : "" ?>" aria-labelledby="headingLaporan" data-parent="#accordionSidebar">
    <div class="bg-white py-2 collapse-inner rounded">
      <a class="collapse-item <?= ($page == 'Laporan Bacaleg') ? 'active' : '' ?>" href="laporan-bacaleg.php">Laporan Bacaleg</a>
     <a class="collapse-item <?= ($page == 'Laporan Kriteria') ? 'active' : '' ?>" href="laporan-kriteria.php">Laporan Kriteria</a>
      <a class="collapse-item <?= ($page == 'Laporan Sub Kriteria') ? 'active' : '' ?>" href="laporan-sub-kriteria.php">Laporan Subkriteria</a>
      <a class="collapse-item <?= ($page == 'Laporan Penilaian') ? 'active' : '' ?>" href="laporan-penilaian.php">Laporan Penilaian</a>
      <a class="collapse-item <?= ($page == 'Hasil Akhir') ? 'active' : '' ?>" href="laporan-hasil-akhir.php">Hasil Akhir</a>
    </div>
  </div>
</li>


        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
          Master User
        </div>


        <li class="nav-item <?= ($page == "User") ? "active" : '' ?>">
          <a class="nav-link" href="list-user.php">
            <i class="fas fa-fw fa-users-cog"></i>
            <span>Data User</span></a>
        </li>

        <li class="nav-item <?= ($page == "Profile") ? "active" : '' ?>">
          <a class="nav-link" href="list-profile.php">
            <i class="fas fa-fw fa-user"></i>
            <span>Profile</span></a>
        </li>

      <?php
      } elseif ($user_role == 'user') {
      ?>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <li class="nav-item <?= ($page == "Perhitungan") ? "active" : "" ?>">
          <a class="nav-link" href="perhitungan.php">
            <i class="fas fa-fw fa-calculator"></i>
            <span>Perhitungan</span></a>
        </li>

        <!--<li class="nav-item <?= ($page == "Hasil") ? "active" : "" ?>">
          <a class="nav-link" href="laporan-hasil-akhir.php">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Hasil Perangkingan</span></a>
        </li>-->
             <li class="nav-item <?= (
        $page == "Laporan Bacaleg" || 
        $page == "Laporan Kriteria" || 
        $page == "Laporan Sub Kriteria" || 
        $page == "Laporan Penilaian" || 
        $page == "Hasil Akhir"
      ) ? "active" : '' ?>">
      <a class="nav-link collapsed navbar-toggler" href="#" data-toggle="collapse" data-target="#collapseLaporan" aria-expanded="true" aria-controls="collapseLaporan">
        <i class="fas fa-fw fa-file-alt"></i>
        <span>Laporan</span>
      </a>
      <div id="collapseLaporan" class="collapse <?= (
        $page == "Laporan Bacaleg" || 
        $page == "Laporan Kriteria" || 
        $page == "Laporan Sub Kriteria" || 
        $page == "Laporan Penilaian" || 
        $page == "Hasil Akhir"
        ) ? "show" : "" ?>" aria-labelledby="headingLaporan" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <a class="collapse-item <?= ($page == 'Laporan Bacaleg') ? 'active' : '' ?>" href="laporan-bacaleg.php">Laporan Bacaleg</a>
         <a class="collapse-item <?= ($page == 'Laporan Kriteria') ? 'active' : '' ?>" href="laporan-kriteria.php">Laporan Kriteria</a>
          <a class="collapse-item <?= ($page == 'Laporan Sub Kriteria') ? 'active' : '' ?>" href="laporan-sub-kriteria.php">Laporan Sub Kriteria</a>
          <a class="collapse-item <?= ($page == 'Laporan Penilaian') ? 'active' : '' ?>" href="laporan-penilaian.php">Laporan Penilaian</a>
          <a class="collapse-item <?= ($page == 'Hasil Akhir') ? 'active' : '' ?>" href="laporan-hasil-akhir.php">Hasil Akhir</a>
        </div>
      </div>
    </li>


        <!-- Divider -->
        <hr class="sidebar-divider">



        <li class="nav-item <?= ($page == "Profile") ? "active" : "" ?>">
          <a class="nav-link" href="list-profile.php">
            <i class="fas fa-fw fa-user"></i>
            <span>Profile</span></a>
        </li>

      <?php
      }
      ?>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn text-primary d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="text-uppercase mr-2 d-none d-lg-inline text-gray-600 small">
                  <?php
                  echo $_SESSION['username'];
                  ?>
                </span>
                <img class="img-profile rounded-circle" src="assets/img/user.png">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="list-profile.php">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <div class="container-fluid">