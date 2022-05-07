<?php
headerAdmin($data);
getModal('modalUsuarios', $data);
?>
<div id="contentAjax"></div>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="callout callout-info text-center">
            <h1>MÓDULO USUARIOS</h1>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <?php if ($_SESSION['permisosMod']['w']) { ?>
                                <button class="btn btn-success" type="button" onclick="openModal();"><i class="fas fa-plus-circle"></i> Nuevo Usuario</button>
                            <?php } ?>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="tableUsuarios" class="table table-bordered table-hover dataTable dtr-inline" width="100%">
                                <thead class="">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombres</th>
                                        <th>Apellidos</th>
                                        <th>Email</th>
                                        <th>Teléfono</th>
                                        <th>Rol</th>
                                        <th>Status</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php footerAdmin($data); ?>