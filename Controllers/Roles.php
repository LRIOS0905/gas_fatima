<?php

class Roles extends Controllers
{
	public function __construct()
	{
		parent::__construct();
		session_start();
		session_regenerate_id(true);
		if (empty($_SESSION['login'])) {
			header('location: ' . base_url() . '/login');
		}
		getPermisos(2);
	}

	public function roles()
	{
		if (empty($_SESSION['permisosMod']['r'])) {
			header('location: ' . base_url() . '/dashboard');
		}
		$data['page_id'] = 3;
		$data['page_tag'] = "Roles Usuario";
		$data['page_name'] = "rol_usuario";
		$data['page_title'] = "MÓDULO ROLES DE USUARIO";
		$data['page_functions_js'] = "functions_roles.js";
		$this->views->getView($this, "roles", $data);
	}


	//METODO PARA EXTRAER TODOS LOS ROLES;
	public function getRoles()
	{
		if ($_SESSION['permisosMod']['r']) {
			$arrData = $this->model->selectRoles();
			//Recorre el array para capturar el estado del Rol //Recuerda que el for recorre todos los registros
			for ($i = 0; $i < count($arrData); $i++) {
				$btnPermisos = '';
				$btnEdit = '';
				$btnDelete = '';
				if ($arrData[$i]['status'] == 1) {
					# code...
					$arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
				} else {
					$arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
				}

				if ($_SESSION['permisosMod']['u']) {
					$btnPermisos = '<button class="btn btn-secondary btn-sm btnPermisosRol" onClick="fntPermisos(' . $arrData[$i]['idrol'] . ')" title="Permisos"><i class="fas fa-cog"></i></button> ';
				}

				if ($_SESSION['permisosMod']['u']) {
					$btnEdit = '<button class="btn btn-primary btn-sm btnEditRol" onClick="fntEditRol(' . $arrData[$i]['idrol'] . ')" title="Editar"><i class="fas fa-edit"></i></button> ';
				}

				if ($_SESSION['permisosMod']['d']) {
					$btnDelete = '<button class="btn btn-danger btn-sm btnDelRol" onClick="fntDelRol(' . $arrData[$i]['idrol'] . ')" title="Eliminar"><i class="fas fa-minus-circle"></i></button>';
				}

				$arrData[$i]['options'] = '<div class="text-center">' . $btnPermisos . ' ' . $btnEdit . ' ' . $btnDelete . '</div>';
			}

			echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
		}
		die();
		dep($arrData);
	}

	//EXTRAEMOS LOS ROLES PARA EL FORMULARIO DE USUARIOS
	public function getSelectRoles()
	{
		$htmlOptions = "";
		$arrData = $this->model->selectRolesUsuario();
		if (count($arrData) > 0) {
			for ($i = 0; $i < count($arrData); $i++) {

				$htmlOptions .= '<option value="' . $arrData[$i]['idrol'] . '">' . $arrData[$i]['nombrerol'] . '</option>';
			}
		}
		echo $htmlOptions;
		die();
	}

	//METODO PARA EXTRAER UN ROLES
	public function getRol(int $idrol)
	{
		if ($_SESSION['permisosMod']['r']) {
			$intIdRol = intval(strClean($idrol));
			if ($intIdRol > 0) {
				$arrData = $this->model->selectRol($intIdRol);
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

	public function setRol()
	{
		if ($_SESSION['permisosMod']['w']) {
			//Se crean las variables para almacenar los datos que se estan enviando desde el formulario
			$intIdRol = intval($_POST['idRol']);
			$strRol = strClean($_POST['txtNombre']);
			$strDescripcion = strClean($_POST['txtDescripcion']);
			$intStatus = intval($_POST['listStatus']);
			//VALIDAMOS ID ROL
			if ($intIdRol == 0) {
				//CREAR
				$request_rol = $this->model->insertRol($strRol, $strDescripcion, $intStatus);
				$option = 1;
			} else {
				# ACTUALIZAR
				$request_rol = $this->model->updateRol($intIdRol, $strRol, $strDescripcion, $intStatus);
				$option = 2;
			}

			//VALIDAMOS LA RESPUESTA DEL MODELO
			if ($request_rol > 0) {
				if ($option == 1) {
					# code...
					$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
				} else {
					# code...
					$arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente.');
				}
			} else if ($request_rol == 'exist') {
				$arrResponse = array('status' => false, 'msg' => '¡Atencion, el rol ya existe!');
			} else {
				$arrResponse = array('status' => false, 'msg' => 'No es posible almacenar los datos');
			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		}
		die();
	}

	public function delRol()
	{
		if ($_SESSION['permisosMod']['d']) {
			#VALIDAMOS SI HAY UNA PETICION POST
			if ($_POST) {
				$intIdRol = intval($_POST['idrol']);
				$requestDelete = $this->model->deleteRol($intIdRol);
				if ($requestDelete == "ok") {
					$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el Rol');
				} else if ($requestDelete == "exist") {
					$arrResponse = array('status' => false, 'msg' => 'No es posible eliminar un Rol asociado a usuarios');
				} else {
					$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el Rol');
				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
		}
		die();
	}
}
