<?php

require_once "admin_login/admin.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gym</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="admin_login/style.css">
</head>
<body>


<div class="container" id="form-panel">

<form action="index.php" method="post">

    <div class="col-sm-6 text-center m-auto">
        <div class="mb-3 mt-3">
            <label for="name_admin" class="form-label">Name:</label>
            <input type="text" class="form-control" id="name_admin"  placeholder="Enter name" name="name_admin" >
        </div>
        <div class="mb-3">
            <label for="password_admin" class="form-label">Password:</label>
            <input type="password" class="form-control" id="password_admin"  placeholder="Enter password" name="password_admin" >
        </div>
        <input type="submit" class="btn btn-success mt-4 w-25" name="login" id="login" value="Log in">

        <?php

        if (isset($_POST["login"])) {
            require_once "admin_login/admin.php";
            $admin = new Admin();
            $admin->LogIn($_POST["name_admin"],$_POST["password_admin"]);
        }

        ?>

    </div>
</form>

</div>

</div>

</body>
</html>