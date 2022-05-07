<?php
headerAdmin($data);
getModal("modalMarcas", $data);
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="callout callout-info text-center">
            <h1><?= $data['page_title'] ?></h1>
        </div>
    </section>

    <section class="content">    
        <div class="card">
            <div class="card-header">
                <?php if ($_SESSION['permisosMod']['w']) { ?>
                    <button class="btn btn-success" type="button" id="btnNuevo"><i class="fas fa-plus-circle"></i> Nuevo</button>
                <?php } ?>
            </div>
            <div class="card-body">
                <table id="tableMarcas" class="table table-bordered table-hover dataTable dtr-inline" width="100%">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>IMAGEN</th>
                            <th>MARCA</th>
                            <th>DESCRIPCION</th>
                            <th>ESTADO</th>
                            <th>OPCIONES</th>
                        </tr>
                    </thead>
                    <tbody class="table-font">
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>


<?php
footerAdmin($data);

?>