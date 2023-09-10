<?php 
session_start();

function isAdminLogged(){
    if (isset($_SESSION["user"]["username"]) && isset($_SESSION["isAdmin"])){
        if ($_SESSION["isAdmin"] == true) return true;
    }
    return false;
};

function isAnyLogged(){
    if (isset($_SESSION["user"]["username"])) return true;
    return false;
}
?>