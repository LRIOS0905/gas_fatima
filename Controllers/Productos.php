<?php

class Productos extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['login'])) {
            header('location: ' . base_url() . '/login');
        }
        getPermisos(5);
    }

    public function productos()
    {
        // $data['page_id'] = 4;
        $data['page_tag'] = "Productos";
        $data['page_title'] = "MÓDULO PRODUCTOS";
        $data['page_name'] = "productos";
        $data['page_functions_js'] = "functions_productos.js";
        $this->views->getView($this, "productos", $data);
    }

    public function buscarProductos()
    {
        if (isset($_POST['codigo']) || isset($_POST['nombre'])) {
            $codigo = $_POST['codigo'];
            $nombre = $_POST['nombre'];

            $response = array();
            $buscarProd = $this->model->getBuscarProductos($codigo, $nombre);

            if (count($buscarProd) > 0) {
                for ($i = 0; $i < count($buscarProd); $i++) {
                    $response[] = array(
                        "value" => $buscarProd[$i]['id_producto'],
                        "label" => $buscarProd[$i]['descProd'],
                        "codigo" => $buscarProd[$i]['codigo'],
                        "descripcion" => $buscarProd[$i]['descripcion'],
                        "precioCompra" => $buscarProd[$i]['precio_compra'],
                        "marca" => $buscarProd[$i]['marca'],
                        "tipo" => $buscarProd[$i]['tipo']
                    );
                }
            }
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
            die();
        }
    }

    public function setProducto()
    {
        if ($_POST) {
            if (empty($_POST['txtCodigo']) || empty($_POST['txtDescripcion'])) {
                $arrResponse = array("status" => false, "msg" => "Datos incorrectos");
            } else {
                $idProducto = intval($_POST['idProducto']);
                $codigo = strClean($_POST['txtCodigo']);
                $descripcion = strClean($_POST['txtDescripcion']);
                $precio_compra = strClean($_POST['precioCompra']);
                $precio_venta = strClean($_POST['precioVenta']);
                $stock = intval($_POST['stock']);
                $marca = intval($_POST['listMarca']);
                $tipo = intval($_POST['listTipo']);
                $estado = intval($_POST['listStatus']);
                $request_prod = "";

                if ($idProducto == 0) {
                    if ($_SESSION['permisosMod']['w']) {
                        $option = 1;
                        $request_prod = $this->model->insertRegistro($codigo, $descripcion, $precio_compra, $precio_venta, $stock, $marca, $tipo, $estado);
                    }
                } else {
                    if ($_SESSION['permisosMod']['w']) {
                        $request_prod = $this->model->updateRegistro($idProducto, $codigo, $descripcion, $precio_compra, $precio_venta, $stock, $marca, $tipo, $estado);
                        $option = 2;
                    }
                }

                if ($request_prod > 0) {
                    if ($option == 1) {
                        $arrResponse = array("status" => true, "msg" => "Producto creado con éxito", "icono" => "success");
                    } else {
                        $arrResponse = array("status" => true, "msg" => "Producto actualizado con éxito", "icono" => "success");
                    }
                } else if ($request_prod == "exist") {
                    $arrResponse = array("status" => false, "msg" => "Código de producto ya existe, intento con otro", "icono" => "warning");
                } else {
                    $arrResponse = array("status" => false, "msg" => "Error al registrar el productos", "icono" => "error");
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getProductos()
    {
        if ($_SESSION['permisosMod']['r']) {
            $arrData = $this->model->selectProductos();
            for ($i = 0; $i < count($arrData); $i++) {
                $btnView = '';
                $btnEdit = '';
                $btnDelete = '';

                if ($arrData[$i]['status'] == 1) {
                    $arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
                } else {
                    $arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
                }


                if ($_SESSION['permisosMod']['r']) {
                    $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo(' . $arrData[$i]['id_producto'] . ')" title="Ver cliente"><i class="far fa-eye"></i></button>';
                }

                if ($_SESSION['permisosMod']['u']) {
                    $btnEdit = '<button class="btn btn-primary  btn-sm" onClick="fntEditInfo(' . $arrData[$i]['id_producto'] . ')" title="Editar cliente"><i class="fas fa-pencil-alt"></i></button>';
                }
                if ($_SESSION['permisosMod']['d']) {
                    $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo(' . $arrData[$i]['id_producto'] . ')" title="Eliminar cliente"><i class="far fa-trash-alt"></i></button>';
                }
                $arrData[$i]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnEdit . ' ' . $btnDelete . '</div>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getProducto($idprod)
    {
        if ($_SESSION['permisosMod']['r']) {
            $idprod = intval($idprod);
            if ($idprod > 0) {
                $arrData = $this->model->selectProducto($idprod);
                if (empty($arrData)) {
                    $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.', 'icono' => 'error');
                } else {
                    $arrResponse = array('status' => true, 'data' => $arrData);
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    public function delProducto()
    {
        if ($_POST) {
            if ($_SESSION['permisosMod']['d']) {
                $id = intval($_POST['idProducto']);
                $requestDelete = $this->model->deleteProducto($id);
                if ($requestDelete) {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el registro', 'icono' => 'success');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el registro.');
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }
}
