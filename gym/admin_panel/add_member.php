<?php

require "gym_members.php";

$addMember = new Members();

$addMember->AddMember($_POST["name"],$_POST["lastName"],$_POST["email"],$_POST["memberID"],$_POST["trainer"]);

?>