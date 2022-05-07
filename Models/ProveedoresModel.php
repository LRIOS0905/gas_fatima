<?php

class ProveedoresModel extends Mysql
{

    private $idProveedor, $strProveedor, $strTelefono, $strCorreo, $strDireccion, $intStatus;

    public function __construct()
    {
        parent::__construct();
    }

    public function insertRegistro(string $proveedor, string $telefono, string $correo, string $direccion, int $status)
    {
        $return = 0;
        $this->strProveedor = $proveedor;
        $this->strTelefono = $telefono;
        $this->strCorreo = $correo;
        $this->strDireccion = $direccion;
        $this->intStatus = $status;

        $sql = "SELECT * FROM proveedores WHERE nombres='{$this->strProveedor}' AND correo='$this->strCorreo'";
        $data = $this->select_all($sql);

        if (empty($data)) {
            $query_insert = "INSERT INTO proveedores(nombres, telefono, correo,direccion,status) VALUES (?,?,?,?,?)";
            $arrData = array($this->strProveedor, $this->strTelefono, $this->strCorreo, $this->strDireccion, $this->intStatus);
            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;

        // $query_insert = "SP_REGISTRAR_PROVEEDOR(?,?,?,?,?)";
        // $arrData = array($this->strProveedor, $this->strTelefono, $this->strCorreo, $this->strDireccion, $this->intStatus);
        // $request_insert = $this->insert($query_insert, $arrData);
        // return $request_insert;
    }
}
