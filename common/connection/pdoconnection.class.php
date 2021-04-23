<?php

class PDOConnection{
    private $connection;
    private $url = 'localhost';
    private $db = 'curriculo';
    private $login = 'rafael';
    private $pass = 'root';

    public function __construct(){
        $this->connection = new PDO(
            "mysql:host=$this->url;dbname=$this->db",
            $this->login, $this->pass,
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
        );
    }

    public function instance(){
        return $this->connection;
    }
}