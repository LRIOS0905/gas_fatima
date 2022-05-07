<?php

class ComprasModel extends Mysql
{

	private $idCompra, $idProducto, $idUsuario, $strPrecio, $intCantidad, $strSubtotal;


	public function __construct()
	{
		parent::__construct();
	}

	public function insertRegistro($id_prod, $id_usuario, $precio, $cantidad, $sub_total)
	{
		$this->idProducto = $id_prod;
		$this->idUsuario = $id_usuario;
		$this->strPrecio = $precio;
		$this->intCantidad = $cantidad;
		$this->strSubtotal = $sub_total;

		$query_insert = "INSERT INTO detalle_temp_compras (id_producto, id_usuario, precio, cantidad, sub_total) VALUES (?,?,?,?,?)";
		$arrData = array($this->idProducto, $this->idUsuario, $this->strPrecio, $this->intCantidad, $this->strSubtotal);
		$request_insert = $this->insert($query_insert, $arrData);
		return $request_insert;
	}

	public function getDetalle(int $id)
	{
		$sql = "SELECT d.*, p.id_producto, p.descripcion, p.codigo 
        FROM detalle_temp_compras d 
        INNER JOIN productos p 
        ON d.id_producto= p.id_producto
        WHERE d.id_usuario = $id ORDER BY d.id DESC";
		$data = $this->select_all($sql);
		return $data;
	}

	public function calcularCompra(int $id_usuario)
	{
		$sql = "SELECT sub_total, SUM(sub_total) AS total FROM detalle_temp_compras WHERE id_usuario=$id_usuario";
		$data = $this->select($sql);
		return $data;
	}
}
