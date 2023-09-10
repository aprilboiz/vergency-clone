<?php require_once("./session.php")?>
<?php require_once("./essentials.php")?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/normalize.css">
    <link rel="stylesheet" href="./assets/style_collections.css">
    <title><?php echo strtoupper($_GET["type"])?> - Vergency</title>
</head>
<body>
    <?php require "./header.php"?>

    <div class="slider">
        <img class="slider__img" src="https://theme.hstatic.net/200000305259/1000963148/14/collection_image.jpg?v=120" alt="IMG">
    </div>
    
    <div id="container" class="center">
        <div class="all-left-col">
            <div class="drop-down">
                <a class="flex-center-row" href="/all">MENU<ion-icon name="add"></ion-icon></a>
                <ul class="drop-down-menu">
                    <li><a href="./collections.php?type=t-shirts">T-SHIRTS</a></li>
                    <li><a href="./collections.php?type=shirts">SHIRTS</a></li>
                    <li><a href="./collections.php?type=sweaters">SWEATERS</a></li>
                    <li><a href="./collections.php?type=hoodies">HOODIES</a></li>
                    <li><a href="./collections.php?type=shorts">SHORTS</a></li>
                    <li><a href="./collections.php?type=bags">BAGS</a></li>
                    <li><a href="./collections.php?type=perfume">PERFUME</a></li>
                    <li><a href="./collections.php?type=jacket">JACKET</a></li>
                    <li><a href="./collections.php?type=accessories">ACCESSORIES</a></li>
                    <li><a href="./collections.php?type=polo">POLO</a></li>
                </ul>   
            </div>
        </div>

        <div class="all-right-col">
            <div class="border-2px-solid pd16 bg-color-gray mgb16"><?php echo strtoupper($_GET["type"]);?></div>

            <div class="product__container">
                <?php
                // / declare formatter for currency
                $fmt = new NumberFormatter("vi-VN", NumberFormatter::CURRENCY);

                $avaiable_types = array("t-shirts", "shirts", "sweaters", "hoodies", "shorts", "bags", "perfume", "jacket", "accessories", "polo", "all"); // avaiable get types
                $get_type = $_GET["type"];

                // check if request right method "get" and get type is in avaiable types.
                if ($_SERVER["REQUEST_METHOD"] == "GET" && in_array($get_type, $avaiable_types, true)){
                    // "all" type will get all of products in db.
                    $conn = new mysqli($serverName, $username, $password, $dbName);
                    if ($get_type != "all"){
                        $sql = "SELECT product.name, product.price, product.old_price, product_image.img_1
                                FROM product
                                JOIN product_image ON product.id = product_image.id
                                WHERE product.type = '".$get_type."'
                                LIMIT 10 OFFSET 0;";
                    }else{
                        $sql = "SELECT product.name, product.price, product.old_price,  product_image.img_1
                                FROM product
                                JOIN product_image ON product.id = product_image.id
                                LIMIT 10 OFFSET 0;";
                    }

                    $result = $conn->query($sql);
                    $total_rows = $conn->query("SELECT * FROM product;")->num_rows;

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
                }
                $conn->close();
                ?>

                
            </div>
        </div>
    </div>

    <?php require "./footer.html"?>

    <!-- This script serves infinite scrolling function. -->
    <script>
        var total_rows = <?= $total_rows?>;
        var offset = 10;
        
        window.addEventListener('scroll', function(){
            // console.log("inner height: "+window.innerHeight);
            // console.log("pageYOffset: "+window.pageYOffset);
            // console.log("inner + pageY: "+(window.innerHeight + window.pageYOffset));
            // console.log("body offset: "+document.body.offsetHeight);
            if (Math.ceil(window.innerHeight + window.pageYOffset) >= document.body.offsetHeight) {
                // Load additional elements
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'load_more.php');
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.onload = function() {
                    // Append the additional elements to the page
                    var container = document.querySelector('.product__container');
                    container.insertAdjacentHTML('beforeend', xhr.responseText);
                };
                offset += 10;
                xhr.send("offset="+offset+"&type=<?= $get_type?>");
            }
        });
    </script>

</body>
</html>