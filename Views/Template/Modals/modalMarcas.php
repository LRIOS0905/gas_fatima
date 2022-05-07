<!-- Modal Registro de Marca -->
<div class="modal fade" id="modalFormMarca" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
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
                        <form id="formMarca" name="formMarca">
                            <!-- Input de tipo hidden para capturar el id y poder editar -->
                            <input type="hidden" id="idMarca" name="idMarca" value="">
                            <input type="hidden" id="foto_actual" name="foto_actual" value="">
                            <input type="hidden" id="foto_remove" name="foto_remove" value="0">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Nombre</label>
                                        <input class="form-control" id="txtMarca" name="txtMarca" type="text" placeholder="Nombre de la marca" autocomplete="off">
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">Descripcion</label>
                                        <textarea class="form-control" id="txtDescripcion" name="txtDescripcion" rows="2" placeholder="Descripcion de la Marca"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleSelect1">Estado</label>
                                        <select class="form-control" id="listStatus" name="listStatus">
                                            <option value="1">Activo</option>
                                            <option value="2">Inactivo</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="photo">
                                        <label for="foto">Foto (570x380)</label>
                                        <div class="prevPhoto">
                                            <span class="delPhoto notBlock">X</span>
                                            <label for="foto"></label>
                                            <div>
                                                <img id="img" src="<?= media(); ?>/images/uploads/portada_marca.png">
                                            </div>
                                        </div>
                                        <div class="upimg">
                                            <input type="file" name="foto" id="foto">
                                        </div>
                                        <div id="form_alert"></div>
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

<!-- Modal Registro de Marca -->
<div class="modal fade" id="modalViewMarca" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal"><i class="fa-solid fa-copyright"></i> Información de la marca</h5>
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
                                    <td>Nombres:</td>
                                    <td id="celNombre"></td>
                                </tr>
                                <tr>
                                    <td>Descripción:</td>
                                    <td id="celDescripcion"></td>
                                </tr>
                                <tr>
                                    <td>Estado:</td>
                                    <td id="celEstado"></td>
                                </tr>
                                <tr>
                                    <td>Foto:</td>
                                    <td id="imgMarca"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>