<?php

class Dashboard extends Controllers
{
	public function __construct()
	{
		parent::__construct();
		session_start();
		if (empty($_SESSION['login'])) {
			header('location: ' . base_url() . '/login');
		}
		/**GET PERMISOS SE REFIERE AL PERMISO DE LOS MODULOS */
		getPermisos(1);
	}

	public function dashboard()
	{
		$data['page_id'] = 2;
		$data['page_tag'] = "Dashboard";
		$data['page_title'] = "Administrador Dashboard";
		$data['page_name'] = "dashboard";
		$data['page_functions_js'] = "functions_dashboard.js";
		$this->views->getView($this, "dashboard", $data);
	}
}
