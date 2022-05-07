let tableProductos;
const btnNuevo = document.getElementById("btnNuevo");
const formulario = document.getElementById("formProductos");
const mensajeDiv = document.getElementById("mensaje");
const listMarca = document.getElementById('listMarca');
const listTipo = document.getElementById('listTipo');

document.addEventListener('DOMContentLoaded', () => {
    const buttons = [{
            extend: "copyHtml5",
            text: "<i class='far fa-copy'></i> Copiar",
            titleAttr: "Copiar",
            className: "btn btn-secondary",
        },
        {
            extend: "excelHtml5",
            text: "<i class='fas fa-file-excel'></i> Excel",
            titleAttr: "Esportar a Excel",
            className: "btn btn-success",
        },
        {
            extend: "pdfHtml5",
            text: "<i class='fas fa-file-pdf'></i> PDF",
            titleAttr: "Esportar a PDF",
            className: "btn btn-danger",
        },
        {
            extend: "csvHtml5",
            text: "<i class='fas fa-file-csv'></i> CSV",
            titleAttr: "Esportar a CSV",
            className: "btn btn-info",
        }
    ]

    const dom = "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-5'i><'col-sm-7'p>>";

    tableProductos = $('#tableProductos').DataTable({
        processing: true,
        responsive: true,
        aProcessing: true,
        aServerSide: true,
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
        },
        ajax: {
            url: " " + base_url + "/Productos/getProductos",
            dataSrc: "",
        },
        columns: [
            { data: "id_producto" },
            { data: "codigo" },
            { data: "descripcion" },
            { data: "precio_compra" },
            { data: "precio_venta" },
            { data: "stock" },
            { data: "marca" },
            { data: "tipo" },
            { data: "status" },
            { data: "options" }
        ],
        columnDefs: [{
                className: "textcenter",
                targets: [0]
            },
            {
                className: "textcenter",
                targets: [1]
            },
            {
                className: "textcenter",
                targets: [5]
            },
            {
                className: "textcenter",
                targets: [6]
            },
            {
                className: "textcenter",
                targets: [7]
            },
            {
                targets: 3,
                visible: false,
            },
            {
                targets: 4,
                visible: false,
            },
            {
                targets: 8,
                visible: false,
            }
        ],
        dom,
        buttons,
        resonsieve: "true",
        bDestroy: true,
        iDisplayLength: 10,
        order: [
            [0, "desc"]
        ]
    });

    btnNuevo.addEventListener('click', openModal);

    formulario.addEventListener('submit', validarProducto);

}, false);

const validarProducto = e => {
    e.preventDefault();
    const codigo = document.getElementById('txtCodigo').value;
    const descripcion = document.getElementById('txtDescripcion').value;
    const precio_compra = document.getElementById('precioCompra').value;
    const precio_venta = document.getElementById('precioVenta').value;
    const stock = document.getElementById('stock').value;
    const marca = document.getElementById('listMarca').value;
    const tipo = document.getElementById('listTipo').value;
    const estado = document.getElementById('listStatus').value;


    const productos = {
        codigo,
        descripcion,
        precio_compra,
        precio_venta,
        stock,
        marca,
        tipo,
        estado
    }

    if (validar(productos)) {
        alertaMensaje('Todos los campos son obligatorios');
        return;
    }

    registrarProducto(productos);
}

const registrarProducto = async productos => {
    const url = base_url + '/Productos/setProducto'
    const formData = new FormData(formulario);
    try {
        await fetch(url, {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.status) {
                    $('#modalFormProductos').modal('hide');
                    formulario.reset();
                    Swal.fire('', data.msg, data.icono);
                    tableProductos.ajax.reload(null, false);
                } else if (data == "exist") {
                    Swal.fire('', data.msg, data.icono);
                } else {
                    Swal.fire('', data.msg, data.icono);
                }
            })
    } catch (error) {
        console.log(error);
    }
}

const fntViewInfo = async id => {
    const url = base_url + '/Productos/getProducto/' + id
    try {
        await fetch(url, {
                method: 'GET',
            })
            .then(res => res.json())
            .then(result => result.data)
            .then(productos => verProducto(productos))
    } catch (error) {
        console.log(error);
    }
}

const verProducto = productos => {
    if (productos.status) {
        const { id_producto, codigo, descripcion, precio_compra, precio_venta, stock, marca, tipo, status } = productos;
        const estado = status == 1 ?
            '<span class="badge badge-success">Activo</span>' :
            '<span class="badge badge-danger">Inactivo</span>';
        document.getElementById('celId').innerHTML = id_producto;
        document.getElementById('celCodigo').innerHTML = codigo;
        document.getElementById('celDescripcion').innerHTML = descripcion;
        document.getElementById('celPrecioCompra').innerHTML = precio_compra;
        document.getElementById('celPrecioVenta').innerHTML = precio_venta;
        document.getElementById('celStock').innerHTML = stock;
        document.getElementById('celMarca').innerHTML = marca;
        document.getElementById('celTipo').innerHTML = tipo;
        document.getElementById('celEstado').innerHTML = estado;

        $('#modalViewProducto').modal('show');
    }
}

const fntEditInfo = async id => {
    const url = base_url + "/Productos/getProducto/" + id;
    try {
        await fetch(url, {
                method: 'GET',
            })
            .then(res => res.json())
            .then(result => result.data)
            .then(productos => editProducto(productos))
    } catch (error) {
        console.log(error);
    }
}

const editProducto = productos => {
    document.getElementById("titleModal").innerHTML = "Actualizar Producto";
    document.querySelector(".modal-header").classList.replace("headerRegister", "headerUpdate");
    document.getElementById("btnActionForm").classList.replace("btn-primary", "btn-info");
    document.getElementById("btnText").innerHTML = "Actualizar";
    document.getElementById('txtCodigo').setAttribute("readonly", "true");
    if (productos.status) {
        const { id_producto, codigo, descripcion, precio_compra, precio_venta, stock, marca_id, tipo_id, status } = productos;

        document.getElementById("idProducto").value = id_producto;
        document.getElementById('txtCodigo').value = codigo;
        document.getElementById('txtDescripcion').value = descripcion;
        document.getElementById('precioCompra').value = precio_compra;
        document.getElementById('precioVenta').value = precio_venta;
        document.getElementById('stock').value = stock;
        document.getElementById('listMarca').value = marca_id;
        document.getElementById('listTipo').value = tipo_id;
        document.getElementById('listStatus').value = status;

        $('#modalFormProductos').modal('show');
    }
}

const fntDelInfo = id => {
    Swal.fire({
        title: 'Está seguro de eliminar el registro?',
        text: "",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, borrar!'
    }).then((result) => {
        if (result.isConfirmed) {
            const eliminarProducto = async producto => {
                const url = base_url + "/Productos/delProducto/";
                let strData = "idProducto=" + id;
                try {
                    await fetch(`${url}`, {
                            method: 'POST',
                            body: strData,
                            headers: {
                                "Content-type": "application/x-www-form-urlencoded"
                            }
                        })
                        .then(response => response.json())
                        .then(productos => eliminarInfo(productos))
                } catch (error) {
                    console.log("Error: ", error)
                }
            }
            eliminarProducto();
        }
    });
}

const eliminarInfo = productos => {
    if (productos.status) {
        Swal.fire('', productos.msg, productos.icono);
        tableProductos.ajax.reload(null, false);
    } else {
        Swal.fire('', productos.msg, productos.icono);
    }
}

const fntMarcas = async marcas => {
    if (listMarca) {
        const url = base_url + "/Marcas/getSelectMarcas"
        try {
            await fetch(url, {
                    method: 'GET',
                })
                .then(response => response.json())
                .then(req => {
                    listMarca.innerHTML = req;
                })
        } catch (error) {
            console.log(error);
        }
    }
}

const fntTipos = async tipos => {
    if (listTipo) {
        const url = base_url + "/Tipos/getSelectTipos"
        try {
            await fetch(url, {
                    method: 'GET',
                })
                .then(response => response.json())
                .then(req => {
                    listTipo.innerHTML = req;
                })
        } catch (error) {
            console.log(error);
        }
    }
}

window.addEventListener(
    "load",
    function() {
        fntMarcas();
        fntTipos();
    },
    false
);

const alertaMensaje = mensaje => {
    const alerta = document.querySelector('.alert-danger');
    if (!alerta) {
        const divMensaje = document.createElement('div');
        divMensaje.classList.add('alert', 'alert-danger', 'mb-3', 'text-center');
        divMensaje.innerHTML = `<i class="fa-solid fa-brake-warning"></i> ${mensaje}`;
        mensajeDiv.appendChild(divMensaje);
        setTimeout(() => {
            divMensaje.remove();
        }, 1500);
    }
}

const validar = obj => {
    return !Object.values(obj).every(input => input !== '');
}

const openModal = () => {
    document.getElementById("idProducto").value = "";
    document.querySelector(".modal-header").classList.replace("headerUpdate", "headerRegister");
    document.getElementById("btnActionForm").classList.replace("btn-info", "btn-primary");
    document.getElementById("btnText").textContent = "Guardar";
    document.getElementById("titleModal").innerHTML = "Nuevo Producto";
    document.getElementById('txtCodigo').removeAttribute("readonly", "true");
    formulario.reset();
    $('#modalFormProductos').modal('show');
}