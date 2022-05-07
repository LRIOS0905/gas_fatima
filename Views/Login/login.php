<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Secury Tech">
    <meta name="theme-color" content="#009688">
    <link rel="shortcut icon" href="<?= media(); ?>/images/favicon.ico">
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

    <title><?= $data['page_tag'] ?></title>
</head>

<body class="hold-transition login-page">
    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="<?= media(); ?>/images/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
    </div>
    <section class="login-content">
        <div class="login-box">
            <!-- /.login-logo -->

            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <a href="../../index2.html" class="h1"><b>Admin</b>LTE</a>
                </div>
                <div class="login-box">
                    <!-- Formulario de login -->
                    <form class="login-form" name="formLogin" id="formLogin" action="">
                        <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>INICIAR SESIÓN</h3>
                        <div class="input-group mb-3">
                            <input id="txtEmail" name="txtEmail" type="email" class="form-control" placeholder="Usuario">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input id="txtPassword" name="txtPassword" type="password" class="form-control" placeholder="Contraseña">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="utility">
                                <p class="semibold-text mb-2"><a href="#" data-toggle="flip">¿Olvidaste su contraseña?</a></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="icheck-primary">
                                    <input type="checkbox" id="rememberMe">
                                    <label for="rememberMe">
                                        Recuerdame
                                    </label>
                                </div>
                            </div>
                            <div class="col-6">
                                <button type="submit" class="btn btn-primary btn-block" id="textLogin"><i class="fas fa-sign-in-alt fa-lg fa-fw"></i> Ingresar</button>
                            </div>
                            <!-- /.col -->
                        </div>
                        <br>
                    </form>

                    <!-- FORMULARIO PARA RECUPERAR CONTRASEÑA -->
                    <form id="formResetPass" name="formResetPass" class="forget-form" action="">
                        <h5 class="login-head"><i class="fa fa-lg fa-fw fa-lock"></i>¿Olvidaste tu contraseña ?</h5>
                        <div class="form-group">
                            <label class="control-label">EMAIL</label>
                            <input id="txtEmailReset" name="txtEmailReset" class="form-control" type="email" placeholder="Email">
                        </div>
                        <div class="form-group btn-container">
                            <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-unlock fa-lg fa-fw"></i>REINICIAR</button>
                        </div>
                        <div class="form-group mtt-2">
                            <p class="semibold-text mb-0"><a href="#" data-toggle="flip"><i class="fas fa-angle-double-left fa-fw"></i>Iniciar sesión</a></p>
                        </div>

                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.login-box -->
    </section>

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

<script>
        const rmcheck = document.getElementById('rememberMe'),
            usuarioInput = document.getElementById('txtEmail'),
            passInput = document.getElementById('txtPassword');
        if (localStorage.checkbox && localStorage.checkbox !== "") {
            rmcheck.setAttribute("checked", "checked");
            usuarioInput.value = localStorage.usuario;
            passInput.value = localStorage.pass;
        } else {
            rmcheck.removeAttribute("checked");
            usuarioInput.value = "";
            passInput.value = "";
        }
    </script>

</body>

</html>