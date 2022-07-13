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

<form action="#" method="post">

<div class="col-sm-6 text-center m-auto">
<div class="mb-3 mt-3">
    <label for="name" class="form-label">Name:</label>
    <input type="text" class="form-control" id="name"  placeholder="Enter name" name="name" >
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Password:</label>
    <input type="password" class="form-control" id="password"  placeholder="Enter password" name="password" >
  </div>
  <input type="button" class="btn btn-success mt-4 w-25" id="login" value="Log in">
  
</form>

</div>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script>
$(document).ready(function(){

$("#login").on("click",function(e){

   let name = $("#name").val();
   let password = $("#password").val();

    
        $.ajax({
            url:"admin_login/logAdmin.php",
            type:"POST",
            data:{
                name:name,
                password:password
            },
            dataType:"xml",
            success:function(res){
                let message = $(res).find("message").first().text();

                if (message == "You have successfully logged!") {
                    window.location.href = "admin_panel/admin_panel.php";
                }else if(message == "Sir,please check inputs again!"){
                    alert("Sir,please check inputs again!");
                }
            },
            error:function(){
                alert("Error!");
            }
        });

});

});
</script>

</body>
</html>