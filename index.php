<?php
require_once("./session.php");
require_once("./essentials.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/normalize.css">
    <link rel="stylesheet" href="./assets/style.css">
    <title>Vergency</title>
</head>
<body>
    <?php include "./header.php"?>

    <div id="slider">
        <img src="https://theme.hstatic.net/200000305259/1000958796/14/slide_index_2.jpg?v=11" alt="" class="slider__img">
        <div class="slider__container">
            <div class="slider__items">
                <div class="slider__items-icon"><ion-icon class="icon icon-disabled" name="car"></ion-icon></div>
                <h2 class="slider__items-title">NATIONWIDE DELIVERY</h2>
                <div class="slider__items-description">Delivery time is flexible from 3 - 4 - 5 days depending on the region, sometimes it will be faster or slower. Hope customers understand and try to wait for the goods to help the shop.</div>
            </div>
            <div class="slider__items">
                <div class="slider__items-icon"><ion-icon class="icon icon-disabled" name="swap-horizontal"></ion-icon></div>
                <h2 class="slider__items-title">RETURN POLICY</h2>
                <div class="slider__items-description">Products are allowed to be exchanged within 36 hours if there is an error from the manufacturer (Request: clear, detailed and complete image of the defective part).</div>
            </div>
            <div class="slider__items">
                <div class="slider__items-icon"><ion-icon class="icon icon-disabled" name="car"></ion-icon></div>
                <h2 class="slider__items-title">DELIVERY GET MONEY AND CHECK YOUR ORDER</h2>
                <div class="slider__items-description">Allowed to inspect goods before payment. Note: In case the customer has received the goods home, please record a video of unboxing the order in an intact condition to have a basis to confirm that the order has a problem, in case there is no video shop can not support.</div>
            </div>
            <div class="slider__items">
                <div class="slider__items-icon"><ion-icon class="icon icon-disabled" name="car"></ion-icon></div>
                <h2 class="slider__items-title">ORDER ONLINE AND CHECK ORDER PLEASE CONTACT US</h2>
                <div class="slider__items-description">Hotline: 037 335 7405.</div>
            </div>
        </div>
    </div>


    <div id="container">
        <div class="title-block">
            <div class="wrap-content">
                <h3 class="title-group">VERGENCY</h3>
                <div class="title-group-note">Satisfy You - Happy Us.</div>
            </div>
        </div>

        <div class="product__container">
            <?php
                // declare formatter for currency
                $fmt = new NumberFormatter("vi-VN", NumberFormatter::CURRENCY);

                $conn = new mysqli($serverName, $username, $password, $dbName);
                if ($conn->connect_error){
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT product.name, product.price, product.old_price, product_image.img_1
                        FROM product
                        JOIN product_image ON product.id = product_image.id
                        LIMIT 20;";

                $result = $conn->query($sql);

                if ($result->num_rows > 0){
                    while ($row = $result->fetch_assoc()){
                        echo '<div class="product__information">
                                <div class="product__img">
                                    <a href="./product.php?product='.strtolower(str_replace(array(' ', '/'), '-', $row["name"])).'"><img src="'.$row["img_1"].'" alt=""></a>
                                </div>
                                <div class="product__detail">
                                    <a href="./product.php?product='.strtolower(str_replace(array(' ', '/'), '-', $row["name"])).'" class="product__name">'.$row["name"].'</a>
                                    <div class="product__vendor">VERGENCY</div>
                                    <div class="product__rating">
                                        <ion-icon name="star"></ion-icon>
                                        <ion-icon name="star"></ion-icon>
                                        <ion-icon name="star"></ion-icon>
                                        <ion-icon name="star"></ion-icon>
                                        <ion-icon name="star"></ion-icon>
                                    </div>
                                    <div class="product__price">
                                        <div class="product__price-after">'.$fmt->formatCurrency($row["price"], "VND").'</div>
                                        <div class="product__price-before">'.$fmt->formatCurrency($row["old_price"], "VND").'</div>
                                    </div>
                                </div>
                            </div>';
                    }
                }
                $conn->close();
            ?> 
        </div>
        <div class="see-more-btn"><a href="./collections.php?type=all" class="">See more</a></div>
    </div>


    <?php include "./footer.html" ?>
</body>
</html>