<?php

require "gym_members.php";

$trainer = new Trainer();

$trainer->AddTrainer($_POST["name"],$_POST["lastName"],$_POST["trainerID"],$_POST["phone"]);


?>