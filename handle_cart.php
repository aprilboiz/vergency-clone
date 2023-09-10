<?php

    require_once ("session.php");

    function update_quantity(){
        $i = 0;
        
        foreach($_SESSION["cart"] as &$product){
            if ($i == $_GET["idx"]){
                $product[$_GET["prop"]] = (int)$_GET["val"];
                header("Location: cart.php");
                exit();
            }else{
                $i++;
            }
        }
    }

    function delete_product(){
        $i = 0;

        foreach($_SESSION["cart"] as $product => $product_val){
            if ($i == $_GET["idx"]){
                unset($_SESSION["cart"][$product]);
                header("Location: cart.php");
                exit();
            }else{
                $i++;
            }
        }
    }

    function checkout(){
        // return:
        // 100 -> not login
        // 200 -> ok
        // 300 -> logged in but don't have any product in cart.
        
        if (isAnyLogged()){
            if (isset($_SESSION["cart"]) && count($_SESSION["cart"]) > 0){
                echo 200;
            }else{
                echo 300;
            }
        }else{
            echo 100;
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "GET"){
        $type = $_GET["type"];
        switch ($type) {
            case 'update':
                update_quantity();
                break;
            case 'delete':
                delete_product();
                break;
            case 'checkout':
                checkout();
                break;
            default:
                # code...
                break;
        }
    }


    // cart's structure

    // slug =>
    //     quantity => 
    //     size =>
?>