<?php

require "admin_database.php";


class Admin extends DatabaseAdmin{

    private $name_admin;
    private $password_admin;

    public function LogIn($name_admin,$password_admin){

     $this->name_admin = $name_admin;
     $this->password_admin = $password_admin;
 
     $select = "SELECT * FROM gym.admin_panel where name_admin = :name_admin and password_admin = :password_admin ";

     $selectUser = parent::SetConnection()->prepare($select);

     $selectUser->bindParam(":name_admin",$this->name_admin);
     $selectUser->bindParam(":password_admin",$this->password_admin);

     $selectUser->execute();
 
     if(empty($name_admin) || empty($password_admin)){
         echo "<h2>Check yout inputs!</h2>";
     }
     else if(!isset($password_admin) || !isset($name_admin)){
         echo "<h2>Check yout inputs!</h2>";
     }else{
          if ($selectUser->rowCount() > 0) {
               session_start();
               $_SESSION["name_admin"] = $name_admin;
               $_SESSION["password_admin"] = $password_admin;
               header("Location:admin_panel/admin_panel.php");
          }
     }

 }

}


?>