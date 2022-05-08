<?php
headerAdmin($data);
getModal('modalBuscarProveedor', $data);
?>


<div class="content-wrapper">
    <section class="content-header">
        <div class="callout callout-info text-center shadows">
            <h1><?= $data['page_title'] ?></h1>
        </div>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadows">
                    <div class="card-header bg-info">
                        <h3 class="card-title">INFORMACION DEL PROVEEDOR </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <button type="button" id="buscarProveedor" class="btn btn-success"><i class="fa-solid fa-search"></i></button>
                                    </div>
                                    <input type="text" class="form-control" id="nombreProveedor" name="nombreProveedor" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-info"><i class="fa-regular fa-phone"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="telProveedor" name="telProveedor" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-info"><i class="fa-solid fa-envelope-circle-check"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="emailProveedor" name="emailProveedor" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="card shadows">
                    <div class="card-header bg-info text-center">
                        <h3 class="card-title">FORMULARIO DE COMPRAS</h3>
                    </div>
                    <div class="card-body">
                        <form id="formCompras">
                            <input type="hidden" id="idCompra" name="idCompra">
                            <input type="hidden" id="idProducto" name="idProducto">
                            <input type="hidden" id="idMarca" name="idMarca">
                            <input type="hidden" id="idTipo" name="idTipo">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-info"><i class="fa-regular fa-barcode"></i></span>
                                        </div>
                                        <input type="text" id="txtCodigo" name="txtCodigo" class="form-control" placeholder="Código del producto">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-info"><i class="fa-brands fa-product-hunt"></i></span>
                                        </div>
                                        <input type="text" id="txtDescripcion" name="txtDescripcion" class="form-control" placeholder="Descripción del producto" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-info"><i class="fa-solid fa-dollar-sign"></i></span>
                                        </div>
                                        <input type="text" id="precioCompra" name="precioCompra" class="form-control" placeholder="Precio de compra" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-info"><i class="fa-solid fa-trademark"></i></span>
                                        </div>
                                        <input type="text" id="txtMarca" name="txtMarca" class="form-control" placeholder="Marca" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-info"><i class="fa-regular fa-box-taped"></i></span>
                                        </div>
                                        <input type="text" id="txtTipo" name="txtTipo" class="form-control" placeholder="Tipo" readonly>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-info"><i class="fa-solid fa-circle-plus"></i></span>
                                        </div>
                                        <input type="number" class="form-control" id="txtCantidad" name="txtCantidad" placeholder="" disabled>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-info"><i class="fa-regular fa-hand-holding-dollar"></i></span>
                                        </div>
                                        <input type="text" id="subTotal" name="subTotal" class="form-control" placeholder="Sub-Total" readonly>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <h4 id="mensaje" class="div_mensaje"></h4>
                    </div>
                    <hr>
                    <div class="card-body">
                        <table class="table table-sm table-hover" width="100%">
                            <thead class="text-center thead-dark">
                                <tr>
                                    <th>CÓDIGO</th>
                                    <th>NOMBRE</th>
                                    <th>CANTIDAD</th>
                                    <th>PRECIO</th>
                                    <th>SUBTOTAL</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="tblDetalle" class="text-center">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadows">
                    <div class="card-header bg-info">
                        <h3 class="card-title">DETALLE DE LA COMPRA</h3>
                    </div>
                    <div class="card-body">

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php footerAdmin($data); ?>