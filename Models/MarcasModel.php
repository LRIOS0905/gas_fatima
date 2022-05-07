<?php

class MarcasModel extends Mysql
{

	private $id, $marca, $descripcion, $portada, $status;

	public function __construct()
	{
		parent::__construct();
	}

	public function insertRegistro($marca, $descripcion, $portada, $status)
	{
		$return = 0;
		$this->marca = $marca;
		$this->descripcion = $descripcion;
		$this->portada = $portada;
		$this->status = $status;

		$sql = "SELECT * FROM marca WHERE nombre = '{$this->marca}' ";
		$request = $this->select_all($sql);

		if (empty($request)) {
			$query_insert = "INSERT INTO marca (nombre, descripcion, portada, status) VALUES (?,?,?,?)";
			$arrData = array($this->marca, $this->descripcion, $this->portada, $this->status);
			$request_insert = $this->insert($query_insert, $arrData);
			$return = $request_insert;
		} else {
			$return = "exist";
		}
		return $return;
	}

	public function updateRegistro($id, $marca, $descripcion, $portada, $status)
	{
		$this->id = $id;
		$this->marca = $marca;
		$this->descripcion = $descripcion;
		$this->portada = $portada;
		$this->status = $status;

		$sql = "SELECT * FROM marca WHERE nombre = '{$this->marca}' AND idmarca != $this->id";
		$request = $this->select_all($sql);

		if (empty($request)) {
			$sql = "UPDATE marca SET nombre = ?, descripcion = ?, portada = ?, status = ? WHERE idmarca = $this->id";
			$arrData = array($this->marca, $this->descripcion, $this->portada, $this->status);
			$request = $this->update($sql, $arrData);
		} else {
			$request = "exist";
		}
		return $request;
	}

	public function selectMarcas()
	{
		$sql = "SELECT * FROM marca WHERE status != 0 ";
		$request = $this->select_all($sql);
		return $request;
	}

	public function selectMarca(int $id)
	{
		$this->id = $id;
		$sql = "SELECT * FROM marca WHERE idmarca = $this->id";
		$request = $this->select($sql);
		return $request;
	}

	public function deleteMarca(int $id)
	{
		$this->id = $id;
		$sql = "SELECT * FROM cliente WHERE marca_id = $this->id";
		$request = $this->select_all($sql);

		if (empty($request)) {
			$sql = "UPDATE marca SET status = ? WHERE idmarca = $this->id ";
			$arrData = array(0);
			$request = $this->update($sql, $arrData);
			if ($request) {
				$request = 'ok';
			} else {
				$request = 'error';
			}
		} else {
			$request = 'exist';
		}
		return $request;
	}
}
