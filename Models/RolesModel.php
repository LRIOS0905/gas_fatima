<?php

class RolesModel extends Mysql
{

    public $intIdRol;
    public $strRol;
    public $strDescripcion;
    public $intStatus;


    public function __construct()
    {
        parent::__construct();
    }

    public function selectRoles()
    {
        $whereAdmin = "";
        if ($_SESSION['idUser'] != 1) {
            $whereAdmin = " AND idrol !=1";
        }
        $sql = "SELECT * FROM rol WHERE status !=0" . $whereAdmin;
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectRolesUsuario()
    {
        $whereAdmin = "";
        if ($_SESSION['idUser'] != 1) {
            $whereAdmin = " AND idrol !=1";
        }
        $sql = "SELECT * FROM rol WHERE status =1" . $whereAdmin;
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectRol(int $idrol)
    {
        //BUSCAR ROL EN LA BD
        $this->intIdRol = $idrol;
        $sql = "SELECT * FROM rol WHERE idrol=$this->intIdRol";
        $request = $this->select($sql);
        return $request;
    }

    public function insertRol(string $rol, string  $descripcion, int $status)
    {
        $return = "";
        $this->strRol = $rol;
        $this->strDescripcion = $descripcion;
        $this->intStatus = $status;

        //PREGUNTAMOS SI YA EXISTE ESE ROL
        $sql = "SELECT * FROM rol WHERE nombrerol = '{$this->strRol}'";
        $request = $this->select_all($sql);

        if (empty($request)) {
            //SI NO EXISTE INSERTAMOS EL REGISTRO
            $query_insert = "INSERT INTO rol (nombrerol, descripcion, status) VALUES (?,?,?)";
            $arrData = array($this->strRol, $this->strDescripcion, $this->intStatus);
            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
    }

    public function updateRol(int $idrol, string $rol, string $descripcion, int $status)
    {
        $this->intIdRol = $idrol;
        $this->strRol = $rol;
        $this->strDescripcion = $descripcion;
        $this->intStatus = $status;

        $sql = "SELECT * FROM rol WHERE nombrerol ='$this->strRol' AND idrol!=$this->intIdRol";
        $request = $this->select_all($sql);

        if (empty($request)) {
            $sql = "UPDATE rol SET nombrerol = ?, descripcion = ?, status = ? WHERE idrol = $this->intIdRol";
            $arrData = array($this->strRol, $this->strDescripcion, $this->intStatus);
            $request = $this->update($sql, $arrData);
        } else {
            $request = "exist";
        }
        return $request;
    }

    public function deleteRol(int $idrol)
    {
        $this->intIdRol = $idrol;
        /**VALIDAMOS SI EXISTE USUARIO RELACIONADO AL ROL */
        $sql = "SELECT * FROM persona WHERE rolid=$this->intIdRol";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $sql = "UPDATE rol set status = ? WHERE idrol = $this->intIdRol";
            #CUANDO SE BORRA EL REGISTRO SE PASA A ESTA CERO (0)
            $arrData = array(0);
            $request = $this->update($sql, $arrData);
            if ($request) {
                $request = "ok";
            } else {
                $request = "error";
            }
        } else {
            $request = "exist";
        }
        return $request;
    }
}
