<!-- Modal Registro de Usuarios -->
<div class="modal fade" id="modalFormUsuario" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Nuevo Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tile">
                    <div class="tile-body">
                        <form id="formUsuario" name="formUsuario" class="form-horizontal">
                            <!-- Input de tipo hidden para capturar el id y poder editar -->
                            <input type="hidden" id="idUsuario" name="idUsuario" value="">
                            <p class="text-primary">Todos los campos son obligatorios.</p>

                            <!-- Input para el numero de indentificacion del Usuario -->
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="txtIdentificacion">Identificación</label>
                                    <input type="text" class="form-control" id="txtIdentificacion" name="txtIdentificacion" autocomplete="off">
                                </div>
                            </div>

                            <!-- Input para Nombres y apellidos del Usuario -->
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="txtNombre">Nombres</label>
                                    <input type="text" class="form-control valid validText" id="txtNombre" name="txtNombre" autocomplete="off">
                                </div>


                                <div class="form-group col-md-6">
                                    <label for="txtApellido">Apellidos</label>
                                    <input type="text" class="form-control valid validText" id="txtApellido" name="txtApellido" autocomplete="off">
                                </div>
                            </div>

                            <!-- Input para Telefono e Emial -->
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="txtTelefono">Teléfono</label>
                                    <input type="text" class="form-control valid validNumber" id="txtTelefono" name="txtTelefono" autocomplete="off" onkeypress="return controlTag(event);">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="txtEmail">Email</label>
                                    <input type="email" class="form-control valid validEmail" id="txtEmail" name="txtEmail" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="listRolid">Tipo usuario</label>
                                    <select class="form-control" data-live-search="true" name="listRolid" id="listRolid">
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="listStatus">Status</label>
                                    <select class="form-control" name="listStatus" id="listStatus">
                                        <option value="1">Activo</option>
                                        <option value="2">Inactivo</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Input para la contraseña -->

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="txtPassword">Contraseña</label>
                                    <input type="password" class="form-control" id="txtPassword" name="txtPassword">
                                </div>
                            </div>

                            <!-- Botones para guardar y cancelar -->
                            <div class="tile-footer text-center">
                                <button id="btnActionForm" class="btn btn-primary" type="submit" style="width: 130px;"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;
                                <button class="btn btn-danger" type="button" data-dismiss="modal" style="width: 130px;"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para vista dellades de usuario -->
<div class="modal fade" id="modalViewUsuario" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header header-primary">
                <h5 class="modal-title" id="titleModal">Datos del Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="tile-body">
                    <!-- Mostrabamos la tabla de los detalles del usuario -->

                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td>Identificación:</td>
                                <td id="celIdentificacion">654654654</td>
                            </tr>
                            <tr>
                                <td>Nombres:</td>
                                <td id="celNombre">Jacob</td>
                            </tr>
                            <tr>
                                <td>Apellidos:</td>
                                <td id="celApellido">Jacob</td>
                            </tr>
                            <tr>
                                <td>Teléfono:</td>
                                <td id="celTelefono">Larry</td>
                            </tr>
                            <tr>
                                <td>Email (Usuario):</td>
                                <td id="celEmail">Larry</td>
                            </tr>
                            <tr>
                                <td>Tipo Usuario:</td>
                                <td id="celTipoUsuario">Larry</td>
                            </tr>
                            <tr>
                                <td>Estado:</td>
                                <td id="celEstado">Larry</td>
                            </tr>
                            <tr>
                                <td>Fecha registro:</td>
                                <td id="celFechaRegistro">Larry</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="text-right">
                    <button type="button" class="btn btn-secondary text-center" style="width:100px;" data-dismiss="modal"><i class="fas fa-times-circle"></i> Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>