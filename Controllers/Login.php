<?php

class Login extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (isset($_SESSION['login'])) {
            header('location: ' . base_url() . '/dashboard');
        }
    }

    public function login()
    {
        $data['page_tag'] = "Login";
        $data['page_title'] = "Secury Tech Services";
        $data['page_name'] = "login";
        $data['page_functions_js'] = "functions_login.js";
        $this->views->getView($this, "login", $data);
    }

    public function loginUsser()
    {
        //dep($_POST);
        if ($_POST) {
            if (empty($_POST['txtEmail']) || empty($_POST['txtPassword'])) {
                $arrResponse = array('status' => false, 'msg' => 'Error de datos');
            } else {
                // CREAMOS LAS VARIABLES PARA VALIDAD DATOS
                $strUsuario = strtolower(strClean($_POST['txtEmail']));
                $strPassword = hash("SHA256", $_POST['txtPassword']);
                $requestUser = $this->model->loginUser($strUsuario, $strPassword);
                if (empty($requestUser)) {
                    $arrResponse = array('status' => false, 'msg' => 'El usuario o la contraseña es incorrecto');
                } else {
                    $arrData = $requestUser;
                    if ($arrData['status'] == 1) {
                        $_SESSION['idUser'] = $arrData['idpersona'];
                        $_SESSION['login'] = true;

                        $arrData = $this->model->sessionLogin($_SESSION['idUser']);
                        sessionUser($_SESSION['idUser']);
                    
                        $arrResponse = array('status' => true, 'msg' => 'Ok');
                    } else {
                        $arrResponse = array('status' => false, 'msg' => 'Usuario se encuentra inactivo');
                    }
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function resetPass()
    {
        if ($_POST) {
            if (empty($_POST['txtEmailReset'])) {
                $arrResponse = array('status' => false, 'msg' => 'Error de datos');
            } else {
                $token = token();
                $strEmail  =  strtolower(strClean($_POST['txtEmailReset']));
                $arrData = $this->model->getUserEmail($strEmail);

                if (empty($arrData)) {
                    $arrResponse = array('status' => false, 'msg' => 'Usuario no existente.');
                } else {
                    $idpersona = $arrData['idpersona'];
                    $nombreUsuario = $arrData['nombres'] . ' ' . $arrData['apellidos'];

                    $url_recovery = base_url() . '/login/confirmUser/' . $strEmail . '/' . $token;
                    $requestUpdate = $this->model->setTokenUser($idpersona, $token);


                    if ($requestUpdate) {
                        $arrResponse = array('status' => true, 'msg' => 'Se ha enviado un email a tu correo para cambiar la contraseña');
                    } else {
                        $arrResponse = array(
                            'status' => false,
                            'msg' => 'No es posible realizar el proceso, intenta más tarde.'
                        );
                    }
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function confirmUser(string $params)
    {

        if (empty($params)) {
            header('Location:' . base_url());
        } else {
            //echo $params;
            $arrParams = explode(',', $params);
            $strEmail = strClean($arrParams[0]);
            $strToken = strClean($arrParams[1]);
            $arrResponse = $this->model->getUsuario($strEmail, $strToken);
            if (empty($arrResponse)) {
                header("Location: " . base_url());
            } else {
                $data['page_tag'] = "Cambiar contraseña";
                $data['page_name'] = "cambiar_contrasenia";
                $data['email'] = $strEmail;
                $data['token'] = $strToken;
                $data['page_functions_js'] = "functions_login.js";
                $data['page_title'] = "Cambiar Contraseña";
                $data['idpersona'] = $arrResponse['idpersona'];
                $this->views->getView($this, "cambiar_password", $data);
            }
        }
        die();
    }

    public function setPassword()
    {

        if (empty($_POST['idUsuario']) || empty($_POST['txtEmail']) || empty($_POST['txtToken']) || empty($_POST['txtPassword']) || empty($_POST['txtPasswordConfirm'])) {

            $arrResponse = array(
                'status' => false,
                'msg' => 'Error de datos'
            );
        } else {
            $intIdpersona = intval($_POST['idUsuario']);
            $strPassword = $_POST['txtPassword'];
            $strPasswordConfirm = $_POST['txtPasswordConfirm'];
            $strEmail = strClean($_POST['txtEmail']);
            $strToken = strClean($_POST['txtToken']);

            if ($strPassword != $strPasswordConfirm) {
                $arrResponse = array(
                    'status' => false,
                    'msg' => 'Las contraseñas no son iguales.'
                );
            } else {
                $arrResponseUser = $this->model->getUsuario($strEmail, $strToken);
                if (empty($arrResponseUser)) {
                    $arrResponse = array(
                        'status' => false,
                        'msg' => 'Erro de datos.'
                    );
                } else {
                    $strPassword = hash("SHA256", $strPassword);
                    $requestPass = $this->model->insertPassword($intIdpersona, $strPassword);

                    if ($requestPass) {
                        $arrResponse = array(
                            'status' => true,
                            'msg' => 'Contraseña actualizada con éxito.'
                        );
                    } else {
                        $arrResponse = array(
                            'status' => false,
                            'msg' => 'No es posible realizar el proceso, intente más tarde.'
                        );
                    }
                }
            }
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }
}
