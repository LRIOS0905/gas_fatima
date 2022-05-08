<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Secury Tech">
  <meta name="theme-color" content="#009688">
  <link rel="shortcut icon" href="<?= media(); ?>/images/favicon.png">
  <title><?= $data['page_tag'] ?></title>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Oxygen:wght@300;400;700&display=swap" rel="stylesheet"> -->
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= media(); ?>/js/plugins/fontawesome-free/css/all.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="<?= media(); ?>/js/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Jquery UI -->
  <link rel="stylesheet" href="<?= media(); ?>/css/jquery-ui.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?= media(); ?>/js/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?= media(); ?>/js/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?= media(); ?>/js/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= media(); ?>/js/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= media(); ?>/js/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Toasr-->
  <link rel="stylesheet" href="<?= media(); ?>/js/plugins/toastr/toastr.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= media(); ?>/css/adminlte.min.css">
  <!-- My personal theme style -->
  <link rel="stylesheet" href="<?= media(); ?>/css/style.css">
</head>

<!-- <body class="hold-transition sidebar-mini"> -->

<body class="hold-transition sidebar-mini layout-fixed sidebar-closed sidebar-collapse text-sm layout-navbar-fixed layout-footer-fixed">

  <!-- Site wrapper -->
  <div class="wrapper">
    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="<?= media(); ?>/images/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
    </div>
    <!-- Navbar -->
    <!-- <nav class="main-header navbar navbar-expand navbar-white navbar-light"> -->
    <nav class="main-header navbar navbar-expand navbar-dark">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="fas fa-user color-options"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <div class="dropdown-divider"></div>
            <a href="<?= base_url(); ?>/congifuracion" class="dropdown-item">
              <i class="fas fa-cogs mr-2"></i> Configuración
            </a>
            <div class="dropdown-divider"></div>
            <a href="<?= base_url(); ?>/usuarios/perfil" class="dropdown-item">
              <i class="fas fa-user-cog mr-2"></i> Perfil
            </a>
            <div class="dropdown-divider"></div>
            <a href="<?= base_url(); ?>/logout" class="dropdown-item">
              <i class="fas fa-sign-out-alt mr-2"></i> Salir
            </a>
          </div>
        </li>
      </ul>

    </nav>
    <!-- /.navbar -->

    <?php require_once("nav_admin.php"); ?>