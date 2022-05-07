// Login Page Flipbox control
$('.login-content [data-toggle="flip"]').click(function() {
    $(".login-box").toggleClass("flipped");
    return false;
});


const formLogin = document.getElementById('formLogin');
const formResetPass = document.getElementById('formResetPass');
const formCambiarPass = document.getElementById('formCambiarPass');

const textLogin = document.getElementById('textLogin');

document.addEventListener(
    "DOMContentLoaded",
    function() {

        if (formLogin) {
            formLogin.addEventListener("submit", validarUsuario);
        }

        if (formResetPass) {
            formResetPass.addEventListener("submit", resetPass);
        }

        if (formCambiarPass) {
            formCambiarPass.addEventListener("submit", validarNuevaPass)
        }
    },
    false
);

const validarUsuario = async e => {
    e.preventDefault();
    recuerdame();
    let strEmail = document.querySelector("#txtEmail").value;
    let strPassword = document.querySelector("#txtPassword").value;

    if (strEmail == "" || strPassword === "") {
        Swal.fire('', 'Debe ingresar usuario y contraseña', 'warning');
        return false;
    } else {
        //divLoading.style.display = "flex";
        const formData = new FormData(formLogin);
        const url = base_url + "/Login/loginUsser";
        try {
            await fetch(url, {
                    method: "POST",
                    body: formData
                })
                .then(req => req.json())
                .then(res => {
                    if (res.status) {
                        textLogin.innerHTML = `<i class="fa-solid fa-street-view fa-lg fa-fw"></i> Validando...`;
                        setTimeout(() => {
                            Swal.fire({
                                    title: "",
                                    text: 'Acceso concedido, Bienvenido',
                                    icon: "success",
                                    confirmButtonText: "Continuar....",
                                    confirmButtonColor: "green",
                                    allowOutsideClick: false,
                                })
                                .then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = base_url + "/dashboard";
                                    }
                                });
                        }, 1500);
                    } else {
                        textLogin.innerHTML = `<i class="fa-solid fa-street-view fa-lg fa-fw"></i> Validando...`;
                        // textLogin.classList.replace('btn-primary', 'btn-success')
                        setTimeout(() => {
                            Swal.fire('', 'Usuario y/o contraseña equivocada', 'error')
                            textLogin.innerHTML = `<i class="fas fa-sign-in-alt fa-lg fa-fw"></i> Ingresar`;
                            // textLogin.classList.replace('btn-success', 'btn-danger')
                        }, 1500);
                    }
                    //divLoading.style.display = "none";
                })
        } catch (error) {
            console.log(error);
        }
    }

}

const resetPass = e => {
    e.preventDefault();
    const strEmail = document.getElementById('txtEmailReset').value;

    if (strEmail === '') {
        Swal.fire("Por favor", "Escribe tu correo electrónico.", "error");
        return false;
    }

    enviarSolicitud();
}

const enviarSolicitud = async() => {
    try {
        const url = base_url + "/Login/resetPass";
        const formData = new FormData(formResetPass);
        await fetch(url, {
                method: "POST",
                body: formData
            })
            .then(res => res.json())
            .then(req => {
                if (req.status) {
                    Swal.fire({
                            title: "",
                            text: req.msg,
                            icon: "success",
                            confirmButtonText: "Aceptar"
                        })
                        .then((result) => {
                            if (result.isConfirmed) {
                                window.location = base_url + "/login";
                            }
                        });
                } else {
                    Swal.fire("Atención", req.msg, "error");
                }
            })
    } catch (error) {
        console.log(error);
    }
}

const validarNuevaPass = e => {
    e.preventDefault();
    const strPassword = document.getElementById("txtPassword").value;
    const strPasswordConfirm = document.getElementById("txtPasswordConfirm").value;
    const idUsuario = document.getElementById("idUsuario").value;

    const clave = {
        strPassword,
        strPasswordConfirm
    }

    if (validar(clave)) {
        Swal.fire("Por favor", "Escribe la nueva contraseña.", "error");
        return false;
    }

    if (strPassword.length < 5) {
        Swal.fire(
            "Atención",
            "La contraseña debe tener un mínimo de 5 caracteres.",
            "info"
        );
        return false;
    }

    if (strPassword != strPasswordConfirm) {
        Swal.fire("Atención", "Las contraseñas no son iguales.", "error");
        return false;
    }

    cambiarContraseña(clave);

}

const cambiarContraseña = async clave => {
    try {
        const url = base_url + "/Login/setPassword";
        const formData = new FormData(formCambiarPass);

        await fetch(url, {
                method: "POST",
                body: formData
            })
            .then(res => res.json())
            .then(req => {
                if (req.status) {
                    Swal.fire({
                        title: "",
                        text: req.msg,
                        icon: "success",
                        confirmButtonText: "Iniciar sessión",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location = base_url + "/login";
                        }
                    });
                } else {
                    Swal.fire("Atención", req.msg, "error");
                }
            })
    } catch (error) {
        console.log(error);
    }
}

const recuerdame = () => {
    if (rmcheck.checked && usuarioInput.value !== "" && passInput.value !== "") {
        localStorage.usuario = usuarioInput.value
        localStorage.pass = passInput.value
        localStorage.checkbox = rmcheck.value
    } else {
        localStorage.usuario = "";
        localStorage.pass = "";
        localStorage.checkbox = "";
    }
}

function validar(obj) {
    return !Object.values(obj).every(input => input !== '');
}