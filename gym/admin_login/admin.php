<?php

require "admin_database.php";


class Admin extends DatabaseAdmin{

    private $name_admin;
    private $password_admin;

    function ShowAdmin($name,$password){

        $this->name_admin = $name;
        $this->password_admin = $password;

       $show =  "SELECT * from gym.admin_panel WHERE name_admin = :name_admin and password_admin = :password_admin";

       $admin = parent::SetConnection()->prepare($show);

       $xmlFile = new SimpleXMLElement("<?xml version='1.0' encoding='utf-8'?><messages></messages>");

       if ($this->name_admin != "Admin" || $this->password_admin != "Admin26") {
            $message = $xmlFile->addChild("message","Sir,please check inputs again!");
       }else if(!isset($this->name_admin) || empty($this->name_admin)){
            $message = $xmlFile->addChild("message","Sir,please check inputs again!");
       }else if(!isset($this->password_admin) || empty($this->password_admin)){
            $message = $xmlFile->addChild("message","Sir,please check inputs again!");
       }else{

            $admin->bindParam(":name_admin",$this->name_admin);
            $admin->bindParam(":password_admin",$this->password_admin);

            $message = $xmlFile->addChild("message","You have successfully logged!");

            $admin->execute();
       }

        Header("Content-type:text/xml");
        echo $xmlFile->asXML();
    }

}


?>