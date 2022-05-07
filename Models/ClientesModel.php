<?php

class ClientesModel extends Mysql
{
    private $idCliente, $strCodigo, $strNombre, $strTelefono, $strDireccion, $listMarca, $listTipo, $listStatus;

    public function __construct()
    {
        parent::__construct();
    }

    public function selectClientes()
    {
        $sql = "SELECT c.*, m.idmarca, m.nombre AS marca, t.id_tipo, t.nombre AS tipo
        FROM cliente c
        INNER JOIN marca m
        ON c.marca_id =m.idmarca
        INNER JOIN tipo t
        ON c.tipo_id=id_tipo
        WHERE c.status!=0";
        $request = $this->select_all($sql);
        return $request;
    }

    public function insertRegistro($codigo, $nombre, $telefono, $direccion, $marca, $tipo, $status)
    {
        $return = 0;
        $this->strCodigo = $codigo;
        $this->strNombre = $nombre;
        $this->strTelefono = $telefono;
        $this->strDireccion = $direccion;
        $this->listMarca = $marca;
        $this->listTipo = $tipo;
        $this->listStatus = $status;

        $sql = "SELECT * FROM cliente WHERE codigo='{$this->strCodigo}'";
        $request = $this->select_all($sql);

        if (empty($request)) {
            $query_insert = "INSERT INTO cliente (codigo, nombre, telefono, direccion, marca_id, tipo_id, status) VALUES (?,?,?,?,?,?,?)";
            $arrData = array($this->strCodigo, $this->strNombre, $this->strTelefono, $this->strDireccion, $this->listMarca, $this->listTipo, $this->listStatus);
            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
    }

    public function updateRegistro($id, $codigo, $nombre, $telefono, $direccion, $marca, $tipo, $status)
    {
        $this->idCliente = $id;
        $this->strCodigo = $codigo;
        $this->strNombre = $nombre;
        $this->strTelefono = $telefono;
        $this->strDireccion = $direccion;
        $this->listMarca = $marca;
        $this->listTipo = $tipo;
        $this->listStatus = $status;

        $sql = "SELECT * FROM cliente WHERE codigo = '{$this->strCodigo}' AND id_cliente != $this->idCliente";
        $request = $this->select_all($sql);

        if (empty($request)) {
            $sql = "UPDATE cliente SET codigo = ?, nombre = ?, telefono = ?, direccion = ?, marca_id = ?, tipo_id = ?, status = ? WHERE id_cliente = $this->idCliente";
            $arrData = array($this->strCodigo, $this->strNombre, $this->strTelefono, $this->strDireccion, $this->listMarca, $this->listTipo, $this->listStatus);
            $request = $this->update($sql, $arrData);
        } else {
            $request = "exist";
        }
        return $request;
    }

    public function selectCliente(int $id)
    {
        $this->idCliente = $id;
        $sql = "SELECT c.*, m.idmarca,m.nombre AS marca, t.id_tipo, t.nombre AS tipo
         FROM cliente c
         INNER JOIN marca m
         ON c.marca_id=m.idmarca
         INNER JOIN tipo t
         ON c.tipo_id=t.id_tipo
        WHERE id_cliente = $this->idCliente";
        $request = $this->select($sql);
        return $request;
    }

    public function deleteCliente(int $id)
    {
        $this->idCliente = $id;
        $sql = "UPDATE cliente SET status = ? WHERE id_cliente = $this->idCliente ";
        $arrData = array(0);
        $request = $this->update($sql, $arrData);
        return $request;
    }
}
