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
    <link rel="stylesheet" href="./style_contact.css">
    <title>Contact - Vergency</title>
</head>
<body>
    
    <?php require "./templates/header.php"?>

    <div id="container">
        <div class="page-right-title">
            <span>We'll connect immediately when you need help.</span>
        </div>	
        <div class="phone">
            <ion-icon name="business"></ion-icon> <span>Vergency.</span>
        </div>
        <div class="phone">
            <ion-icon name="call"></ion-icon> <span>037 335 7405.</span>
        </div>
        <div class="address">
            <ion-icon name="map"></ion-icon> <span>891 Huong Lo 2, Binh Tri Dong A, Binh Tan, Ho Chi Minh City (AM: 08:30 -> 11:45, PM: 13:30 -> 17:45). Please go on time . Vergency thanks !</span>
        </div>				
        <div class="address">
            <ion-icon name="mail"></ion-icon> <span>vergency.contact@gmail.com</span>
        </div>
    </div>

    <?php require "./templates/footer.html"?>
    
</body>
</html>