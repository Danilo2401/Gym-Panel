<?php

require "gym_members.php";

$deleteTrainer = new Trainer();

$deleteTrainer->Delete($_POST["id_trainer"]);


?>