<!-- Modal -->
<div class="modal fade" id="modalBuscarProveedor" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="header-title">BUSCAR PROVEEDOR</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-primary card-tabs">
                            <div class="card-header p-0 pt-1 border-bottom-0">
                                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home" aria-selected="false"><i class="fa-solid fa-list-check"></i> LISTADO PROVEEDORES</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill" href="#custom-tabs-three-profile" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="true"><i class="fa-solid fa-user-vneck"></i> NUEVO PROVEEDOR</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-three-tabContent">
                                    <div class="tab-pane fade active show" id="custom-tabs-three-home" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
                                        <table id="tableVerProveedor" class="table table-bordered table-hover dataTable dtr-inline table-sm" width="100%">
                                            <thead class="">
                                                <tr>
                                                    <th>ID</th>
                                                    <th>NOMBRE</th>
                                                    <th>TELEFONO</th>
                                                    <th>CORREO</th>
                                                    <th>OPCIONES</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-font">
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-three-profile" role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab">
                                        <form id="nuevoProveedor">
                                            <input type="hidden" id="idProveedor" name="idProveedor">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="txtProveedor">Nombre</label>
                                                        <input type="text" class="form-control" id="txtProveedor" name="txtProveedor" placeholder="Ingresar nombre del proveedor" autocomplete="off">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="txtTelefono">Teléfono</label>
                                                        <input type="text" class="form-control" id="txtTelefono" name="txtTelefono" placeholder="Ingresar telefono" autocomplete="off">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="txtEmail">Correo</label>
                                                        <input type="email" class="form-control" id="txtEmail" name="txtEmail" placeholder="Ingresar correo" autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="txtDireccion">Dirección</label>
                                                        <input type="text" class="form-control" id="txtDireccion" name="txtDireccion" placeholder="Ingresar dirección" autocomplete="off">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="listStatus">Estado</label>
                                                        <select class="form-control" id="listStatus" name="listStatus">
                                                            <option value="1">Activo</option>
                                                            <option value="2">Inactivo</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer text-center">
                                                <button type="submit" class="btn btn-primary">Crear proveedor</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>