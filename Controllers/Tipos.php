<?php

class Tipos extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['login'])) {
            header('location: ' . base_url() . '/login');
        }
        getPermisos(3);
    }

    public function tipos()
    {
        // $data['page_id'] = 4;
        $data['page_tag'] = "Tipos";
        $data['page_title'] = "MÓDULO TIPOS";
        $data['page_name'] = "tipos";
        $data['page_functions_js'] = "functions_tipos.js";
        $this->views->getView($this, "tipos", $data);
    }

    public function setTipo()
    {
        if ($_POST) {
            if (empty($_POST['txtTipo']) || empty($_POST['listStatus'])) {
                $arrResponse = array("status" => false, "msg" => "Datos incorrectos");
            } else {
                $idTipo = intval($_POST['idTipo']);
                $strNombreTipo = strClean($_POST['txtTipo']);
                $intStatus = intval($_POST['listStatus']);
                $request_tipo = "";

                if ($idTipo == 0) {
                    if ($_SESSION['permisosMod']['w']) {
                        $request_tipo = $this->model->insertRegistro($strNombreTipo, $intStatus);
                        $option = 1;
                    }
                } else {
                    if ($_SESSION['permisosMod']['u']) {
                        $request_tipo = $this->model->updateRegistro($idTipo, $strNombreTipo, $intStatus);
                        $option = 2;
                    }
                }

                if ($request_tipo > 0) {
                    if ($option == 1) {
                        $arrResponse = array("status" => true, "msg" => "Registro creado con éxito", "icono" => "success");
                    } else {
                        $arrResponse = array("status" => true, "msg" => "Registro actualizado con éxito", "icono" => "success");
                    }
                } else if ($request_tipo == "exist") {
                    $arrResponse = array("status" => false, "msg" => "Nombre de tipo ya existe, intente con otro", "icono" => "warning");
                } else {
                    $arrResponse = array("status" => false, "msg" => "Error al registro los datos", "icono" => "error");
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
            die();
        }
    }

    public function getTipos()
    {
        if ($_SESSION['permisosMod']['r']) {
            $arrData = $this->model->selectTipos();
            for ($i = 0; $i < count($arrData); $i++) {
                $btnEdit = '';
                $btnDelete = '';

                if ($arrData[$i]['status'] == 1) {
                    $arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
                } else {
                    $arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
                }

                if ($_SESSION['permisosMod']['u']) {
                    $btnEdit = '<button class="btn btn-primary  btn-sm" onClick="fntEditInfo(' . $arrData[$i]['id_tipo'] . ')" title="Editar tipo"><i class="fas fa-pencil-alt"></i></button>';
                }
                if ($_SESSION['permisosMod']['d']) {
                    $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo(' . $arrData[$i]['id_tipo'] . ')" title="Eliminar tipo"><i class="far fa-trash-alt"></i></button>';
                }
                $arrData[$i]['options'] = '<div class="text-center">' . $btnEdit . ' ' . $btnDelete . '</div>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getTipo($idtipo)
    {
        if ($_SESSION['permisosMod']['r']) {
            $idtipo = intval($idtipo);
            if ($idtipo > 0) {
                $arrData = $this->model->selectTipo($idtipo);
                if (empty($arrData)) {
                    $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
                } else {
                    $arrResponse = array('status' => true, 'data' => $arrData);
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    public function delTipo()
    {
        if ($_POST) {
            if ($_SESSION['permisosMod']['d']) {
                $id = intval($_POST['idTipo']);
                $requestDelete = $this->model->deleteTipo($id);
                if ($requestDelete == "ok") {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el registro', 'icono' => 'success');
                } else if ($requestDelete == "exist") {
                    $arrResponse = array('status' => false, 'msg' => 'No es posible eliminar una marca con clientes asociados', 'icono' => 'warning');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el registro.');
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    public function getSelectTipos()
    {
        $htmlOptions = "";
        $arrData = $this->model->selectTipos();
        if (count($arrData) > 0) {
            for ($i = 0; $i < count($arrData); $i++) {
                $htmlOptions .= '<option value="' . $arrData[$i]['id_tipo'] . '">' . $arrData[$i]['nombre'] . '</option>';
            }
        }
        echo json_encode($htmlOptions, JSON_UNESCAPED_UNICODE);
        die();
    }
}
