<?php
headerAdmin($data);
getModal('modalPerfil', $data);
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Profile</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">User Profile</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle" src="<?= media(); ?>/images/avatar_principal.png" alt="User profile picture">
                            </div>

                            <h3 class="profile-username text-center"><?= $_SESSION['userData']['email_user']; ?></h3>

                            <p class="text-muted text-center"><?= $_SESSION['userData']['nombrerol']; ?></p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Followers</b> <a class="float-right">1,322</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Following</b> <a class="float-right">543</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Friends</b> <a class="float-right">13,287</a>
                                </li>
                            </ul>
                            <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
                        </div>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card card-primary card-tabs">
                        <div class="card-header p-0 pt-1">
                            <ul class="nav nav-tabs">
                                <li class="nav-item"><a class="nav-link active" href="#datosPersonales" data-toggle="tab">Datos Personales </a></li>
                                <li class="nav-item"><a class="nav-link" href="#dataFiscales" data-toggle="tab">Datos fiscales</a></li>
                            </ul>
                        </div><!-- /.card-header -->

                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="datosPersonales">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td style="width:150px;">Identificación:</td>
                                                <td><?= $_SESSION['userData']['identificacion']; ?></td>
                                            </tr>
                                            <tr>
                                                <td style="width:150px;">Nombres:</td>
                                                <td><?= $_SESSION['userData']['nombres']; ?></td>

                                            </tr>
                                            <tr>
                                                <td style="width:150px;">Apellidos:</td>
                                                <td><?= $_SESSION['userData']['apellidos']; ?></td>
                                            </tr>
                                            <tr>
                                                <td style="width:150px;">Teléfono:</td>
                                                <td><?= $_SESSION['userData']['telefono']; ?></td>
                                            </tr>
                                            <tr>
                                                <td style="width:150px;">Usuario:</td>
                                                <td><?= $_SESSION['userData']['email_user']; ?></td>
                                            </tr>
                                            <tr>
                                                <td style="width:150px;">Tipo usuario:</td>
                                                <td><?= $_SESSION['userData']['nombrerol']; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="row mb-10">
                                        <div class="col-md-12">
                                            <button class="btn btn-sm btn-info" type="button" onclick="openModalPerfil();"><i class="fa fa-fw fa-lg fas fa-pencil-alt" aria-hidden="true"></i> Actualizar</button>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="dataFiscales">
                                    <form id="formDatosFiscal" name="formDatosFiscal">
                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <label>Identificación Tributaria</label>
                                                <input class="form-control" type="text" id="txtNit" name="txtNit" value="<?= $_SESSION['userData']['nit']; ?>" autocomplete="off">
                                            </div>
                                            <div class="col-md-6">
                                                <label>Nombre Fiscal</label>
                                                <input class="form-control" type="text" id="txtNombreFiscal" name="txtNombreFiscal" value="<?= $_SESSION['userData']['nombrefiscal']; ?>" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-4">
                                                <label>Dirección fiscal</label>
                                                <input class="form-control" type="text" id="txtDirFiscal" name="txtDirFiscal" value="<?= $_SESSION['userData']['direccionfiscal']; ?>" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="row mb-10">
                                            <div class="col-md-12">
                                                <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i> Guardar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php footerAdmin($data); ?>