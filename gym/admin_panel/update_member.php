<?php

require "gym_members.php";

$update = new Members();

$update->Update($_POST["id_member"],$_POST["nameEdit"],$_POST["lastNameEdit"],$_POST["emailEdit"],$_POST["trainerEdit"]);

?>
