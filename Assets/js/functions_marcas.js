let tableMarcas;
const btnNuevo = document.getElementById('btnNuevo');
const mensajeDiv = document.getElementById('mensaje');
const formulario = document.getElementById('formMarca');
const foto = document.getElementById('foto');
const delPhoto = document.querySelector('.delPhoto');

document.addEventListener('DOMContentLoaded', () => {
    tableMarcas = $('#tableMarcas').DataTable({
        processing: true,
        responsive: true,
        aProcessing: true,
        aServerSide: true,
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
        },
        ajax: {
            url: " " + base_url + "/Marcas/getMarcas",
            dataSrc: "",
        },
        columns: [
            { data: "idmarca" },
            { data: "imagen" },
            { data: "nombre" },
            { data: "descripcion" },
            { data: "status" },
            { data: "options" },
        ],
        columnDefs: [{
                className: "textcenter",
                targets: [0]
            },
            {
                className: "textcenter",
                targets: [1]
            }, {
                className: "textcenter",
                targets: [2]
            },
            {
                className: "textcenter",
                targets: [4]
            },
            {
                className: "textcenter",
                targets: [5]
            }
        ],
        dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons: [{
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
            },
        ],
        resonsieve: "true",
        bDestroy: true,
        iDisplayLength: 10,
        order: [
            [0, "desc"]
        ]
    });

    btnNuevo.addEventListener('click', openModal);

    formMarca.addEventListener('submit', validarMarca);

    if (foto) {
        foto.onchange = function(e) {
            let uploadFoto = document.querySelector("#foto").value;
            let fileimg = document.querySelector("#foto").files;
            let nav = window.URL || window.webkitURL;
            let contactAlert = document.querySelector('#form_alert');
            if (uploadFoto != '') {
                let type = fileimg[0].type;
                let name = fileimg[0].name;
                if (type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png') {
                    contactAlert.innerHTML = '<p class="errorArchivo">El archivo no es válido.</p>';
                    if (document.querySelector('#img')) {
                        document.querySelector('#img').remove();
                    }
                    document.querySelector('.delPhoto').classList.add("notBlock");
                    foto.value = "";
                    return false;
                } else {
                    contactAlert.innerHTML = '';
                    if (document.querySelector('#img')) {
                        document.querySelector('#img').remove();
                    }
                    document.querySelector('.delPhoto').classList.remove("notBlock");
                    let objeto_url = nav.createObjectURL(this.files[0]);
                    document.querySelector('.prevPhoto div').innerHTML = "<img id='img' src=" + objeto_url + ">";
                }
            } else {
                alert("No selecciono foto");
                if (document.querySelector('#img')) {
                    document.querySelector('#img').remove();
                }
            }
        }
    }

    if (delPhoto) {
        delPhoto.onclick = function(e) {
            document.querySelector("#foto_remove").value = 1;
            removePhoto();
        }
    }
}, false)

const validarMarca = (e) => {
    e.preventDefault();
    const nombre = document.createElement('txtMarca').value;
    const descripcion = document.getElementById('txtDescripcion').value;
    const estado = document.getElementById('listStatus').value;

    const marca = {
        nombre,
        descripcion,
        estado,
    }

    if (validar(marca)) {
        alertaMensaje('Todos los campos son obligatorios');
        return;
    }

    insertarMarca(marca);
}

const insertarMarca = async marca => {
    const url = base_url + '/Marcas/setMarca';
    const formData = new FormData(formulario);
    try {
        await fetch(url, {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(result => guardarRegistro(result))
    } catch (error) {
        Swal.fire("Oops!", "Ocurrio un error en el Sistema, por favor intentalo de nuevo más tarde.", "error");
        console.log("Error: ", error)
    }
}

const guardarRegistro = marcas => {
    if (marcas.status) {
        Swal.fire('', marcas.msg, marcas.icono);
        $('#modalFormMarca').modal('hide');
        formulario.reset();
        tableMarcas.ajax.reload(null, false);
    } else {
        Swal.fire('', marcas.msg, marcas.icono)
    }
}

const fntViewInfo = async id => {
    const url = base_url + "/Marcas/getMarca/" + id;
    try {
        await fetch(url, {
                method: 'GET',
            })
            .then(res => res.json())
            .then(result => result.data)
            .then(marcas => viewMarcas(marcas))
    } catch (error) {
        Swal.fire("Oops!", "Ocurrio un error en el Sistema, por favor intentalo de nuevo más tarde.", "error");
        console.log("Error: ", error)
    }
}

const viewMarcas = marcas => {
    const { idmarca, nombre, descripcion, status, url_portada } = marcas;
    const estado = status == 1 ?
        '<span class="badge badge-success">Activo</span>' :
        '<span class="badge badge-danger">Inactivo</span>';
    document.querySelector('#celId').innerHTML = idmarca;
    document.querySelector('#celNombre').innerHTML = nombre;
    document.querySelector('#celDescripcion').innerHTML = descripcion;
    document.querySelector('#celEstado').innerHTML = estado;
    document.querySelector("#imgMarca").innerHTML = '<img src="' + url_portada + '"></img>';
    $('#modalViewMarca').modal('show');
}

const fntEditInfo = async id => {
    const url = base_url + "/Marcas/getMarca/" + id;
    try {
        await fetch(url, {
                method: 'GET',
            })
            .then(res => res.json())
            .then(result => result.data)
            .then(marcas => editInfo(marcas))
    } catch (error) {
        Swal.fire("Oops!", "Ocurrio un error en el Sistema, por favor intentalo de nuevo más tarde.", "error");
        console.log("Error: ", error)
    }
}

const editInfo = marcas => {
    document.querySelector("#titleModal").innerHTML = "Actualizar Marca";
    document.querySelector(".modal-header").classList.replace("headerRegister", "headerUpdate");
    document.querySelector("#btnActionForm").classList.replace("btn-primary", "btn-info");
    document.querySelector("#btnText").innerHTML = "Actualizar";

    const { idmarca, nombre, descripcion, status, portada, url_portada } = marcas;

    document.getElementById('idMarca').value = idmarca;
    document.getElementById('txtMarca').value = nombre;
    document.getElementById('txtDescripcion').value = descripcion;
    document.querySelector('#foto_actual').value = portada;
    document.querySelector("#foto_remove").value = 0;
    document.getElementById('listStatus').value = status;

    if (document.getElementById('#img')) {
        document.getElementById('#img').src = url_portada;
    } else {
        document.querySelector('.prevPhoto div').innerHTML = "<img id='img' src=" + url_portada + ">";
    }

    if (portada == 'portada_marca.png') {
        document.querySelector('.delPhoto').classList.add("notBlock");
    } else {
        document.querySelector('.delPhoto').classList.remove("notBlock");
    }

    $('#modalFormMarca').modal('show');
}

const fntDelInfo = async id => {
    Swal.fire({
        title: 'Está seguro de eliminar la Marca?',
        text: "",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, borrar!'
    }).then((result) => {
        if (result.isConfirmed) {
            const eliminarMarca = async marca => {
                const url = base_url + "/Marcas/delMarca/";
                let strData = "idMarca=" + id;
                try {
                    await fetch(`${url}`, {
                            method: 'POST',
                            body: strData,
                            headers: {
                                "Content-type": "application/x-www-form-urlencoded"
                            }
                        })
                        .then(response => response.json())
                        .then(marcas => eliminarInfo(marcas))
                } catch (error) {
                    console.log("Error: ", error)
                }
            }
            eliminarMarca();
        }
    });
}

const eliminarInfo = marcas => {
    if (marcas.status) {
        Swal.fire("", marcas.msg, marcas.icono);
        tableMarcas.ajax.reload(null, false);
    } else if (marcas === "exist") {
        Swal.fire("", marcas.msg, marcas.icono);
    } else {
        Swal.fire("", marcas.msg, marcas.icono);
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

const removePhoto = () => {
    document.querySelector('#foto').value = "";
    document.querySelector('.delPhoto').classList.add("notBlock");
    if (document.querySelector('#img')) {
        document.querySelector('#img').remove();
    }
}

const openModal = () => {
    document.querySelector("#idMarca").value = "";
    document.querySelector(".modal-header").classList.replace("headerUpdate", "headerRegister");
    document.querySelector("#btnActionForm").classList.replace("btn-info", "btn-primary");
    document.querySelector("#btnText").textContent = "Guardar";
    document.querySelector("#titleModal").innerHTML = "Nueva Marca";
    formulario.reset();
    $('#modalFormMarca').modal('show');
    removePhoto();
}