<?php

require "gym_members.php";

$paymentAdd = new Payment();

$paymentAdd->AddPayment($_POST["amount"],$_POST["date_payment"],$_POST["payment_type"],$_POST["member"]);



?>