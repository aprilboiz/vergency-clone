<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/session.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/essentials.php";

$default_ava = "https://icon-library.com/images/default-profile-icon/default-profile-icon-24.jpg";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = normalize_input($_POST["customer"]["email"]);
    $user_password = normalize_input($_POST["customer"]["password"]);

    $conn = new mysqli($serverName, $username, $password, $dbName);
    $sql = "SELECT * 
                FROM account
                JOIN member ON account.email = member.email
                WHERE account.email = '" . $email . "'";


    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row["email"] == $email && $row["password"] == $user_password) {
            $_SESSION["user"]["username"] = $email;
            $_SESSION["user"]["phone_number"] = $row["phone_number"];

            $_SESSION["user"]["full_name"] = $row["first_name"] . " " . $row["last_name"];
            // check for user's avatar, if not, use the default avatar
            if (strlen($row["avatar"]) > 0) {
                $_SESSION["user"]["avatar"] = $row["avatar"];
            } else {
                $_SESSION["user"]["avatar"] = $default_ava;
            }

            // check if user is an admin
            if ($row["type"] != "admin") {
                $_SESSION["isAdmin"] = false;
            } else {
                $_SESSION["isAdmin"] = true;
            }

            echo "Logged in successfully!";
        }
    } else {
        echo "Wrong username/ password!";
    }
}
$conn->close();
?>