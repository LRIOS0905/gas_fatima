<?php

class TiposModel extends Mysql
{
    private $idTipo, $strNombreTipo, $intStatus;

    public function __construct()
    {
        parent::__construct();
    }

    public function insertRegistro(string $nombre, int $status)
    {
        $return = 0;
        $this->strNombreTipo = $nombre;
        $this->intStatus = $status;

        $sql = "SELECT * FROM tipo WHERE nombre = '{$this->strNombreTipo}' ";
        $request = $this->select_all($sql);

        if (empty($request)) {
            $query_insert = "INSERT INTO tipo (nombre, status) VALUES (?,?)";
            $arrData = array($this->strNombreTipo, $this->intStatus);
            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
    }

    public function updateRegistro($id, $nombre, $status)
    {
        $this->idTipo = $id;
        $this->strNombreTipo = $nombre;
        $this->status = $status;

        $sql = "SELECT * FROM tipo WHERE nombre = '{$this->strNombreTipo}' AND id_tipo != $this->idTipo";
        $request = $this->select_all($sql);

        if (empty($request)) {
            $sql = "UPDATE tipo SET nombre = ?, status = ? WHERE id_tipo = $this->idTipo";
            $arrData = array($this->strNombreTipo, $this->status);
            $request = $this->update($sql, $arrData);
        } else {
            $request = "exist";
        }
        return $request;
    }


    public function selectTipos()
    {
        $sql = "SELECT * FROM tipo WHERE status != 0 ";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectTipo(int $id)
    {
        $this->idTipo = $id;
        $sql = "SELECT * FROM tipo WHERE id_tipo = $this->idTipo";
        $request = $this->select($sql);
        return $request;
    }

    public function deleteTipo(int $id)
    {
        $this->idTipo = $id;
        $sql = "SELECT * FROM cliente WHERE tipo_id = $this->idTipo";
        $request = $this->select_all($sql);

        if (empty($request)) {
            $sql = "UPDATE tipo SET status = ? WHERE id_tipo = $this->idTipo ";
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
