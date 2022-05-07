<?php

class ProductosModel extends Mysql
{

	private $idProducto, $strCodigo, $strDescripcion, $strPrecioCompra, $strPrecioVenta, $intStock, $intMarca, $intTipo, $intStatus;

	public function __construct()
	{
		parent::__construct();
	}

	public function getBuscarProductos($codigo, $nombre)
	{
		$sql = "SELECT p.id_producto, p.codigo, p.descripcion, p.precio_compra, m.idmarca, m.nombre AS marca, t.id_tipo, t.nombre AS tipo, Concat( p.codigo, ' - ', p.descripcion , ' - ', p.precio_compra) AS descProd 
		FROM productos p
		INNER JOIN marca m
		ON p.marca_id=m.idmarca
		INNER JOIN tipo t
		ON p.tipo_id=t.id_tipo
		WHERE p.codigo like '%" . $codigo . "%' OR p.descripcion like '%" . $nombre . "%'";
		$request = $this->select_all($sql);
		return $request;
	}

	public function selectProductos()
	{
		$sql = "SELECT p.*, m.idmarca, m.nombre AS marca, t.id_tipo, t.nombre AS tipo
        FROM productos p
        INNER JOIN marca m
        ON p.marca_id =m.idmarca
        INNER JOIN tipo t
        ON p.tipo_id=id_tipo
        WHERE p.status!=0";
		$request = $this->select_all($sql);
		return $request;
	}

	public function insertRegistro($codigo, $descripcion, $precio_compra, $precio_venta, $stock, $marca, $tipo, $estado)
	{
		$return = 0;
		$this->strCodigo = $codigo;
		$this->strDescripcion = $descripcion;
		$this->strPrecioCompra = $precio_compra;
		$this->strPrecioVenta = $precio_venta;
		$this->intStock = $stock;
		$this->intMarca = $marca;
		$this->intTipo = $tipo;
		$this->intStatus = $estado;

		$sql = "SELECT * FROM productos WHERE codigo ='{$this->strCodigo}'";
		$request = $this->select_all($sql);

		if (empty($request)) {
			$query_insert = "INSERT INTO productos (codigo, descripcion, precio_compra, precio_venta, stock, marca_id, tipo_id, status) VALUES(?,?,?,?,?,?,?,?)";
			$arrData = array($this->strCodigo, $this->strDescripcion, $this->strPrecioCompra, $this->strPrecioVenta, $this->intStock, $this->intMarca, $this->intTipo, $this->intStatus);
			$request_insert = $this->insert($query_insert, $arrData);
			$return = $request_insert;
		} else {
			$return = "exist";
		}

		return  $return;
	}

	public function updateRegistro($id_producto, $codigo, $descripcion, $precio_compra, $precio_venta, $stock, $marca, $tipo, $estado)
	{
		$this->idProducto = $id_producto;
		$this->strCodigo = $codigo;
		$this->strDescripcion = $descripcion;
		$this->strPrecioCompra = $precio_compra;
		$this->strPrecioVenta = $precio_venta;
		$this->intStock = $stock;
		$this->intMarca = $marca;
		$this->intTipo = $tipo;
		$this->intStatus = $estado;

		$sql = "SELECT * FROM productos WHERE codigo ='{$this->strCodigo}' AND id_producto!=$this->idProducto";
		$request = $this->select_all($sql);

		if (empty($request)) {
			$query_update = "UPDATE productos SET codigo = ?, descripcion = ?, precio_compra = ?, precio_venta = ?, stock = ?, marca_id = ?, tipo_id = ?, status = ? WHERE id_producto=$this->idProducto";
			$arrData = array($this->strCodigo, $this->strDescripcion, $this->strPrecioCompra, $this->strPrecioVenta, $this->intStock, $this->intMarca, $this->intTipo, $this->intStatus);
			$request_update = $this->update($query_update, $arrData);
		} else {
			$request_update = "exist";
		}
		return $request_update;
	}

	public function selectProducto(int $id)
	{
		$this->idProducto = $id;
		$sql = "SELECT p.*, m.idmarca,m.nombre AS marca, t.id_tipo, t.nombre AS tipo
         FROM productos p
         INNER JOIN marca m
         ON p.marca_id=m.idmarca
         INNER JOIN tipo t
         ON p.tipo_id=t.id_tipo
        WHERE p.id_producto = $this->idProducto";
		$request = $this->select($sql);
		return $request;
	}

	public function deleteProducto(int $id)
	{
		$this->idProducto = $id;
		$sql = "UPDATE productos SET status = ? WHERE id_producto = $this->idProducto ";
		$arrData = array(0);
		$request = $this->update($sql, $arrData);
		return $request;
	}
}
