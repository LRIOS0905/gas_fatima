<!-- Modal Registro de Productos -->
<div class="modal fade" id="modalFormProductos" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
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
                        <form id="formProductos" name="formProductos">
                            <!-- Input de tipo hidden para capturar el id y poder editar -->
                            <input type="hidden" id="idProducto" name="idProducto">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="txtCodigo">Código</label>
                                        <input type="text" class="form-control form-control-border border-width-2" id="txtCodigo" name="txtCodigo" placeholder="Código del producto" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label for="txtDescripcion">Descripción</label>
                                        <input type="text" class="form-control form-control-border border-width-2" id="txtDescripcion" name="txtDescripcion" placeholder="Descripción del producto" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label for="precioCompra">Precio de compra</label>
                                        <input type="text" class="form-control form-control-border border-width-2" id="precioCompra" name="precioCompra" placeholder="Precio de compra" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label for="precioVenta">Precio de venta</label>
                                        <input type="text" class="form-control form-control-border border-width-2" id="precioVenta" name="precioVenta" placeholder="Precio de venta" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="stock">Stock</label>
                                        <input type="text" class="form-control form-control-border border-width-2" id="stock" name="stock" placeholder="Stock del producto" value="0" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="listMarca">Marca</label>
                                        <select class="form-control form-control-border border-width-2" id="listMarca" name="listMarca">
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="listTipo">Tipo</label>
                                        <select class="form-control form-control-border border-width-2" id="listTipo" name="listTipo">
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="listStatus">Estado</label>
                                        <select class="form-control form-control-border border-width-2" id="listStatus" name="listStatus">
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


<!-- Modal View Productos -->
<div class="modal fade" id="modalViewProducto" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal"><i class="fa-solid fa-user"></i> Información del Producto</h5>
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
                                    <td>Descripcion:</td>
                                    <td id="celDescripcion"></td>
                                </tr>
                                <tr>
                                    <td>Precio de Compra:</td>
                                    <td id="celPrecioCompra"></td>
                                </tr>
                                <tr>
                                    <td>Precio de Venta:</td>
                                    <td id="celPrecioVenta"></td>
                                </tr>
                                <tr>
                                    <td>Stock:</td>
                                    <td id="celStock"></td>
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