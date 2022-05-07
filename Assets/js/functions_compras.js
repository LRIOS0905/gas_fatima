let tableCompras;
let tableVerProveedor;
const cantProd = document.getElementById('txtCantidad');
const formulario = document.getElementById('formCompras');
const tblDetalle = document.getElementById("tblDetalle");
const buscarProveedor = document.getElementById('buscarProveedor');
const frmProveedor = document.getElementById('nuevoProveedor');

document.addEventListener('DOMContentLoaded', () => {
    listarVerProveedor();

    if (cantProd) {
        cantProd.addEventListener('keyup', insertarProducto)
    }

    $("#txtCodigo").change(function() {
        calcularSubtotal();
    });

    $("#txtCantidad").keyup(function() {
        calcularSubtotal();
    });

    $("#txtCantidad").change(function() {
        calcularSubtotal();
    });

    if (buscarProveedor) {
        buscarProveedor.addEventListener('click', modalProveedor);
    }

    if (frmProveedor) {
        frmProveedor.addEventListener('submit', validarProveedor);
    }

}, false)

const validarProveedor = e => {
    e.preventDefault();

    const proveedor = document.getElementById('txtProveedor').value;
    const telefono = document.getElementById('txtTelefono').value;
    const correo = document.getElementById('txtEmail').value;
    const direccion = document.getElementById('txtDireccion').value;
    const status = document.getElementById('listStatus').value;

    const prov = {
        proveedor,
        telefono,
        correo,
        direccion,
        status
    }

    validacionCampos('txtProveedor', 'txtTelefono', 'txtEmail', 'txtDireccion', 'listStatus');

    if (validar(prov)) {
        toastr["info"]("Todos los campos son obligatorios.", "Modulo proveedores");
        return;
    }
    crearProveedor(prov);
}

window.addEventListener('load', () => {
    buscarProducto();

    if (document.getElementById('tblDetalle')) {
        cargarDetalle();
    }
}, false)

const crearProveedor = async prov => {
    const url = base_url + '/Proveedores/setProveedor'
    const formData = new FormData(frmProveedor);
    try {
        await fetch(url, {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(datos => {
                if (datos.status) {
                    toastr[datos.icono](datos.msg, "Modulo proveedores");
                    $('.form-control').removeClass('is-valid').removeClass('is-invalid');
                    tableVerProveedor.ajax.reload(null, false);
                    frmProveedor.reset();
                } else {
                    toastr[datos.icono](datos.msg, "Modulo proveedores");
                }
            })
    } catch (error) {
        console.log(error);
    }



}

const buscarProducto = () => {
    $('#txtCodigo').autocomplete({
        minLength: 3,
        source: (req, res) => {
            $.ajax({
                url: base_url + '/Productos/buscarProductos',
                type: 'POST',
                dataType: 'json',
                data: {
                    codigo: req.term,
                    nombre: req.term,
                },
                success: data => {
                    res(data);
                    if (data == "") {
                        Swal.fire('', 'El codigo consultado no existe, intente con otro', 'error');
                        $("#txtCodigo").val("");
                        $("#txtCodigo").focus();
                    }
                }

            })
        },
        select: (event, ui) => {
            // $('#idCompra').val(ui.item.value);
            $('#idProducto').val(ui.item.value);
            $('#txtCodigo').val(ui.item.codigo);
            $('#txtDescripcion').val(ui.item.descripcion);
            $('#precioCompra').val(ui.item.precioCompra);
            $('#txtMarca').val(ui.item.marca);
            $('#txtTipo').val(ui.item.tipo);
            document.getElementById("txtCantidad").removeAttribute('disabled');
            $("#txtCantidad").focus();
            return false;
        }
    })
}

const calcularSubtotal = () => {
    const cantidad = document.getElementById('txtCantidad').value;
    const precio = document.getElementById('precioCompra').value
    document.getElementById('subTotal').value = precio * cantidad;
}

const insertarProducto = async(e) => {
    e.preventDefault();
    if (e.which == 13) {
        if (cantProd.value <= 0) {
            console.log('Debe ser mayor a 0.');
            return;
        } else {
            const url = base_url + '/Compras/setCompra'
            const formData = new FormData(formCompras);
            try {
                await fetch(url, {
                        method: 'POST',
                        body: formData
                    })
                    .then(res => res.json())
                    .then(datos => {
                        if (datos.status) {
                            console.log('Registro insertado con éxito.');
                            formulario.reset();
                            document.getElementById("txtCantidad").setAttribute('disabled', true);
                            $("#txtCodigo").focus();
                            cargarDetalle();
                        }
                    })
            } catch (error) {
                console.log(error);
            }
        }
    }
}

const cargarDetalle = detalle => {
    const url = base_url + '/Compras/listar';
    try {
        fetch(url, {
                method: 'GET',
            })
            .then(res => res.json())
            .then(datos => {
                if (datos) {
                    let html = "";
                    datos.detalle.forEach(row => {
                        html += `
                        <tr>
                        <td>${row['codigo']}</td>
                        <td>${row['descripcion']}</td>
                        <td>${row['cantidad']}</td>
                        <td>${row['precio']}</td>
                        <td>${row['sub_total']}</td>
                        <td><button class="btn btn-danger btn-xs" type="button" onclick="deleteDetalle(${row['id']})"><i class="fas fa-trash-alt"></i></button></td>
                        </tr>
                        `
                    })
                    tblDetalle.innerHTML = html;
                    //document.getElementById("totalPagar").value = datos.total_pagar.total;
                }
            })
    } catch (error) {
        console.log(error);
    }
}

const modalProveedor = proveedor => {
    $('.form-control').removeClass('is-valid').removeClass('is-invalid');
    frmProveedor.reset();
    $('#modalBuscarProveedor').modal('show');
}

const listarVerProveedor = () => {
    tableVerProveedor = $("#tableVerProveedor").DataTable({
        responsive: true,
        "pageLength": 10,
        "destroy": true,
        "bProcessing": true,
        "bDeferRender": true,
        "bServerSide": true,
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
        },
        "sAjaxSource": base_url + "/Controllers/Serverside/serverside_ver_proveedores.php",
        "columns": [
            { "defaultContent": "" },
            { "data": 1 },
            { "data": 2 },
            { "data": 3 },
            {
                "data": null,
                render: function(data, type, row) {
                    return `<button class="enviarProveedor btn btn-info btn-sm" ><i class="fa-solid fa-share-all"></i></button>`;
                }
            }
        ],
        columnDefs: [{
            className: "text-center",
            targets: [0]
        }, {
            className: "text-center",
            targets: [4]
        }, ],
        select: true,
        order: [
            [0, "desc"]
        ],
    });
    tableVerProveedor.on('draw.td', () => {
        const PageInfo = $('#tableVerProveedor').DataTable().page.info();
        tableVerProveedor.column(0, { page: 'current' }).nodes().each((cell, i) => {
            cell.innerHTML = i + 1 + PageInfo.start;
        });
    });
}

$('#tableVerProveedor').on('click', '.enviarProveedor', function() {
    let data = tableVerProveedor.row($(this).parents('tr')).data();
    if (tableVerProveedor.row(this).child.isShown()) {
        let data = tableVerProveedor.row(this).data();
    }
    $('#modalBuscarProveedor').modal('hide');
    document.getElementById('nombreProveedor').value = data[1];
    document.getElementById('telProveedor').value = data[2];
    document.getElementById('emailProveedor').value = data[3];
})

const validacionCampos = (prov, tel, correo, dir, estado) => {
    Boolean(document.getElementById(prov).value.length > 0) ?
        $('#' + prov).removeClass('is-invalid').addClass('is-valid') :
        $('#' + prov).removeClass('is-valid').addClass('is-invalid');

    Boolean(document.getElementById(tel).value.length > 0) ?
        $('#' + tel).removeClass('is-invalid').addClass('is-valid') :
        $('#' + tel).removeClass('is-valid').addClass('is-invalid');

    Boolean(document.getElementById(correo).value.length > 0) ?
        $('#' + correo).removeClass('is-invalid').addClass('is-valid') :
        $('#' + correo).removeClass('is-valid').addClass('is-invalid');

    Boolean(document.getElementById(dir).value.length > 0) ?
        $('#' + dir).removeClass('is-invalid').addClass('is-valid') :
        $('#' + dir).removeClass('is-valid').addClass('is-invalid');

    Boolean(document.getElementById(estado).value.length > 0) ?
        $('#' + estado).removeClass('is-invalid').addClass('is-valid') :
        $('#' + estado).removeClass('is-valid').addClass('is-invalid');
}

function validar(obj) {
    return !Object.values(obj).every(input => input !== '');
}