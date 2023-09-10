<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/session.php";

session_unset();
session_destroy();

// echo "Logged out successfully.";

// echo $_SERVER["DOCUMENT_ROOT"]."\index.php";

header("Location: ../../index.php");

?>