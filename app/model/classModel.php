<?php
class Modelo extends PDO
{
    protected $connection;

    public function __construct()
    {
        $this->connection = new PDO(
            'mysql:host=' .
                Config::$mvc_bd_hostname . ';dbname=' .
                Config::$mvc_bd_nombre . '',
            Config::$mvc_bd_usuario,
            Config::$mvc_bd_clave
        );
        $this->connection->exec("set names utf8");
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}
