<!-- Modal Registro de Rol -->
<div class="modal fade" id="modalFormRol" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal"><i class="fas fa-cubes fa-lg"></i> Nuevo Rol</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tile">
                    <div class="tile-body">
                        <form id="formRol" name="formRol">
                            <!-- Input de tipo hidden para capturar el id y poder editar -->
                            <input type="hidden" id="idRol" name="idRol" value="">
                            <!-- Input para el nombre del Rol -->
                            <div class="form-group">
                                <label class="control-label">Nombre</label>
                                <input class="form-control" id="txtNombre" name="txtNombre" type="text" placeholder="Nombre del Rol" autocomplete="off">
                            </div>
                            <!-- Input para la descripcion del Rol -->
                            <div class="form-group">
                                <label class="control-label">Descripcion</label>
                                <textarea class="form-control" id="txtDescripcion" name="txtDescripcion" rows="2" placeholder="Descripcion del Rol"></textarea>
                            </div>
                            <!-- Select para opciones de Estado -->
                            <div class="form-group">
                                <label for="exampleSelect1">Estado</label>
                                <select class="form-control" id="listStatus" name="listStatus">
                                    <option value="1">Activo</option>
                                    <option value="2">Inactivo</option>
                                </select>
                            </div>
                            <div id="mensaje"></div>
                            <!-- Botones para guardar y cancelar -->
                            <div class="tile-footer">
                                <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;
                                <a class="btn btn-danger" href="#" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>