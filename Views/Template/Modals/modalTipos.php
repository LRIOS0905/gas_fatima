<!-- Modal Registro del Tipo -->
<div class="modal fade" id="modalFormTipo" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
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
                        <form id="formTipo" name="formTipo">
                            <input type="hidden" id="idTipo" name="idTipo" value="">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Nombre</label>
                                        <input class="form-control" id="txtTipo" name="txtTipo" type="text" placeholder="Nombre del tipo" autocomplete="off">
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