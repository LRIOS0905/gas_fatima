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
        $data['impuesto'] = $this->model->getImpuesto();
        $data['total_pagar'] = $this->model->calcularCompra($id_usuario);

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function deteleCompra($id)
    {
        $arrData = $this->model->deleteDetalle($id);

        if ($arrData == "ok") {
            $msg = array("status" => true, "msg" => 'Producto eliminado de la compra', 'icono' => 'error');
        } else {
            $msg = array("status" => false, "msg" => 'Ocurrió un error eliminando el producto', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function generarCompra()
    {
        $id_usuario = $_SESSION['idUser'];
        $id_prov = $_POST['idProveedor'];
        $total = $this->model->calcularCompra($id_usuario);

        $arrData = $this->model->registrarCompra($id_usuario,  $id_prov, $total['total']);

        if ($arrData == "ok") {
            $detalle = $this->model->getDetalle($id_usuario);
            /**CREAMOS MODELO PARA OBTENER ULTIMO ID DE LA COMPRA */
            $id_compra =  $this->model->id_compra();
            $iva = $this->model->getImpuesto();
            foreach ($detalle as $row) {
                /**CAPTURAMOS LA VARIABLES PARA SER ALMACENADAS */
                $cantidad = $row['cantidad'];
                $precio = $row['precio'];
                $id_producto = $row['id_producto'];
                $sub_total = $cantidad * $precio;
                $calculo_iva =  $iva['impuesto'] / 100;
                $impuesto =  $sub_total * $calculo_iva;
                $gran_total = $sub_total +   $impuesto;
                $this->model->registrarDetalleCompra($id_compra['id'], $id_producto, $cantidad, $precio, $sub_total, $impuesto, $gran_total);
                /**CONSULTAMOS STOCK ACTUAL */
                $stock_actual = $this->model->getProductos($id_producto);
                /**SUMAMOS STOCK ACTUAL MAS COMPRA */
                $nuevo_stock = $stock_actual['stock'] + $cantidad;
                /**ACTUALIZAMOS STOCK SEGUN LA COMPRA */
                $this->model->actualizarStock($nuevo_stock, $id_producto);
            }
            /**CREAMOS MODELOS PARA VACIAR TABLA DETALLE COMPRA */
            $vaciar = $this->model->vaciarDetalle($id_usuario);

            if ($vaciar == 'ok') {
                $msg = array('status' => true, 'msg' => 'La compra se ha generado correctamente', 'icono' => 'success', 'id_compra' => $id_compra['id']);
            }
        } else {
            $msg = "Error al registrar la compra";
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
}
