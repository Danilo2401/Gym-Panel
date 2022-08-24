<?php


class DatabaseAdmin{

    private $host = "localhost";
    private $password = "";
    private $user = "root";
    private $dbname = "gym";
    private $conn;

    function SetConnection(){

        $this->conn = null;

        try{
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname",$this->user,$this->password);
        }catch(PDOException $e){
            echo $e->getMessage();
            die();
        }

        return $this->conn;
    }

}



?>