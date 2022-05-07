<?php
class Conexion
{


    public function __construct()
    {
    }

    public function conexionPDO()
    {
        $host = 'localhost';
        $usuario = 'root';
        $contraseña = '';
        $dbname = 'gas-fatima';
        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname", $usuario, $contraseña);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->exec("set names utf8");
            return $pdo;
        } catch (PDOException $e) {
            $this->conect = 'Error de conexión';
            echo "ERROR: " . $e->getMessage();
        }
    }

    function cerrar_conexion()
    {
        $this->pdo = null;
    }
}
