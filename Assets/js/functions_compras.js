const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    iconColor: 'white',
    showConfirmButton: false,
    timer: 1500,
    animation: true,
    customClass: {
        popup: 'colored-toast'
    },
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})

let tableCompras;
let tableVerProveedor;
const cantProd = document.getElementById('txtCantidad');
const formulario = document.getElementById('formCompras');
const tblDetalle = document.getElementById("tblDetalle");
const buscarProveedor = document.getElementById('buscarProveedor');
const frmProveedor = document.getElementById('nuevoProveedor');
const mensajeDiv = document.getElementById('mensaje');
const btnGenerarCompra = document.getElementById('generarCompra');

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

    if (tblDetalle) {
        cargarDetalle();
    }

    if (btnGenerarCompra) {
        btnGenerarCompra.addEventListener('click', validarCompra);
    }

}, false)

const validarCompra = compra => {
    const proveedorInput = document.getElementById('nombreProveedor').value;
    const telefonoInput = document.getElementById('telProveedor').value;
    const emailInput = document.getElementById('emailProveedor').value;

    if (tblDetalle.textContent == '') {
        Swal.fire('Datos de la compra!', 'Aún no cuenta con productos para generar la compra', 'info')
        return;
    }

    if (proveedorInput === '' || telefonoInput === '' || emailInput === '') {
        Swal.fire('Datos del proveedor!', 'Antes de generar la compra debe ingresar el proveedor', 'warning')
        return;
    }

    generarCompra();
}

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
                    Swal.fire({
                        position: 'top-end',
                        icon: datos.icono,
                        title: datos.msg,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('.form-control').removeClass('is-valid').removeClass('is-invalid');
                    tableVerProveedor.ajax.reload(null, false);
                    frmProveedor.reset();
                } else {
                    Swal.fire({
                        position: 'top-end',
                        icon: datos.icono,
                        title: datos.msg,
                        showConfirmButton: false,
                        timer: 1500
                    });
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
                            alertasToast(datos.msg, datos.icono);
                            formulario.reset();
                            document.getElementById("txtCantidad").setAttribute('disabled', true);
                            $("#txtCodigo").focus();
                            cargarDetalle();
                        } else {
                            alertasToast(datos.msg, datos.icono);
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
                        if (row['id_producto'] == "") {
                            html += `hhhhhh`;
                        } else {
                            html += `
                            <tr>
                            <td>${row['codigo']}</td>
                            <td>${row['descripcion']}</td>
                            <td>${row['cantidad']}</td>
                            <td>${row['precio']}</td>
                            <td>${number_format(row['sub_total'], 2)}</td>
                            <td><button class="btn btn-danger btn-xs" type="button" onclick="deleteDetalle(${row['id']})"><i class="fas fa-trash-alt"></i></button></td>
                            </tr>
                            `
                        }
                    })
                    tblDetalle.innerHTML = html;

                    document.getElementById('iva').textContent = `IVA ${datos.impuesto.impuesto} %`;

                    let antes_impuesto = datos.total_pagar.total;
                    document.getElementById("sub_total").value = number_format(antes_impuesto, 2);

                    let impuesto = datos.impuesto.impuesto / 100;

                    let total_impuesto = antes_impuesto * impuesto;
                    document.getElementById("total_impuesto").value = number_format(total_impuesto, 2);

                    let gran_total = parseFloat(antes_impuesto) + parseFloat(total_impuesto);
                    document.getElementById("gran_total").value = number_format(gran_total, 2);
                }
            })
    } catch (error) {
        console.log(error);
    }
}

const deleteDetalle = async(id) => {
    limpiarHtml()
    const url = base_url + "/Compras/deteleCompra/" + id;
    try {
        await fetch(url, {
                method: 'GET'
            })
            .then(res => res.json())
            .then(datos => {
                if (datos.status) {
                    alertasToast(datos.msg, datos.icono)
                    cargarDetalle();
                    document.getElementById('txtCodigo').focus();
                } else {
                    alertasToast(datos.msg, datos.icono)
                }
            })
    } catch (error) {
        console.log(error);
    }
}

const generarCompra = compra => {
    Swal.fire({
        title: 'Seguro de generar la compra?',
        text: "Verifique que los datos son correctos!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, generar!'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + '/Compras/generarCompra'
            const proveedorId = document.getElementById('idProveedor').value;
            const productoId = document.getElementById('idProducto').value;
            const proveedorInput = document.getElementById('nombreProveedor').value;
            const telefonoInput = document.getElementById('telProveedor').value;
            const emailInput = document.getElementById('emailProveedor').value;
            const sub_total = document.getElementById('sub_total').value;
            const impuesto = document.getElementById('total_impuesto').value;
            const gran_total = document.getElementById('gran_total').value;

            const formData = new FormData();
            formData.append('idProducto', productoId);
            formData.append('idProveedor', proveedorId);
            formData.append('nombreProveedor', proveedorInput);
            formData.append('telProveedor', telefonoInput);
            formData.append('emailProveedor', emailInput);
            formData.append('sub_total', sub_total);
            formData.append('impuesto', impuesto);
            formData.append('gran_total', gran_total)
            try {
                fetch(url, {
                        method: 'POST',
                        body: formData,
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status) {
                            Swal.fire('Mensaje de confirmación!', data.msg, data.icono);
                            formulario.reset();
                            cargarDetalle();
                        }
                    })

            } catch (error) {
                console.log(error);
            }
        }
    })
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
    document.getElementById('idProveedor').value = data[0];
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

const number_format = (amount, decimals) => {

    amount += ''; // por si pasan un numero en vez de un string
    amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto

    decimals = decimals || 0; // por si la variable no fue fue pasada

    // si no es un numero o es igual a cero retorno el mismo cero
    if (isNaN(amount) || amount === 0)
        return parseFloat(0).toFixed(decimals);

    // si es mayor o menor que cero retorno el valor formateado como numero
    amount = '' + amount.toFixed(decimals);

    var amount_parts = amount.split('.'),
        regexp = /(\d+)(\d{3})/;

    while (regexp.test(amount_parts[0]))
        amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');

    return amount_parts.join('.');
}

const alertasToast = (mensaje, icono) => {
    Toast.fire({
        icon: icono,
        title: mensaje,
    });
}

const alertaGeneral = (mensaje, tipo) => {
    const alerta = document.querySelector('.alert-success');

    if (!alerta) {
        const divMensaje = document.createElement('div');
        divMensaje.classList.add('alert', 'text-center');

        if (tipo == 'success') {
            divMensaje.classList.add('alert-success');
        } else if (tipo == 'info') {
            divMensaje.classList.add('alert-info');
        } else {
            divMensaje.classList.add('alert-danger');
        }

        divMensaje.textContent = mensaje;
        mensajeDiv.appendChild(divMensaje);

        setTimeout(() => {
            divMensaje.remove();
        }, 1000);
    }
}

const limpiarHtml = () => {
    while (mensajeDiv.firstChild) {
        mensajeDiv.removeChild(mensajeDiv.firstChild);
    }
};

function validar(obj) {
    return !Object.values(obj).every(input => input !== '');
}