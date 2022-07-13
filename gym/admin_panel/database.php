<?php


class Database{
    
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $dbname = "gym";
    private $dbconn;

    function SetConnection(){

        $this->dbconn = null;

        try {
            $this->dbconn = new PDO("mysql:host=$this->host;dbname=$this->dbname",$this->user,$this->password);
        } catch (PDOException $e) {
            echo $e->getMessage();
            die();
        }

        return $this->dbconn;

    }

}


?>