let tableTipos;
const btnNuevo = document.getElementById('btnNuevo');
const formulario = document.getElementById('formTipo');
const mensajeDiv = document.getElementById('mensaje');

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

    tableTipos = $('#tableTipos').DataTable({
        processing: true,
        responsive: true,
        aProcessing: true,
        aServerSide: true,
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
        },
        ajax: {
            url: " " + base_url + "/Tipos/getTipos",
            dataSrc: "",
        },
        columns: [
            { data: "id_tipo" },
            { data: "nombre" },
            { data: "status" },
            { data: "options" }
        ],
        columnDefs: [{
                className: "textcenter",
                targets: [0]
            },
            {
                className: "textcenter",
                targets: [2]
            },
            {
                className: "textcenter",
                targets: [3]
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
    })

    btnNuevo.addEventListener('click', openModal);

    formulario.addEventListener('submit', validarTipo);

}, false);

const validarTipo = e => {
    e.preventDefault();

    const tipo = document.getElementById('txtTipo').value;
    const estado = document.getElementById('listStatus').value;

    const tipos = {
        tipo,
        estado
    }

    if (validar(tipos)) {
        alertaMensaje('Todos los campos son obligatorios');
        return;
    }

    crearTipo(tipos);
}

const crearTipo = async tipos => {
    const url = base_url + '/Tipos/setTipo'
    formData = new FormData(formulario);
    try {
        await fetch(url, {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(datos => {
                if (datos.status) {
                    $('#modalFormTipo').modal('hide');
                    Swal.fire('Módulo Tipos', datos.msg, datos.icono);
                    formulario.reset();
                    tableTipos.ajax.reload(null, false);
                } else {
                    Swal.fire('Módulo Tipos', datos.msg, datos.icono);
                }
            })
    } catch (error) {
        Swal.fire("Oops!", "Ocurrio un error en el Sistema, por favor intentalo de nuevo.", "error");
        console.log("Error: ", error)
    }
}

const fntEditInfo = async id => {
    const url = base_url + '/Tipos/getTipo/' + id;
    try {
        await fetch(url, {
                method: 'GET',
            })
            .then(res => res.json())
            .then(result => result.data)
            .then(datos => editInfo(datos))
    } catch (error) {
        Swal.fire("Oops!", "Ocurrio un error en el Sistema, por favor intentalo de nuevo.", "error");
        console.log("Error: ", error)
    }
}

const editInfo = datos => {
    document.querySelector("#titleModal").innerHTML = "Actualizar Tipo";
    document.querySelector(".modal-header").classList.replace("headerRegister", "headerUpdate");
    document.querySelector("#btnActionForm").classList.replace("btn-primary", "btn-info");
    document.querySelector("#btnText").innerHTML = "Actualizar";

    if (datos.status) {
        const { id_tipo, nombre, status } = datos;

        document.getElementById('idTipo').value = id_tipo;
        document.getElementById('txtTipo').value = nombre;
        document.getElementById('listStatus').value = status;

        $('#modalFormTipo').modal('show');
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
            const eliminarTipo = async tipo => {
                const url = base_url + "/Tipos/delTipo/";
                let strData = "idTipo=" + id;
                try {
                    await fetch(`${url}`, {
                            method: 'POST',
                            body: strData,
                            headers: {
                                "Content-type": "application/x-www-form-urlencoded"
                            }
                        })
                        .then(response => response.json())
                        .then(tipos => eliminarInfo(tipos))
                } catch (error) {
                    console.log("Error: ", error)
                }
            }
            eliminarTipo();
        }
    });
}

const eliminarInfo = tipos => {
    if (tipos.status) {
        Swal.fire('', tipos.msg, tipos.icono);
        tableTipos.ajax.reload(null, false);
    } else if (tipos === "exist") {
        Swal.fire('', tipos.msg, tipos.icono);
    } else {
        Swal.fire('', tipos.msg, tipos.icono);
    }
}

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
    document.querySelector("#idTipo").value = "";
    document.querySelector(".modal-header").classList.replace("headerUpdate", "headerRegister");
    document.querySelector("#btnActionForm").classList.replace("btn-info", "btn-primary");
    document.querySelector("#btnText").textContent = "Guardar";
    document.querySelector("#titleModal").innerHTML = "Nuevo Tipo";
    formulario.reset();
    $('#modalFormTipo').modal('show');
}