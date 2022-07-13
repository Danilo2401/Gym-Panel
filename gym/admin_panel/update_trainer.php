<?php

require "gym_members.php";

$updateTrainer = new Trainer();

$updateTrainer->Update($_POST["id_trainer"],$_POST["nameEdit"],$_POST["lastNameEdit"],$_POST["phoneEdit"]);

?>