<?php
require_once("../session.php");
require_once("../essentials.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/normalize.css">
    <link rel="stylesheet" href="./style_login.css">
    <title>Login - Vergency</title>
</head>
<body>
    
    <?php require "./templates/header.php"?>

    <div id="login" class="center">
        <h1>LOGIN</h1>
        <div id="noti-zone"></div>
        <form action="./handles/handle_login.php" method="post">
            <input required type="email" name="customer[email]" id="customer_email" placeholder="Email" class="form-control"> 
            <input required type="password" name="customer[password]" id="customer_password" placeholder="Password" class="form-control">
            <div class="login-control">
                <span><a class="login-control-forgot-pwd" href="./forgot-password.html">Forget Password</a></span>
                <input class="login-btn" type="submit" value="Login" > 
            </div>
        </form>
        <span>You don't have account? <a class="login-control-forgot-pwd" href="./register.php">Create a new account</a></span>
    </div>

    <?php require "./templates/footer.html"?>

    <script>
        function js_sleep(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        };

        async function handle_response(responseText){
            var notiZone = document.getElementById("noti-zone");
            notiZone.innerHTML = responseText;
            if (responseText.toLowerCase().includes("wrong")){
                notiZone.style.color = "red";
            }else{
                notiZone.style.color = "green";
            };
            await js_sleep(1500);
            window.location = "../index.php";
        }

        document.querySelector("form").addEventListener("submit", function(e){
            e.preventDefault();
            
            var form = e.target;
            var data = new FormData(form);
            
            var xhr = new XMLHttpRequest();
            xhr.open(form.method, form.action);
            xhr.onload = function(){
                if (xhr.status == 200){
                    handle_response(xhr.responseText);
                }
            }
            xhr.send(data);
        })
    </script>
</body>
</html>