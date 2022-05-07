let tableClientes;
const btnNuevo = document.getElementById('btnNuevo');
const mensajeDiv = document.getElementById('mensaje');
const formulario = document.getElementById('formClientes');
const listMarca = document.getElementById('listMarca');
const listTipo = document.getElementById('listTipo');


document.addEventListener('DOMContentLoaded', () => {
    $('#listMarca').select2({
        dropdownParent: $('#modalFormClientes'),
        placeholder: 'Select an option'
    });
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

    tableClientes = $('#tableClientes').DataTable({
        processing: true,
        responsive: true,
        aProcessing: true,
        aServerSide: true,
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
        },
        ajax: {
            url: " " + base_url + "/Clientes/getClientes",
            dataSrc: "",
        },
        columns: [
            { data: "id_cliente" },
            { data: "codigo" },
            { data: "nombre" },
            { data: "telefono" },
            { data: "direccion" },
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
                targets: 6,
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

    formulario.addEventListener('submit', validarCliente);

}, false)

const validarCliente = e => {
    e.preventDefault();
    const codigo = document.getElementById('txtCodigo').value;
    const nombre = document.getElementById('txtNombre').value;
    const telefono = document.getElementById('txtTelefono').value;
    const direccion = document.getElementById('txtDireccion').value;
    const marca = document.getElementById('listMarca').value;
    const tipo = document.getElementById('listTipo').value;
    const status = document.getElementById('listStatus').value;

    const clientes = {
        codigo,
        nombre,
        telefono,
        direccion,
        marca,
        tipo,
        status
    }

    if (validar(clientes)) {
        alertaMensaje('Todos los campos son obligatorios');
        return;
    }

    registrarCliente(clientes);

}

const registrarCliente = async clientes => {
    const url = base_url + '/Clientes/setCliente'
    const formData = new FormData(formulario);
    try {
        await fetch(url, {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(datos => {
                if (datos.status) {
                    $('#modalFormClientes').modal('hide');
                    Swal.fire('', datos.msg, datos.icono);
                    formulario.reset();
                    tableClientes.ajax.reload(null, false);
                } else {
                    Swal.fire('', datos.msg, datos.icono);
                }
            })
    } catch (error) {
        console.log(error);
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

const fntViewInfo = async id => {
    const url = base_url + '/Clientes/getCliente/' + id
    try {
        await fetch(url, {
                method: 'GET',
            })
            .then(res => res.json())
            .then(result => result.data)
            .then(clientes => verCliente(clientes))
    } catch (error) {
        console.log(error);
    }
}

const verCliente = clientes => {
    if (clientes.status) {
        const { id_cliente, codigo, nombre, telefono, direccion, marca, tipo, status } = clientes;
        const estado = status == 1 ?
            '<span class="badge badge-success">Activo</span>' :
            '<span class="badge badge-danger">Inactivo</span>';
        document.getElementById('celId').innerHTML = id_cliente;
        document.getElementById('celCodigo').innerHTML = codigo;
        document.getElementById('celNombre').innerHTML = nombre;
        document.getElementById('celTelefono').innerHTML = telefono;
        document.getElementById('celDireccion').innerHTML = direccion;
        document.getElementById('celMarca').innerHTML = marca;
        document.getElementById('celTipo').innerHTML = tipo;
        document.getElementById('celEstado').innerHTML = estado;

        $('#modalViewCliente').modal('show');
    }
}

const fntEditInfo = async id => {
    const url = base_url + '/Clientes/getCliente/' + id;
    try {
        await fetch(url, {
                method: 'GET',
            })
            .then(res => res.json())
            .then(result => result.data)
            .then(editCliente => editarCliente(editCliente))
    } catch (error) {
        console.log(error);
    }
}

const editarCliente = editCliente => {
    document.getElementById("titleModal").innerHTML = "Actualizar Cliente";
    document.querySelector(".modal-header").classList.replace("headerRegister", "headerUpdate");
    document.getElementById("btnActionForm").classList.replace("btn-primary", "btn-info");
    document.getElementById("btnText").innerHTML = "Actualizar";
    document.getElementById("txtCodigo").setAttribute("readonly", "readonly");
    if (editCliente.status) {
        const { id_cliente, codigo, nombre, telefono, direccion, marca_id, tipo_id, status } = editCliente;

        document.getElementById('idCliente').value = id_cliente;
        document.getElementById('txtCodigo').value = codigo;
        document.getElementById('txtNombre').value = nombre;
        document.getElementById('txtTelefono').value = telefono;
        document.getElementById('txtDireccion').value = direccion;
        document.getElementById('listMarca').value = marca_id;
        document.getElementById('listTipo').value = tipo_id;
        document.getElementById('listStatus').value = status;

        $('#modalFormClientes').modal('show');
    } else {
        Swa.fire('', editCliente.msg, editCliente.icono);
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
            const eliminarCliente = async cliente => {
                const url = base_url + "/Clientes/delCliente/";
                let strData = "idCliente=" + id;
                try {
                    await fetch(`${url}`, {
                            method: 'POST',
                            body: strData,
                            headers: {
                                "Content-type": "application/x-www-form-urlencoded"
                            }
                        })
                        .then(response => response.json())
                        .then(clientes => eliminarInfo(clientes))
                } catch (error) {
                    console.log("Error: ", error)
                }
            }
            eliminarCliente();
        }
    });
}

const eliminarInfo = clientes => {
    if (clientes.status) {
        Swal.fire('', clientes.msg, clientes.icono);
        tableClientes.ajax.reload(null, false);
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
    document.getElementById("idCliente").value = "";
    document.querySelector(".modal-header").classList.replace("headerUpdate", "headerRegister");
    document.getElementById("btnActionForm").classList.replace("btn-info", "btn-primary");
    document.getElementById("btnText").textContent = "Guardar";
    document.getElementById("titleModal").innerHTML = "Nuevo Cliente";
    document.getElementById("txtCodigo").removeAttribute("readonly", "readonly");
    formulario.reset();
    $('#modalFormClientes').modal('show');
}