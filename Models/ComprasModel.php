<?php

class ComprasModel extends Mysql
{

	private $idCompra, $idProducto, $idProveedor, $idUsuario, $strPrecio, $intCantidad, $strSubtotal, $strImpuesto, $strGrantotal;


	public function __construct()
	{
		parent::__construct();
	}

	public function registrarDetalle(int $id_producto, int $id_usuario, string $precio, int $cantidad, string $sub_total)
	{
		$return = "";
		$this->idProducto = $id_producto;
		$this->idUsuario = $id_usuario;
		$this->strPrecio = $precio;
		$this->intCantidad = $cantidad;
		$this->strSubtotal = $sub_total;
		$query_insert = "INSERT INTO detalle_temp_compras (id_producto, id_usuario, precio, cantidad, sub_total) VALUES (?,?,?,?,?)";
		$arrData = array($this->idProducto, $this->idUsuario, $this->strPrecio, $this->intCantidad, $this->strSubtotal);
		$request_insert = $this->insert($query_insert, $arrData);
		$return = $request_insert;

		if ($request_insert) {
			$return = "ok";
		} else {
			$return = "error";
		}
		return $return;
	}

	public function actualizarDetalle(string $precio, int $cantidad, string $sub_total, int $id_producto, int $id_usuario)
	{
		$return = "";
		$this->idProducto = $id_producto;
		$this->idUsuario = $id_usuario;
		$this->strPrecio = $precio;
		$this->intCantidad = $cantidad;
		$this->strSubTotal = $sub_total;
		$query_insert = "UPDATE detalle_temp_compras SET precio=?, cantidad=?, sub_total=?  WHERE id_producto=? AND id_usuario=? ";
		$arrData = array($this->strPrecio,  $this->intCantidad, $this->strSubTotal, $this->idProducto, $this->idUsuario);
		$request_insert = $this->update($query_insert, $arrData);
		$return = $request_insert;

		if ($request_insert) {
			$return = "modificado";
		} else {
			$return = "error";
		}
		return $return;
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

	public function deleteDetalle(int $id)
	{
		$return = "";
		$query_delete = "DELETE FROM detalle_temp_compras WHERE id=$id";
		$arrData = array($id);
		$request = $this->delete($query_delete, $arrData);
		$return = $request;
		if ($request) {
			$return = "ok";
		} else {
			$return = "error";
		}
		return $return;
	}

	public function calcularCompra(int $id_usuario)
	{
		$sql = "SELECT sub_total, SUM(sub_total) AS total FROM detalle_temp_compras WHERE id_usuario=$id_usuario";
		$data = $this->select($sql);
		return $data;
	}

	public function consultarDetalle(int $id_producto, int $id_usuario)
	{
		$sql = "SELECT * FROM detalle_temp_compras WHERE id_producto=$id_producto AND id_usuario=$id_usuario";
		$data = $this->select($sql);
		return $data;
	}

	public function getImpuesto()
	{
		$sql = "SELECT impuesto FROM configuracion";
		$data = $this->select($sql);
		return $data;
	}

	public function registrarCompra(int $idsuario, int $idprov, string $gran_total)
	{
		$return = "";
		$this->idUsuario = $idsuario;
		$this->idProveedor = $idprov;
		$this->strGrantotal = $gran_total;
		$query_insert = "INSERT INTO compras (id_usuario, id_proveedor, sub_total) VALUES (?,?,?)";
		$arrData = array($this->idUsuario, $this->idProveedor, $this->strGrantotal);
		$request_insert = $this->insert($query_insert, $arrData);
		$return = $request_insert;

		if ($request_insert) {
			$return = "ok";
		} else {
			$return = "Error al generar la compra";
		}
		return $return;
	}

	public function id_compra()
	{
		$sql = "SELECT MAX(id_compra) AS id FROM compras";
		$arrData = $this->select($sql);
		return $arrData;
	}

	public function registrarDetalleCompra(int $id_compra, int $id_producto, int $cantidad, string $precio, string $sub_total, string $impuesto, string $gran_total)
	{
		$return = "";

		$this->idCompra = $id_compra;
		$this->idProducto = $id_producto;
		$this->intCantidad = $cantidad;
		$this->strPrecio = $precio;
		$this->strSubTotal = $sub_total;
		$this->strImpuesto = $impuesto;
		$this->strGrantotal = $gran_total;
		$query_insert = "INSERT INTO detalle_compras (id_compra, id_producto, cantidad, precio, sub_total, impuesto, gran_total) VALUES (?,?,?,?,?,?,?)";
		$arrData = array($this->idCompra, $this->idProducto, $this->intCantidad, $this->strPrecio, $this->strSubTotal, $this->strImpuesto, $this->strGrantotal);
		$request_insert = $this->insert($query_insert, $arrData);
		$return = $request_insert;

		if ($request_insert) {
			$return = "ok";
		} else {
			$return = "Error al generar la compra";
		}
		return $return;
	}

	public function getProductos(int $id)
	{
		$sql = "SELECT * FROM productos WHERE id_producto =$id";
		$request = $this->select($sql);
		return $request;
	}

	public function actualizarStock(int $cantidad, int $id_producto)
	{
		$return = "";
		$this->intCantidad = $cantidad;
		$this->idProducto = $id_producto;
		$query_insert = "UPDATE productos SET stock = ? WHERE id_producto = ?";
		$arrData = array($this->intCantidad, $this->idProducto);
		$request_insert = $this->update($query_insert, $arrData);
		$return = $request_insert;
		return $return;
	}

	public function vaciarDetalle(int $id_usuario)
	{

		$return = "";

		$this->idUsuario = $id_usuario;

		$query_insert = "DELETE FROM detalle_temp_compras WHERE id_usuario = $id_usuario";
		$arrData = array($this->idUsuario);
		$request_insert = $this->delete($query_insert, $arrData);
		$return = $request_insert;

		if ($request_insert) {
			$return = "ok";
		} else {
			$return = "Error al borrar detalle de compra";
		}
		return $return;
	}
}
