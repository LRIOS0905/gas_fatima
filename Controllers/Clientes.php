<?php

class Clientes extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['login'])) {
            header('location: ' . base_url() . '/login');
        }
        getPermisos(4);
    }

    public function clientes()
    {
        // $data['page_id'] = 4;
        $data['page_tag'] = "Clientes";
        $data['page_title'] = "MÓDULO CLIENTES";
        $data['page_name'] = "clientes";
        $data['page_functions_js'] = "functions_clientes.js";
        $this->views->getView($this, "clientes", $data);
    }

    public function setCliente()
    {
        if ($_POST) {
            if (empty($_POST['txtNombre']) || empty($_POST['txtTelefono'])) {
                $arrResponse = array("status" => false, "msg" => "Todos los campos son obligatorios");
            } else {
                $idCliente = intval($_POST['idCliente']);
                $strCodigo = strClean($_POST['txtCodigo']);
                $strNombre = strClean($_POST['txtNombre']);
                $strTelefono = strClean($_POST['txtTelefono']);
                $strDireccion = strClean($_POST['txtDireccion']);
                $listMarca = intval($_POST['listMarca']);
                $listTipo = intval($_POST['listTipo']);
                $listStatus = intval($_POST['listStatus']);
                $request_cliente = "";

                if ($idCliente == 0) {
                    if ($_SESSION['permisosMod']['w']) {
                        $option = 1;
                        $request_cliente = $this->model->insertRegistro($strCodigo, $strNombre, $strTelefono, $strDireccion, $listMarca, $listTipo, $listStatus);
                    }
                } else {
                    if ($_SESSION['permisosMod']['u']) {
                        $option = 2;
                        $request_cliente = $this->model->updateRegistro($idCliente, $strCodigo, $strNombre, $strTelefono, $strDireccion, $listMarca, $listTipo, $listStatus);
                    }
                }

                if ($request_cliente > 0) {
                    if ($option == 1) {
                        $arrResponse = array("status" => true, "msg" => "Registro creado con exito", "icono" => "success");
                    } else {
                        $arrResponse = array("status" => true, "msg" => "Registro actualizado con exito", "icono" => "success");
                    }
                } else if ($request_cliente == "exist") {
                    $arrResponse = array("status" => false, "msg" => "Código de cliente ya existe, intente con otro", "icono" => "warning");
                } else {
                    $arrResponse = array("status" => false, "msg" => "Error al realizar el registro", "icono" => "error");
                }

                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
            die();
        }
    }

    public function getClientes()
    {
        if ($_SESSION['permisosMod']['r']) {
            $arrData = $this->model->selectClientes();
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
                    $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo(' . $arrData[$i]['id_cliente'] . ')" title="Ver cliente"><i class="far fa-eye"></i></button>';
                }

                if ($_SESSION['permisosMod']['u']) {
                    $btnEdit = '<button class="btn btn-primary  btn-sm" onClick="fntEditInfo(' . $arrData[$i]['id_cliente'] . ')" title="Editar cliente"><i class="fas fa-pencil-alt"></i></button>';
                }
                if ($_SESSION['permisosMod']['d']) {
                    $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo(' . $arrData[$i]['id_cliente'] . ')" title="Eliminar cliente"><i class="far fa-trash-alt"></i></button>';
                }
                $arrData[$i]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnEdit . ' ' . $btnDelete . '</div>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getCliente($idcliente)
    {
        if ($_SESSION['permisosMod']['r']) {
            $idcliente = intval($idcliente);
            if ($idcliente > 0) {
                $arrData = $this->model->selectCliente($idcliente);
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

    public function delCliente()
    {
        if ($_POST) {
            if ($_SESSION['permisosMod']['d']) {
                $id = intval($_POST['idCliente']);
                $requestDelete = $this->model->deleteCliente($id);
                if ($requestDelete) {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el registro', 'icono'=>'success');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el registro.');
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }
}
