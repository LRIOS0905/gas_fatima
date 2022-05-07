<!-- Modal Registro de Cliente -->
<div class="modal fade" id="modalFormClientes" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal"><i class="fa-solid fa-copyright"></i> Nueva Marca</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tile">
                    <div class="tile-body">
                        <form id="formClientes" name="formClientes">
                            <!-- Input de tipo hidden para capturar el id y poder editar -->
                            <input type="hidden" id="idCliente" name="idCliente" value="">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Código</label>
                                        <input class="form-control" id="txtCodigo" name="txtCodigo" type="text" placeholder="Nombres y apellidos" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Nombre</label>
                                        <input class="form-control" id="txtNombre" name="txtNombre" type="text" placeholder="Nombres y apellidos" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Teléfono</label>
                                        <input class="form-control" id="txtTelefono" name="txtTelefono" type="text" placeholder="Teléfono" autocomplete="off">
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">Dirección</label>
                                        <textarea class="form-control" id="txtDireccion" name="txtDireccion" rows="3" placeholder="Direccion del cliente"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="listMarca">Marca</label>
                                        <select class="form-control" id="listMarca" name="listMarca">

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="listTipo">Tipo</label>
                                        <select class="form-control" id="listTipo" name="listTipo">
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleSelect1">Estado</label>
                                        <select class="form-control" id="listStatus" name="listStatus">
                                            <option value="1">Activo</option>
                                            <option value="2">Inactivo</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div id="mensaje" class="mb-3"></div>
                            <div class="tile-footer">
                                <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText"></span></button>&nbsp;&nbsp;&nbsp;
                                <a class="btn btn-danger" href="#" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Registro de Cliente -->
<div class="modal fade" id="modalViewCliente" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal"><i class="fa-solid fa-user"></i> Información del Cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tile">
                    <div class="tile-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td>ID:</td>
                                    <td id="celId"></td>
                                </tr>
                                <tr>
                                    <td>Código:</td>
                                    <td id="celCodigo"></td>
                                </tr>
                                <tr>
                                    <td>Nombres:</td>
                                    <td id="celNombre"></td>
                                </tr>
                                <tr>
                                    <td>Teléfono:</td>
                                    <td id="celTelefono"></td>
                                </tr>
                                <tr>
                                    <td>Dirección:</td>
                                    <td id="celDireccion"></td>
                                </tr>
                                <tr>
                                    <td>Marca:</td>
                                    <td id="celMarca"></td>
                                </tr>
                                <tr>
                                    <td>Tipo:</td>
                                    <td id="celTipo"></td>
                                </tr>
                                <tr>
                                    <td>Estado:</td>
                                    <td id="celEstado"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>