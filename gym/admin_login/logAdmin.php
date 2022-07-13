<?php

require "admin.php";

$admin = new Admin();

$admin->ShowAdmin($_POST["name"],$_POST["password"]);

?>