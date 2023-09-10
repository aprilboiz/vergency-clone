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
    <link rel="stylesheet" href="./assets/style_cart.css">
    <title>Cart - Vergency</title>
</head>
<body>    

    <?php require "header.php"?>

    <?php
        $slug = $_GET["slug"];
        $conn = new mysqli($serverName, $username, $password, $dbName);
        $fmt = new NumberFormatter("vi-VN", NumberFormatter::CURRENCY);

    ?>


    <div id="container">
        <h1>Cart</h1>
        <div class="cart-container">

            <?php
                $subtotal = 0;
                $_SESSION["delivery_fee"] = 35000;

                if (isset($_SESSION["cart"]) && count($_SESSION["cart"]) > 0){
                    $cart = $_SESSION["cart"];
                    // var_dump($cart);

                    echo '<table id="table-cart">                
                            <tbody>';

                    foreach($cart as $product => $product_prop) {
                        $sql = "SELECT *
                                FROM product
                                JOIN product_image ON product.id = product_image.id
                                WHERE product.slug = '".$product."';";
            
                        $result = $conn->query($sql);
                        
                        $row = $result->fetch_assoc();
            
                        echo '<tr>
                                <td class="image">
                                    <a href="./product.php?slug='.$product.'">
                                        <img src="'.$row["img_1"].'" alt="'.$row["name"].'">
                                    </a>
                                </td>
                                <td class="item">
                                    <a class="item-name" href="./product.php?slug='.$product.'">'.$row["name"].'</a>
                                    <br>
                                    <div class="item-variant">
                                        <span>'.$product_prop["size"].'</span>
                                    </div>
                                    <div class="item-price">
                                        <p>'.$fmt->formatCurrency($row["price"], "VND").' <del>('.$fmt->formatCurrency($row["old_price"], "VND").')</del></p>
                                    </div>
                                    <input class="item-quantity" type="text" value="'.$product_prop["quantity"].'">
                                    <div class="item-final-price">'.$fmt->formatCurrency($row["price"]*$product_prop["quantity"], "VND").'</div>
                                </td>
                                <td class="remove">
                                    <button class="remove__button">Delete</button>
                                </td>
                            </tr>';
                        
                            $subtotal += $row["price"]*$product_prop["quantity"];
                            $_SESSION["subtotal"] = $subtotal;
                    }

                    echo '</tbody>
                    </table>';
                }else{
                    echo '<div class="no-product">No product in cart!</div>';
                }
            ?>

            <div class="cart-summary">
                <h1>YOUR ORDER</h1>
                <div class="cart-total">
                    <h2>
                        <label>Subtotal</label>
                        <label class="total-price"><?=$fmt->formatCurrency($subtotal, "VND")?></label>
                    </h2>
                    <div class="checkout">Pay</div>
                </div>
            </div>
        </div>
        
    </div>

    <?php require "footer.html"?>

    <script>

        // event listener for delete button
        let rmove = document.querySelectorAll(".remove");
        for (let i = 0; i < rmove.length; i++){
            rmove[i].addEventListener("click", (function(index) {
                return function() {
                    window.location = "handle_cart.php?type=delete&idx="+index;
                }
            })(i))
        }

        // event listener for update product's quantity
        let inp_quantity = document.querySelectorAll(".item-quantity");
        for (let i = 0; i < inp_quantity.length; i++){
            inp_quantity[i].addEventListener("keydown", function(e){
                if (e.code == "Enter"){
                    (function(index){
                        let quantity = inp_quantity[index].value;
                        // console.log(index);
                        // console.log(quantity);
                        window.location = "handle_cart.php?type=update&idx="+index+"&prop=quantity&val="+quantity;
                    }(i))
                }
            })
        }

        // event listener for checkout button
        let checkout_btn = document.querySelector(".checkout");
        checkout_btn.addEventListener("click", function(){
            fetch("handle_cart.php?type=checkout")
            .then(function(response){
                response.text().then(data => {
                    switch (data) {
                        case '100':
                            alert("You are not logged in!");
                            window.location = "./account/login.php";
                            break;
                        case '200':
                            window.location = "checkout.php";
                            break;
                        case '300':
                            alert("Your shopping cart is empty.");
                            window.location = "index.php";
                            break;
                        default:
                            break;
                    }
                })
            })
        })
    </script>
</body>
</html>