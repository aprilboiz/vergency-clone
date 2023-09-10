<?php
    require_once("./session.php");
    require_once("./essentials.php");

    $email = $_SESSION["user"]["username"];
    $cart = $_SESSION["cart"];
    $total = $_SESSION["total"];

    $sql = "INSERT INTO `invoice` (`id`, `member_email`, `date_purchased`) VALUES (DEFAULT, '".$email."', current_timestamp())";
    $conn = new mysqli($serverName, $username, $password, $dbName);
    
    $result = $conn->query($sql);

    $last_id = $conn->insert_id;

    
    foreach($cart as $product => $product_val){
        $sql = "SELECT *
                FROM product
                JOIN product_image ON product.id = product_image.id
                WHERE product.slug = '".$product."';";

        $result = $conn->query($sql);
        
        $row = $result->fetch_assoc();

        $sql = "INSERT INTO `invoice_detail` (`id`, `invoice_id`, `product_name`, `product_quantity`, `product_price`, `product_image`, `product_size`) VALUES (DEFAULT, ".$last_id.", '".$row["name"]."', ".$product_val["quantity"].", ".$row["price"]*$product_val["quantity"].", '".$row["img_1"]."', '".$product_val["size"]."')";

        $conn->query($sql);

    }

    $conn->close();

    unset($_SESSION["cart"]);

    header("Location: index.php");
    exit();
?>