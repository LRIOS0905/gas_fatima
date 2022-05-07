const formRol = document.getElementById("formRol");
const mensajeDiv = document.getElementById('mensaje');

let tableRoles;

document.addEventListener("DOMContentLoaded", function() {

    //! DATATABLES DE ROLES
    tableRoles = $("#tableRoles").dataTable({
        responsive: true,
        aProcessing: true,
        aServerSide: true,
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
        },
        ajax: {
            url: " " + base_url + "/Roles/getRoles",
            dataSrc: "",
        },
        columns: [
            { data: "idrol" },
            { data: "nombrerol" },
            { data: "descripcion" },
            { data: "status" },
            { data: "options" },
        ],
        bDestroy: true,
        iDisplayLength: 10,
        order: [
            [0, "desc"]
        ],
    });

    //NUEVO ROL
    formRol.addEventListener('submit', validarRol);

});

function validarRol(e) {
    e.preventDefault();
    const intIdRol = document.getElementById("idRol").value;
    const strNombre = document.getElementById("txtNombre").value;
    const strDescripcion = document.getElementById("txtDescripcion").value;
    const intStatus = document.getElementById("listStatus").value;

    const rol = {
        strNombre,
        strDescripcion,
        intStatus
    }
    validacionCampos('txtNombre', 'txtDescripcion');
    if (validar(rol)) {
        alertaMensaje('Todos los campos son obligatorios');
        return;
    }

    nuevoRol(rol);
}

const nuevoRol = async rol => {
    try {
        const formData = new FormData(formRol);
        const url = base_url + "/Roles/setRol"
        await fetch(url, {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(req => {
                if (req.status) {

                    formRol.reset();
                    Swal.fire("Roles de usuario", req.msg, "success")
                        .then(value => {
                            $('#modalFormRol').modal("hide");
                            tableRoles.api().ajax.reload(null, false);
                        })

                } else {
                    Swal.fire("Roles de usuario", req.msg, "success");
                }
            })
            .catch(error => {
                Swal.fire("Oops!", "Ocurrio un error en el Sistema, por favor intentalo de nuevo.", "error");
                console.log("Error: ", error)
            })
    } catch (error) {
        Swal.fire("Oops!", "Ocurrio un error en el Sistema, por favor intentalo de nuevo.", "error");
        console.log("Error: ", error)
    }

}

const fntEditRol = async(idrol) => {
    $('.form-control').removeClass('is-valid').removeClass('is-invalid');
    document.querySelector("#titleModal").innerHTML = "Actualizar Rol";
    document
        .querySelector(".modal-header")
        .classList.replace("headerRegister", "headerUpdate");
    document
        .querySelector("#btnActionForm")
        .classList.replace("btn-primary", "btn-info");
    document.querySelector("#btnText").innerHTML = "Actualizar";

    const url = base_url + "/Roles/getRol";

    try {
        await fetch(`${url}/${idrol}`, {
                method: "GET",
            })
            .then(res => res.json())
            .then(req => {
                if (req.status) {
                    const objRolEdit = req.data;
                    const { nombrerol, descripcion, idrol } = objRolEdit;

                    document.getElementById('idRol').value = idrol;
                    document.getElementById('txtNombre').value = nombrerol;
                    document.getElementById('txtDescripcion').value = descripcion;
                    if (req.data.status == 1) {
                        document.querySelector("#listStatus").value = 1;
                    } else {
                        document.querySelector("#listStatus").value = 2;

                    }
                    $("#modalFormRol").modal("show");
                }
            })
            .catch(error => {
                Swal.fire("Oops!", "Ocurrio un error en el Sistema, por favor intentalo de nuevo.", "error");
                console.log("Error: ", error)
            })
    } catch (error) {
        Swal.fire("Oops!", "Ocurrio un error en el Sistema, por favor intentalo de nuevo.", "error");
        console.log("Error: ", error)
    }
}

function fntDelRol(idrol) {
    swal.fire({
        title: 'Módulo Roles de Usuario?',
        text: "Seguro que desea eliminar el Rol!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, borrar!'
    }).then((result) => {
        if (result.isConfirmed) {
            const eliminarRol = async rol => {
                let url = base_url + "/Roles/delRol/";
                let strData = "idrol=" + idrol;
                try {
                    await fetch(`${url}`, {
                            method: 'POST',
                            body: strData,
                            headers: {
                                "Content-type": "application/x-www-form-urlencoded"
                            }
                        })
                        .then(res => res.json())
                        .then(req => {
                            if (req.status) {
                                Swal.fire("", req.msg, "success");
                                tableRoles.api().ajax.reload(null, false);
                            } else {
                                Swal.fire("Atención!", req.msg, "error");
                            }
                        })
                        .catch(error => {
                            Swal.fire("Oops!", "Ocurrio un error en el Sistema, por favor intentalo de nuevo.", "error");
                            console.log("Error: ", error)
                        })
                } catch (error) {
                    Swal.fire("Oops!", "Ocurrio un error en el Sistema, por favor intentalo de nuevo.", "error");
                    console.log("Error: ", error)
                }
            }
            eliminarRol();
        }
    });

}

function fntPermisos(idrol) {
    const url = base_url + "/Permisos/getPermisosRol";
    try {
        fetch(`${url}/${idrol}`, {
                method: 'GET',
            })
            .then(res => res.text())
            .then(req => {
                const permisos = document.querySelector("#contentAjax");
                permisos.innerHTML = req;
                $(".modalPermisos").modal("show");
                const formPermisos = document.getElementById('formPermisos');
                formPermisos.addEventListener('submit', fntSavePermisos);
            })
            .catch(error => {
                Swal.fire("Oops!", "Ocurrio un error en el Sistema, por favor intentalo de nuevo.", "error");
                console.log("Error: ", error)
            })
    } catch (error) {
        Swal.fire("Oops!", "Ocurrio un error en el Sistema, por favor intentalo de nuevo.", "error");
        console.log("Error: ", error)
    }

}

const fntSavePermisos = async e => {
    e.preventDefault();
    try {
        const formPermisos = document.getElementById('formPermisos');
        const url = base_url + "/Permisos/setPermisos";
        const formData = new FormData(formPermisos);

        await fetch(url, {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(req => {
                if (req.status) {
                    Swal.fire("Permisos de usuario", req.msg, "success");
                } else {
                    Swal.fire("Permisos de usuario", req.msg, "error");
                }
            })
    } catch (error) {
        Swal.fire("Oops!", "Ocurrio un error en el Sistema, por favor intentalo de nuevo.", "error");
        console.log("Error: ", error)
    }
}

function alertaMensaje(mensaje) {
    const alerta = document.querySelector('.alert-danger');
    if (!alerta) {
        const divMensaje = document.createElement('div');
        divMensaje.classList.add('alert', 'alert-danger', 'mb-3', 'text-center');
        divMensaje.innerHTML = mensaje;
        mensajeDiv.appendChild(divMensaje);

        setTimeout(() => {
            divMensaje.remove();
        }, 1500);
    }
}

const validacionCampos = (rol, descripcion) => {
    Boolean(document.getElementById(rol).value.length > 0) ?
        $('#' + rol).removeClass('is-invalid').addClass('is-valid') :
        $('#' + rol).removeClass('is-valid').addClass('is-invalid');

    Boolean(document.getElementById(descripcion).value.length > 0) ?
        $('#' + descripcion).removeClass('is-invalid').addClass('is-valid') :
        $('#' + descripcion).removeClass('is-valid').addClass('is-invalid');
}

function validar(obj) {
    return !Object.values(obj).every(input => input !== '');
}

function openModal() {
    $('.form-control').removeClass('is-valid').removeClass('is-invalid');
    document.querySelector("#idRol").value = "";
    document
        .querySelector(".modal-header")
        .classList.replace("headerUpdate", "headerRegister");
    document
        .querySelector("#btnActionForm")
        .classList.replace("btn-info", "btn-primary");
    document.querySelector("#btnText").innerHTML = "Guardar";
    document.querySelector("#formRol").reset();
    $("#modalFormRol").modal("show");
}