<?php require_once("../session.php")?>
<?php require_once("../essentials.php")?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/normalize.css">
    <link rel="stylesheet" href="./style_register.css">
    <title>Register - Vergency</title>
</head>
<body>
    <?php require "./templates/header.php"?>
    
    
    <div id="register" class="center">
        <h1>REGISTER</h1>
        <div id="noti-zone"></div>
        <form name="register-form" action="./handles/handle_register.php" method="post" onsubmit="return validateForm();">
            <!-- first name -->
            <input class="form-control" required type="text" name="customer[first_name]" id="customer_first-name" placeholder="First name">
            <!-- last name -->
            <input class="form-control" type="text" name="customer[last_name]" id="customer_last-name" placeholder="Last name">
            <!-- dob -->
            <div class="dob">
                Date of birth:
                <input class="form-control" required type="date" name="customer[dob]" id="customer_dob" placeholder="Date of birth">
            </div>
            <!-- email -->
            <input class="form-control" required type="email" name="customer[email]" id="customer_email" placeholder="Email">
            <!-- phone -->
            <input class="form-control" required type="tel" name="customer[phone_number]" id="customer_phonenumber" placeholder="Phone number">
            <!-- password -->
            <input class="form-control" required type="password" name="customer[password]" id="customer_password" placeholder="Password">
            <input class="form-control" required type="password" name="customer[password_retype]" id="customer_password_retype" placeholder="Confirm password">
            <!-- gender -->
            <div class="gender">
                Gender: 
                <input class="form-btn" type="radio" name="customer[gender]" value="Male">Male
                <input class="form-btn" type="radio" name="customer[gender]" value="Female">Female
                <input class="form-btn" type="radio" name="customer[gender]" value="Other">Other
            </div>
            <!-- sm btn -->
            <input class="register-form-btn" type="submit" value="Register">
        </form>
    </div>


    <?php require "./templates/footer.html"?>

    <script src="./scripts/validate.js"></script>
    <script>
        function js_sleep(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        };

        async function handle_response(responseText){
            var notiZone = document.getElementById("noti-zone");
            notiZone.innerHTML = responseText;
            notiZone.style.color = "green";
            await js_sleep(1500);
            window.location = "./login.php";
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