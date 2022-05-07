<?php

class Marcas extends Controllers
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

    public function marcas()
    {
        // $data['page_id'] = 4;
        $data['page_tag'] = "Marcas";
        $data['page_title'] = "MÓDULO MARCAS";
        $data['page_name'] = "marcas";
        $data['page_functions_js'] = "functions_marcas.js";
        $this->views->getView($this, "marcas", $data);
    }

    public function setMarca()
    {
        if ($_POST) {
            if (empty($_POST['txtMarca']) || empty($_POST['txtDescripcion'])) {
                $arrResponse = array("msg" => "Datos incorrectos");
            } else {
                $id = intval($_POST['idMarca']);
                $marca = strClean($_POST['txtMarca']);
                $descripcion = strClean($_POST['txtDescripcion']);
                $status = intval($_POST['listStatus']);

                $foto            = $_FILES['foto'];
                $nombre_foto     = $foto['name'];
                $type              = $foto['type'];
                $url_temp        = $foto['tmp_name'];
                $imgPortada     = 'portada_marca.png';
                $request_marca = "";

                if ($nombre_foto != '') {
                    $imgPortada = 'img_' . md5(date('d-m-Y H:i:s')) . '.jpg';
                }

                if ($id == 0) {
                    if ($_SESSION['permisosMod']['w']) {
                        $option = 1;
                        $request_marca = $this->model->insertRegistro($marca, $descripcion, $imgPortada, $status);
                    }
                } else {
                    if ($_SESSION['permisosMod']['u']) {
                        if ($nombre_foto == '') {
                            if ($_POST['foto_actual'] != 'portada_marca.png' && $_POST['foto_remove'] == 0) {
                                $imgPortada = $_POST['foto_actual'];
                            }
                        }
                        $option = 2;
                        $request_marca = $this->model->updateRegistro($id, $marca, $descripcion, $imgPortada, $status);
                    }
                }

                if ($request_marca > 0) {
                    if ($option == 1) {
                        $arrResponse = array("status" => true, "msg" => "Registro creado con éxito", "icono" => "success");
                        if ($nombre_foto != '') {
                            uploadImage($foto, $imgPortada);
                        }
                    } else {
                        $arrResponse = array("status" => true, "msg" => "Datos actualizados con éxito", "icono" => "success");
                        if ($nombre_foto != '') {
                            uploadImage($foto, $imgPortada);
                        }

                        if (($nombre_foto == '' && $_POST['foto_remove'] == 1 && $_POST['foto_actual'] != 'portada_marca.png')
                            || ($nombre_foto != '' && $_POST['foto_actual'] != 'portada_marca.png')
                        ) {
                            deleteFile($_POST['foto_actual']);
                        }
                    }
                } else if ($request_marca == "exist") {
                    $arrResponse = array("status" => false, "msg" => "Nombre de marca ya existe", "icono" => "warning");
                } else {
                    $arrResponse = array("status" => false, "msg" => "No es posible almacenar los datos", "icono" => "error");
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getMarcas()
    {
        if ($_SESSION['permisosMod']['r']) {
            $arrData = $this->model->selectMarcas();
            for ($i = 0; $i < count($arrData); $i++) {
                $arrData[$i]['imagen'] = '<img class="img-marca" src="' . media() . "/images/uploads/" . $arrData[$i]['portada'] . '">';
                $btnView = '';
                $btnEdit = '';
                $btnDelete = '';

                if ($arrData[$i]['status'] == 1) {
                    $arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
                } else {
                    $arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
                }

                if ($_SESSION['permisosMod']['r']) {
                    $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo(' . $arrData[$i]['idmarca'] . ')" title="Ver categoría"><i class="far fa-eye"></i></button>';
                }
                if ($_SESSION['permisosMod']['u']) {
                    $btnEdit = '<button class="btn btn-primary  btn-sm" onClick="fntEditInfo(' . $arrData[$i]['idmarca'] . ')" title="Editar categoría"><i class="fas fa-pencil-alt"></i></button>';
                }
                if ($_SESSION['permisosMod']['d']) {
                    $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo(' . $arrData[$i]['idmarca'] . ')" title="Eliminar categoría"><i class="far fa-trash-alt"></i></button>';
                }
                $arrData[$i]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnEdit . ' ' . $btnDelete . '</div>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getMarca($idmarca)
    {
        if ($_SESSION['permisosMod']['r']) {
            $idmarca = intval($idmarca);
            if ($idmarca > 0) {
                $arrData = $this->model->selectMarca($idmarca);
                if (empty($arrData)) {
                    $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
                } else {
                    $arrData['url_portada'] = media() . '/images/uploads/' . $arrData['portada'];
                    $arrResponse = array('status' => true, 'data' => $arrData);
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    public function delMarca()
    {
        if ($_POST) {
            if ($_SESSION['permisosMod']['d']) {
                $id = intval($_POST['idMarca']);
                $requestDelete = $this->model->deleteMarca($id);
                if ($requestDelete == "ok") {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado la Marca', 'icono' => 'success');
                } else if ($requestDelete === "exist") {
                    $arrResponse = array('status' => false, 'msg' => 'No es posible eliminar una marca con clientes asociados', 'icono' => 'warning');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'Error al eliminar la Marca.', 'icono' => 'error');
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    public function getSelectMarcas()
    {
        $htmlOptions = "";
        $arrData = $this->model->selectMarcas();
        if (count($arrData) > 0) {
            for ($i = 0; $i < count($arrData); $i++) {
                $htmlOptions .= '<option value="' . $arrData[$i]['idmarca'] . '">' . $arrData[$i]['nombre'] . '</option>';
            }
        }
        echo json_encode($htmlOptions, JSON_UNESCAPED_UNICODE);
        die();
    }
}
