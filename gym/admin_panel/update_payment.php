<?php

require "gym_members.php";

$updatePayment = new Payment();

$updatePayment->Update($_POST["paymentID"],$_POST["amountEdit"],$_POST["date_paymentEdit"],$_POST["payment_typeEdit"]);



?>