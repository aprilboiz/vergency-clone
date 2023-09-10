<?php
require "session.php";
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $slug = $_GET["slug"];
    $size = $_GET["size"];

    if (isset($_SESSION["cart"])) {
        if (isset($_SESSION["cart"][$slug])) {
            $_SESSION["cart"][$slug]["quantity"] += 1;
        } else {
            $_SESSION["cart"][$slug] = array("quantity" => 1, "size" => $size);
        }
    } else {
        $_SESSION["cart"][$slug] = array("quantity" => 1, "size" => $size);
    }

    header("Location: ./cart.php");
    exit();
    // var_dump($_SESSION["cart"]);
}
?>