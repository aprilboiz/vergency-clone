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
    <link rel="stylesheet" href="./assets/style_checkout.css">
    <title>Checkout - Vergency</title>
</head>
<body>

    <?php
        $conn = new mysqli($serverName, $username, $password, $dbName);
        $fmt = new NumberFormatter("vi-VN", NumberFormatter::CURRENCY);

    ?>

    <div id="container">
        <div class="main">
            <div class="main-header">VERGENCY</div>
            <div class="main-section">
                <div class="section-customer-information">
                    <div class="section-header">Shipment Details</div>
                    <input class="input-field" required type="text" name="checkout[name]" placeholder="Full name" value="<?=$_SESSION["user"]["full_name"]?>">
                    <div class="grid grid-col-6040">
                        <input class="input-field" required type="email" name="checkout[email]" placeholder="Email" value="<?=$_SESSION["user"]["username"]?>">
                        <input class="input-field" required type="tel" name="checkout[phone_number]" placeholder="Phone number" value="<?=$_SESSION["user"]["phone_number"]?>">
                    </div>
                    <input class="input-field" required type="text" name="checkout[address]" placeholder="Address">
                </div>
                <div class="section-shipping">
                    <div class="section-header">Shipping Method</div>
                    <div class="section-box">
                        <div class="shipping-method">
                            <input checked type="radio" name="" id="">
                            Home Delivery (about 3 - 4 days)
                        </div>
                        <div class="shipping-fee"><?=$fmt->formatCurrency(35000, "VND")?></div>
                    </div>
                </div>
                <div class="section-payment">
                    <div class="section-header">Payment Method</div>
                    <div class="section-box-grid">
                        <div class="payment-method">
                            <input  type="radio" name="checkout[payment_method]" id="">
                            Cash On Delivery
                        </div>
                        <div class="payment-method">
                            <input  type="radio" name="checkout[payment_method]" id="">
                            Banking
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-footer">
                <a href="cart.php">Back to Cart</a>
                <button class="next-step" type="submit">Next Step</button>
            </div>
        </div>
        <div class="sidebar">
            <div class="order-summary">
                <?php
                $_SESSION["total"] = $_SESSION["subtotal"]+$_SESSION["delivery_fee"];
                $cart = $_SESSION["cart"];
                echo '<table class="product-table">
                    <thead></thead>
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
                                <div class="image-holder">
                                    <span class="product-quantity">'.$product_prop["quantity"].'</span>
                                    <img src="'.$row["img_1"].'" alt="'.$row["name"].'">
                                </div>
                            </td>
                            <td class="description">
                                <span class="description-name">'.$row["name"].'</span>
                                <span class="description-price">'.$product_prop["size"].'</span>
                            </td>
                            <td class="price">'.$fmt->formatCurrency($row["price"]*$product_prop["quantity"], "VND").'</td>
                        </tr>';
                };

                
                echo '</tbody>
                    </table>';
                ?>
                
                <div class="order-total">
                    <div class="order-sub">
                        <div class="order-sub-line">
                            <div class="order-sub-line_name">Subtotal</div>
                            <div class="order-sub-line_price"><?=$fmt->formatCurrency($_SESSION["subtotal"], "VND")?></div>
                        </div>
                        <div class="order-sub-line">
                            <div class="order-sub-line_name">Delivery fee</div>
                            <div class="order-sub-line_price"><?=$fmt->formatCurrency($_SESSION["delivery_fee"], "VND")?></div>
                        </div>
                    </div>
                    <div class="order-payment">
                        <div class="order-sub-line">
                            <div class="order-sub-line_name">Total</div>
                            <div class="order-sub-line_price"><?=$fmt->formatCurrency($_SESSION["subtotal"]+$_SESSION["delivery_fee"], "VND")?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="noti-zone">Thank you for your order. <br> We will call back soon to confirm the order.</div> -->
    <!-- <div class="count-down"></div> -->

    <script>
        function js_sleep(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        };
        
        
        let nextStep = document.querySelector(".next-step");
        let container = document.querySelector("#container");
        nextStep.addEventListener("click", async function(){
            container.style.display = "flex";
            container.innerHTML = '<div style="margin: auto; font-size: 26px; line-height: 1.6; text-align: center;" class="noti-zone">Thank you for your order. <br> We will call back soon to confirm the order.<div style="margin: auto;font-size: 26px;" class="count-down"></div></div>';
            // container.innerHTML += '<div style="margin: auto;font-size: 26px;" class="count-down"></div>'
            let countDown = document.querySelector(".count-down");
            for (let i=3;i>0;i--){
                countDown.innerHTML = "Back to main page in "+i+" seconds."
                await js_sleep(1000);
            }
            window.location = "handle_checkout.php";
            // window.location = "index.php";
        })
    </script>
</body>
</html>