<?php

class Compras extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['login'])) {
            header('location: ' . base_url() . '/login');
        }
        getPermisos(6);
    }

    public function compras()
    {
        // $data['page_id'] = 4;
        $data['page_tag'] = "Compras";
        $data['page_title'] = "MÓDULO DE COMRAS";
        $data['page_name'] = "compras";
        $data['page_functions_js'] = "functions_compras.js";
        $this->views->getView($this, "compras", $data);
    }

    public function setCompra()
    {
        if ($_POST) {
            if (empty($_POST['txtCodigo']) || empty($_POST['txtDescripcion'])) {
                $arrResponse = array("status" => false, "msg" => "Datos incorrectos");
            } else {
                $idCompra = intval($_POST['idCompra']);
                $idProducto = intval($_POST['idProducto']);
                $idUsuario = intval($_SESSION['idUser']);
                $strCodigo = strClean($_POST['txtCodigo']);
                $strDescripcion = strClean($_POST['txtDescripcion']);
                $strPrecio = strClean($_POST['precioCompra']);
                $intCantidad = intval($_POST['txtCantidad']);
                $strSubtotal = strClean($_POST['subTotal']);
                $request_compra = "";

                if ($idCompra == 0) {
                    if ($_SESSION['permisosMod']['w']) {
                        $option = 1;
                        $request_compra = $this->model->insertRegistro($idProducto, $idUsuario, $strPrecio, $intCantidad, $strSubtotal);
                    }
                }

                if ($request_compra > 0) {
                    if ($option == 1) {
                        $arrResponse = array("status" => true, "msg" => "Producto anexado a la compra", "icono" => "success");
                    }
                } else {
                    $arrResponse = array("status" => false, "msg" => "Error al anexar el producto a la compra", "icono" => "success");
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
            die();
        }
    }

    public function listar()
    {

        $id_usuario = intVal($_SESSION['idUser']);

        $data['detalle'] = $this->model->getDetalle($id_usuario);
        $data['total_pagar'] = $this->model->calcularCompra($id_usuario);

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
}
