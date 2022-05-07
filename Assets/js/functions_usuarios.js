const formUsuario = document.querySelector("#formUsuario");
const formPerfil = document.getElementById("formPerfil")
const formDatosFiscal = document.getElementById('formDatosFiscal')
let tableUsuarios;
//let rowTable = "";

//ESTO RECARGA TODA LA VISTA DEL HTML
document.addEventListener(
    "DOMContentLoaded",
    function() {
        //listarUsuarios();

        listarUsuariosServerSide();

        //formUsuario.addEventListener("submit", validarUsuario);
        if (formUsuario) {
            formUsuario.addEventListener("submit", validarUsuario);
        }

        //Actualizar perfil de usuario
        if (formPerfil) {
            formPerfil.addEventListener('submit', validarPerfil);
        }

        //Actualizar datos fiscales
        if (formDatosFiscal) {
            formDatosFiscal.addEventListener('submit', validarFiscal);
        }
    },
    false
);

function validarUsuario(e) {
    e.preventDefault();
    let strIdentificacion = document.querySelector("#txtIdentificacion").value;
    let strNombre = document.querySelector("#txtNombre").value;
    let strApellido = document.querySelector("#txtApellido").value;
    let strEmail = document.querySelector("#txtEmail").value;
    let intTelefono = document.querySelector("#txtTelefono").value;
    let intTipoUsuario = document.querySelector("#listRolid").value;
    let intStatus = document.querySelector("#listStatus").value;

    const usuario = {
        strIdentificacion,
        strNombre,
        strApellido,
        strEmail,
        intTelefono,
        intTipoUsuario,
        intStatus
    }

    let elementsValid = document.getElementsByClassName("valid");
    for (let i = 0; i < elementsValid.length; i++) {
        if (elementsValid[i].classList.contains("is-invalid")) {
            Swal.fire(
                "Atención!",
                "Por favor verifique los campos en rojo!",
                "error"
            );
            return false;
        }
    }

    if (validar(usuario)) {
        Swal.fire(
            "",
            "Todos los campos son obligatorios!",
            "info"
        );
        return;
    }

    nuevoUsuario(usuario);
}

function validar(obj) {
    return !Object.values(obj).every(input => input !== '');
}

const nuevoUsuario = async usuario => {
    let formData = new FormData(formUsuario);
    let url = base_url + '/Usuarios/setUsuario';
    try {
        await fetch(url, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(objData => {
                if (objData.status) {
                    $('#modalFormUsuario').modal("hide");
                    formUsuario.reset();
                    tableUsuarios.ajax.reload(null, false);
                    Swal.fire("", objData.msg, "success");
                } else {
                    Swal.fire("Error", objData.msg, "error");
                }
            })
            .catch(error => {
                Swal.fire("Oops!", "Ocurrio un error en el Sistema, por favor intentalo de nuevo más tarde.", "error");
                console.log("Error: ", error)
            })
    } catch (error) {
        console.log(error);
    }
}

function validarPerfil(e) {
    e.preventDefault();
    let strIdentificacion = document.getElementById("txtIdentificacion").value;
    const strNombre = document.getElementById("txtNombre").value;
    const strApellido = document.getElementById("txtApellido").value;
    const intTelefono = document.getElementById("txtTelefono").value;
    const strPassword = document.getElementById("txtPassword").value;
    const strPasswordConfirm = document.getElementById("txtPasswordConfirm").value;

    const perfil = {
        strIdentificacion,
        strNombre,
        strApellido,
        intTelefono,
    }

    if (validar(perfil)) {
        console.log('todos los campos son obligatorios');
        return false;
    }

    //Validamos cambio de contraseña y que sean iguales (Formulario actualizar Perfil).
    if (strPassword != "" || strPasswordConfirm != "") {
        if (strPassword != strPasswordConfirm) {
            Swal.fire("Atención!", "Las contraseñas no son iguales", "info");
            return false;
        }
        if (strPassword.length < 5) {
            Swal.fire(
                "Atención!",
                "Las contraseña debe tener al menos 5 caracteres",
                "info"
            );
            return false;
        }
    }

    //Validamos los campos en rojo
    let elementsValid = document.getElementsByClassName("valid");
    for (let i = 0; i < elementsValid.length; i++) {
        if (elementsValid[i].classList.contains("is-invalid")) {
            Swal.fire(
                "Atención!",
                "Por favor verifique los campos en rojo!",
                "error"
            );
            return false;
        }
    }

    actualizarPerfil(perfil);

}

const actualizarPerfil = async perfil => {
    const url = base_url + "/Usuarios/putPerfil";
    const formData = new FormData(formPerfil);

    await fetch(url, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(results => {
            if (results.status) {
                $("#modalFormPerfil").modal("hide");
                Swal.fire({
                    title: "",
                    text: results.msg,
                    icon: "success",
                    confirmButtonText: "Aceptar",
                    closeOnConfirm: false,
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                    }
                });
            } else {
                Swal.fire(
                    "",
                    results.msg,
                    "success"
                );
            }
        })
}

function validarFiscal(e) {
    e.preventDefault();
    const strNit = document.querySelector("#txtNit").value;
    const strNombreFiscal = document.querySelector("#txtNombreFiscal").value;
    const strtxtDirFiscal = document.querySelector("#txtDirFiscal").value;

    const fiscal = {
        strNit,
        strNombreFiscal,
        strtxtDirFiscal
    }

    if (validar(fiscal)) {
        Swal.fire(
            "",
            "Todos los campos son obligatorios!",
            "info"
        );
        return false;
    }

    actualizarFiscal(fiscal);

}

const actualizarFiscal = async fiscal => {
    let url = base_url + "/Usuarios/putDFical";
    let formData = new FormData(formDatosFiscal);
    await fetch(url, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(results => {
            if (results.status) {
                Swal.fire({
                    title: "",
                    text: results.msg,
                    icon: "success",
                    confirmButtonText: "Aceptar",
                    closeOnConfirm: false,
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                    }
                });
            }
        })
}

window.addEventListener(
    "load",
    function() {
        fntRolesUsuario();
    },
    false
);

function fntRolesUsuario() {
    if (document.querySelector("#listRolid")) {
        let ajaxUrl = base_url + "/Roles/getSelectRoles";
        let request = window.XMLHttpRequest ?
            new XMLHttpRequest() :
            new ActiveXObject("Microsoft.XMLHTTP");
        request.open("GET", ajaxUrl, true);
        request.send();
        request.onreadystatechange = function() {
            if (request.readyState == 4 && request.status == 200) {
                document.querySelector("#listRolid").innerHTML = request.responseText;
            }
        };
    }
}

function fntViewUsuario(idpersona) {
    let ajaxUser = base_url + "/Usuarios/getUsuario/" + idpersona;
    fetch(ajaxUser, {
            method: 'GET'
        })
        .then(response => response.json())
        .then(objData => {
            if (objData.status) {
                let objUsuario = objData.data;
                const { identificacion, nombres, apellidos, telefono, email_user, nombrerol, fechaRegistro } = objUsuario;
                let estadoUsuario = "";
                if (objUsuario.status == 1) {
                    estadoUsuario = '<span class="badge badge-success">Activo</span>';
                } else {
                    estadoUsuario = '<span class="badge badge-danger">Inactivo</span>';
                }
                document.querySelector("#celIdentificacion").innerHTML = identificacion;
                document.querySelector("#celNombre").innerHTML = nombres;
                document.querySelector("#celApellido").innerHTML = apellidos;
                document.querySelector("#celTelefono").innerHTML = telefono;
                document.querySelector("#celEmail").innerHTML = email_user;
                document.querySelector("#celTipoUsuario").innerHTML = nombrerol;
                document.querySelector("#celEstado").innerHTML = estadoUsuario;
                document.querySelector("#celFechaRegistro").innerHTML = fechaRegistro;
                $('#modalViewUsuario').modal("show");
            } else {
                Swal.fire("Error", objData.msg, "error");
            }
        })
        .catch(error => {
            Swal.fire("Oops!", "Ocurrio un error en el Sistema, por favor intentalo de nuevo.", "error");
            console.log("Error: ", error)
        })
}

function fntEditUsuario(idpersona) {
    document.querySelector("#titleModal").innerHTML = "Actualizar Usuario";
    document.querySelector(".modal-header").classList.replace("headerRegister", "headerUpdate");
    document.querySelector("#btnActionForm").classList.replace("btn-primary", "btn-info");
    document.querySelector("#btnText").innerHTML = "Actualizar";
    let ajaxUser = base_url + "/Usuarios/getUsuario";

    fetch(`${ajaxUser}/${idpersona}`, {
            method: 'GET'
        })
        .then(response => response.json())
        .then(objData => {
            if (objData.status) {
                let objUsuarioEdit = objData.data;
                const { idpersona, identificacion, nombres, apellidos, telefono, email_user, idrol } = objUsuarioEdit;

                document.querySelector("#idUsuario").value = idpersona;
                document.querySelector("#txtIdentificacion").value = identificacion;
                document.querySelector("#txtNombre").value = nombres;
                document.querySelector("#txtApellido").value = apellidos;
                document.querySelector("#txtTelefono").value = telefono;
                document.querySelector("#txtEmail").value = email_user;
                document.querySelector("#listRolid").value = idrol;
                //VALIDAMOS PARA QUE CAPUTRA EL DATO CORRECTO DEL ESTATUS
                if (objData.data.status == 1) {
                    document.querySelector("#listStatus").value = 1;
                } else {
                    document.querySelector("#listStatus").value = 2;
                }
                $('#modalFormUsuario').modal("show");
            } else {
                Swal.fire("Error", objData.msg, "error");
            }
        })
        .catch(error => {
            Swal.fire("Oops!", "Ocurrio un error en el Sistema, por favor intentalo de nuevo.", "error");
            console.log("Error: ", error)
        })
}

function fntDelUsuario(idpersona) {
    Swal.fire({
        title: 'Está seguro de eliminar el Usuario?',
        text: "El usuario no será eliminado, se almacenara en la BD pero no estara visible",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, borrar!'
    }).then((result) => {
        if (result.isConfirmed) {
            const eliminarUsuario = async usuario => {
                const url = base_url + "/Usuarios/delUsuario/";
                let strData = "idUsuario=" + idpersona;
                try {
                    await fetch(`${url}`, {
                            method: 'POST',
                            body: strData,
                            headers: {
                                "Content-type": "application/x-www-form-urlencoded"
                            }
                        })
                        .then(response => response.json())
                        .then(results => {
                            if (results.status) {
                                Swal.fire("", results.msg, "success");
                                tableUsuarios.ajax.reload(null, false);
                            } else {
                                Swal.fire("Atención!", results.msg, "error");
                            }
                        })
                        .catch(error => {
                            Swal.fire("Oops!", "Ocurrio un error en el Sistema, por favor intentalo de nuevo.", "error");
                            console.log("Error: ", error)
                        })
                } catch (error) {
                    console.log("Error: ", error)
                }
            }
            eliminarUsuario();
        }
    });
}

const listarUsuarios = () => {
    tableUsuarios = $("#tableUsuarios").DataTable({
        responsive: true,
        aProcessing: true,
        aServerSide: true,
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
        },
        ajax: {
            url: " " + base_url + "/Usuarios/getUsuarios",
            dataSrc: "",
        },
        columns: [
            { data: "idpersona" },
            { data: "nombres" },
            { data: "apellidos" },
            { data: "email_user" },
            { data: "telefono" },
            { data: "nombrerol" },
            { data: "status" },
            { data: "options" },
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
        ],
    });
}

const listarUsuariosServerSide = () => {
    tableUsuarios = $("#tableUsuarios").DataTable({
        responsive: true,
        "pageLength": 10,
        "destroy": true,
        "bProcessing": true,
        "bDeferRender": true,
        "bServerSide": true,
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
        },
        "sAjaxSource": base_url + "/Controllers/Serverside/serverside_usuarios.php",
        "columns": [
            { "defaultContent": "" },
            { "data": 2 },
            { "data": 3 },
            { "data": 5 },
            { "data": 4 },
            { "data": 6 },
            {
                "data": 7,
                render: function(data, type, row) {
                    if (data == 1) {
                        return '<span class="badge bg-success">ACTIVO</span>';
                    } else {
                        return '<span class="badge bg-danger">INACTIVO</span>';
                    }
                }
            },
            {
                "data": null,
                render: function(data, type, row) {
                    if (data[8] == 1) {
                        return `<button class="btn btn-info btn-sm" onClick="fntViewUsuario(${data[0]})"><i class="fa-regular fa-eye"></i></button>
                        <button class="btn btn-primary btn-sm" onClick="fntEditUsuario(${data[0]})"><i class="fa-regular fa-pen-to-square"></i></button>
                        `;
                    } else {
                        return `<button class="btn btn-info btn-sm" onClick="fntViewUsuario(${data[0]})"><i class="fa-regular fa-eye"></i></button>
                        <button class="btn btn-primary btn-sm" onClick="fntEditUsuario(${data[0]})"><i class="fa-regular fa-pen-to-square"></i></button>
                        <button class="btn btn-danger btn-sm" onClick="fntDelUsuario(${data[0]})"><i class="fa-regular fa-trash-can"></i></button>
                        `;
                    }

                }
            }

        ],
        select: true,
        order: [
            [0, "desc"]
        ],
    });
    tableUsuarios.on('draw.td', () => {
        const PageInfo = $('#tableUsuarios').DataTable().page.info();
        tableUsuarios.column(0, { page: 'current' }).nodes().each((cell, i) => {
            cell.innerHTML = i + 1 + PageInfo.start;
        });
    });
}

function openModal() {
    document.querySelector("#idUsuario").value = "";
    document.querySelector(".modal-header").classList.replace("headerUpdate", "headerRegister");
    document.querySelector("#btnActionForm").classList.replace("btn-info", "btn-primary");
    document.querySelector("#btnText").innerHTML = "Guardar";
    document.querySelector("#titleModal").innerHTML = "Nuevo Usuario";
    document.querySelector("#formUsuario").reset();
    $("#modalFormUsuario").modal("show");
}

function openModalPerfil() {
    $("#modalFormPerfil").modal("show");
}