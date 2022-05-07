<?php

class Proveedores extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['login'])) {
            header('location: ' . base_url() . '/login');
        }
        getPermisos(7);
    }

    public function proveedores()
    {
        // $data['page_id'] = 4;
        $data['page_tag'] = "Proveedores";
        $data['page_title'] = "MANTENIMIENTO PROVEEDORES";
        $data['page_name'] = "proveedores";
        $data['page_functions_js'] = "functions_proveedores.js";
        $this->views->getView($this, "proveedores", $data);
    }

    public function setProveedor()
    {
        if ($_POST) {
            if (empty($_POST['txtProveedor']) || empty($_POST['txtTelefono'])) {
                $arrResponse = array("status" => false, "msg" => "Datos incorrectos");
            } else {
                $idProveedor = intval($_POST['idProveedor']);
                $strProveedor = strClean($_POST['txtProveedor']);
                $strTelefono = strClean($_POST['txtTelefono']);
                $strCorreo = strClean($_POST['txtEmail']);
                $strDireccion = strClean($_POST['txtDireccion']);
                $intStatus = intval($_POST['listStatus']);
                $request_prov = "";

                if ($idProveedor == 0) {

                    $request_prov = $this->model->insertRegistro($strProveedor, $strTelefono, $strCorreo, $strDireccion, $intStatus);
                    $option = 1;
                }

                if ($request_prov > 0) {
                    if ($option == 1) {
                        $arrResponse = array("status" => true, "msg" => "Registro creado con éxito", "icono" => "success");
                    }
                } else if ($request_prov == "exist") {
                    $arrResponse = array("status" => false, "msg" => "Nombre de proveedor y/o correo ya existen, intente con otro", "icono" => "info");
                } else {
                    $arrResponse = array("status" => false, "msg" => "Error al registro los datos", "icono" => "error");
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
            die();
        }
    }
}
