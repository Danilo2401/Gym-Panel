<?php

session_start();

if(!isset($_SESSION["name_admin"]) || !isset($_SESSION["password_admin"])){
    header("Location:../index.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style2.css">
</head>
<body>

<style>


</style>

<div class="hero-img">
    <img src="hero.jpg" class="img-fluid" alt="hero">
</div>

<div class="row justify-content-around text-center align-items-center mt-2">
    
    <h1 class="admin-heading display-1">Admin Panel</h1>
    <h4 class="display-6"><a href="logout.php" class="text-decoration-none text-primary">Logout</a></h4>    

    <div class="members col-sm-3">
        <div class="list-group">
            <a href="admin_panel.php" class="members-focus list-group-item list-group-item-action active" aria-current="true">
                Members
            </a>
            <a href="member_details.html" class="list-group-item list-group-item-action">Member details</a>
            <a href="package.html" class="list-group-item list-group-item-action">Package details</a>
            <a href="payments.html" class="list-group-item list-group-item-action">Payments</a>
        </div>
        <div class="list-group mt-4">
            <a href="trainer_details.html" class="list-group-item list-group-item-action active">Trainer details</a>
            <a href="trainer.html" class="list-group-item list-group-item-action">Add trainer</a>
        </div>

    </div>

    <div class="col-sm-5 mt-4">
        <h2>Register new members</h2>
        <form action="#" class="p-4" method="POST">
            <div class="pt-4 form-group">
                <label for="name">First name:</label>
                <input type="text" class="form-control" id="name" placeholder="Name">
            </div>
            <div class="pt-4 form-group">
                <label for="lastName">Last name:</label>
                <input type="text" class="form-control" id="lastName" placeholder="Last name">
            </div>
            <div class="pt-4 form-group">
                <label for="email">Email:</label>
                <input type="text" class="form-control" id="email" placeholder="Email">
            </div>
           <div class="pt-4 form-group">
                <label for="memberID">Member ID:</label>
                <input type="text" class="form-control" id="memberID" placeholder="Member ID">
            </div>
            <div class="pt-4 form-group">
                <label for="trainer">Choose a trainer:</label>
                    <select id="trainer">
                    </select>
            </div><br>
            <div class="form-group">
                <input type="button" id="btn-add" style="width:150px"; class="btn btn-primary" value="Add">
            </div>
        </form>
    </div>
</div>

<script>
$(document).ready(function(){

let paymentID = 0;

ReadTrainer();

function ReadTrainer(){

    $.ajax({
        url:"choose_trainer.php",
        type:"POST",
        dataType:"xml",
        success:function(res){

            $(res).find("trainer").each(function(){

                let lastNameXML = $(this).find("lastName_trainer").text();
                let idXML = $(this).find("id_trainer").text();

                $("#trainer").append("<option id="+idXML+" value="+idXML+">"+lastNameXML+"</option>");

            });

        },
        error:function(){
            alert("Error");
        }
    })

}


$("#btn-add").click(function(){
    
    let name = $("#name").val();
    let lastName = $("#lastName").val();
    let email = $("#email").val();
    let memberID = $("#memberID").val();
    let trainer = $("#trainer").val();

    /*console.log(name + lastName + email + memberID + " " + trainer);*/

    $.ajax({
        url:"add_member.php",
        type:"POST",
        data:{
            name:name,
            lastName:lastName,
            email:email,
            memberID:memberID,
            trainer:trainer
        },
        dataType:"xml",
        success:function(res){
            
            var message = $(res).find("message").first().text();

            if(message == "You have been successfully add member."){
                alert("You have been successfully add member.");
                $("#name").val("");
                $("#lastName").val("");
                $("#email").val("");
                $("#memberID").val("");
            }else if(message == "User with that MemberID already exist!"){
                alert("User with that MemberID already exist!");
            }else if(message == "User with that Email already exist!"){
                alert("User with that Email already exist!");
            }else if (message == "Something is wrong with your inputs.") {
                alert("Something is wrong with your inputs.");
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