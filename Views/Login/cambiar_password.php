<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Log in (v2)</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= media(); ?>/js/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?= media(); ?>/js/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?= media(); ?>/js/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="<?= media(); ?>/js/plugins/toastr/toastr.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= media(); ?>/css/adminlte.min.css">
    <link rel="stylesheet" href="<?= media(); ?>/css/style.css">
</head>

<body class="hold-transition login-page">
     <!-- Preloader -->
     <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="<?= media(); ?>/images/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
    </div>
     
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="../../index2.html" class="h1"><b>Admin</b>LTE</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">You are only one step a way from your new password, recover your password now.</p>
                <form id="formCambiarPass" name="formCambiarPass" class="forget-form" action="">
                    <input type="hidden" id="idUsuario" name="idUsuario" value="<?= $data['idpersona']; ?>" required>
                    <input type="hidden" id="txtEmail" name="txtEmail" value="<?= $data['email']; ?>" required>
                    <input type="hidden" id="txtToken" name="txtToken" value="<?= $data['token']; ?>" required>
                    <div class="input-group mb-3">
                        <input id="txtPassword" name="txtPassword" class="form-control" type="password" placeholder="Nueva contraseña">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input id="txtPasswordConfirm" name="txtPasswordConfirm" class="form-control" type="password" placeholder="Confirmar contraseña">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Cambiar contraseña</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->


    <!-- jQuery -->
    <script src="<?= media(); ?>/js/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= media(); ?>/js/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= media(); ?>/js/adminlte.min.js"></script>
    <!-- Main JS -->
    <script src="<?= media(); ?>/js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="<?= media(); ?>/js/plugins/pace.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="<?= media(); ?>/js/plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Toastr -->
    <script src="<?= media(); ?>/js/plugins/toastr/toastr.min.js"></script>
    <!-- Pagina de funciones-->
    <script src="<?= media(); ?>/js/<?= $data['page_functions_js']; ?>"></script>
    <script>
        const base_url = "<?= base_url(); ?>"
    </script>
</body>

</html>