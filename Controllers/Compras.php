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
                $strPrecio = strClean($_POST['precioCompra']);
                $intCantidad = intval($_POST['txtCantidad']);

                $comprobar = $this->model->consultarDetalle($idProducto, $idUsuario);

                if (empty($comprobar)) {
                    $sub_total = $strPrecio * $intCantidad;
                    $data = $this->model->registrarDetalle($idProducto, $idUsuario, $strPrecio, $intCantidad, $sub_total);
                    if ($data == "ok") {
                        $arrResponse = array('status' => true, 'msg' => 'Producto anexado a la compra', 'icono' => 'success');
                    } else {
                        $arrResponse = array('status' => false, 'msg' => 'No se pudo anexar el producto', 'icono' => 'error');
                    }
                } else {
                    $total_cantidad = $comprobar['cantidad'] + $intCantidad;
                    $sub_total = $total_cantidad * $strPrecio;
                    $data = $this->model->actualizarDetalle($strPrecio, $total_cantidad, $sub_total, $idProducto, $idUsuario);

                    if ($data == "modificado") {
                        $arrResponse = array('status' => true, 'msg' => 'Producto actualizado', 'icono' => 'info');
                    } else {
                        $arrResponse = array('status' => false, 'msg' => 'Error al actualizar el producto', 'icono' => 'error');
                    }
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
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

    public function deteleCompra($id)
    {
        $arrData = $this->model->deleteDetalle($id);

        if ($arrData == "ok") {
            $msg = array("status" => true, "msg" => 'Producto eliminado de la compra', 'icono' => 'danger');
        } else {
            $msg = array("status" => false, "msg" => 'Ocurrió un error eliminando el producto', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
}
