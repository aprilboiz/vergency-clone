<?php require_once("./session.php")?>
<?php require_once("./essentials.php")?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/normalize.css">
    <link rel="stylesheet" href="./assets/style_product.css">
    <title>Vergency</title>
</head>
<body>
    <?php require "./header.php"?>

    <div id="container" class="center">
        <div class="all-left-col">
            <div class="drop-down">
                <a class="flex-center-row" href="/collections.php?type=all">MENU<ion-icon name="add"></ion-icon></a>
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

        <div class="container-product">
            <!-- query for product -->
            <?php
            // declare formatter for currency
            $fmt = new NumberFormatter("vi-VN", NumberFormatter::CURRENCY);

            if ($_SERVER["REQUEST_METHOD"] == "GET"){
                $product_slug = $_GET["product"];
                $conn = new mysqli($serverName, $username, $password, $dbName);
                if ($conn->connect_error){
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT product.name, product.price, product_image.img_1
                        FROM product
                        JOIN product_image ON product.id = product_image.id
                        WHERE product.slug = '".$product_slug."';";

                $result = $conn->query($sql);
                if ($result->num_rows > 0){
                    $row = $result->fetch_assoc();

                    // update page's title
                    $page_title = $row["name"]." - Vergency";
                    echo "<script>document.title = '" . $page_title . "';</script>";

                    // display product
                    echo '<div class="img-product">
                            <img src="'.$row["img_1"].'" alt="'.$row["name"].'">
                        </div>
                        <div class="detail-product">
                            <div class="col-product boil-title name-product"> <h3>'.strtoupper($row["name"]).'</h3> </div>
                            <div class="col-product light-title price-product"> <h3>'.$fmt->formatCurrency($row["price"], "VND").'</h3> </div>';
                }
            }
            ?>
                <div class="col-product light-title size-product">
                    <p>Size:</p>
                    <br>
                    <select name="size-shirt" id="size-shirt">
                        <option value selected disabled>Choose Size</option>
                        <option value="SIZE 1">SIZE M</option>
                        <option value="SIZE 2">SIZE X</option>
                        <option value="SIZE 3">SIZE XL</option>
                        <option value="SIZE 4">SIZE XXL</option>
                    </select>
                </div>
                <div class="col-product light-title amount-product"></div>
                <div class="col-product light-title buy-product">
                    <button type="submit" class="button-submit">Add to your cart</button>
                    <div style="margin-top: 10px;" id="noti-zone"></div>
                </div>
                <div class="boil-title information-product" id="information-product">
                    <button onclick="showInfo()">Delivery infomation </button>
                    <div class="information-product-detail" id="information-product-detail">
                        <p class="light-title">
                            VERGENCY
                            <br>
                            NATIONWIDE DELIVERY 
                            <br>
                            Delivery time is flexible from 3 - 4 - 5 days depending on the region, sometimes it will be faster or slower. Hope customers understand and try to wait for the goods to help the shop.
                        </p>
                    </div> 
                </div>
                <div class="boil-title information-product">
                    <button onclick="showSize()">Size table</button>
                    <div class="information-product-detail" id="information-product-size">
                        <p class="light-title">
                            The shirt form is Fit size according to the form and relative standards of Vietnamese people, if you are considering between two sizes, you should choose a larger size.
                        </p>
                        <img class="minisize" src="https://file.hstatic.net/200000305259/file/vgc-tee_size_chart_2022-01_2959575c7c944ed2b56b14f7bc42a7c3_master.jpg">
                    </div> 
                </div>
                <div class="boil-title information-product">
                    <button onclick="showRefund()">Refund Policy</button>
                    <div class="information-product-detail" id="information-product-refund">
                        <p class="light-title">
                            In order to bring you convenience and a great shopping experience, we have developed a door-to-door exchange service and a warranty policy.
                        </p>
                    </div> 
                </div>
            </div>
        </div>
    </div>

    <?php require "./footer.html"?>

    <script>
        let submit_btn = document.querySelector(".button-submit");

        submit_btn.addEventListener("click", function(){
            let product_slug = "<?=$product_slug?>";
            let product_size = document.querySelector("#size-shirt").value;

            if (product_size){
                let params = "?slug="+product_slug+"&size="+product_size;
                window.location = "handle_product.php"+params;
            }else{
                let notiZone = document.querySelector("#noti-zone");
                notiZone.innerHTML = "You have to choose the size!"
                notiZone.style.color = "red";
            }
        });
    </script>
</body>
</html>