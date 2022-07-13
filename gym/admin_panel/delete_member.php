<?php

require "gym_members.php";

$delete = new Members();

$delete->Delete($_POST["id_member"]);

?>