<?php
    require "session.php";
    // unset($_SESSION["cart"]);
    // slug =>
    //     quantity =>
    //     size =>
    $cart = $_SESSION["cart"];

    // var_dump($cart);
    // for ($i=0; $i< count($cart); $i++){
    //     echo $cart[$i]["quantity"]." ".$cart[$i]["size"]."<br>";
    // }
    foreach($cart as $product => $product_prop) {
        echo "Key=" . $product;
        echo "<br>";
        foreach($product_prop as $p => $p_value){
            echo "Key=" . $p . ", Value=" . $p_value;
            echo "<br>";
        }
    }
?>