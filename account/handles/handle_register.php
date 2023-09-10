<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/essentials.php";

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = normalize_input($_POST["customer"]["email"]);
    $phone_number = normalize_input($_POST["customer"]["phone_number"]);
    $user_password = normalize_input($_POST["customer"]["password"]);
    $password_retype = normalize_input($_POST["customer"]["password_retype"]);
    $first_name = normalize_input($_POST["customer"]["first_name"]);
    $last_name = normalize_input($_POST["customer"]["last_name"]);
    $gender = normalize_input($_POST["customer"]["gender"]);
    $dob = normalize_input($_POST["customer"]["dob"]);

    $conn = new mysqli($serverName, $username, $password, $dbName);

    $sql = "INSERT INTO `member`(`member_id`, `email`, `phone_number`, `last_name`, `first_name`, `gender`, `date_of_birth`, `avatar`)
            VALUES (DEFAULT,'".$email."','".$phone_number."','".$last_name."','".$first_name."','".$gender."','".$dob."', '');";
    
    $sql .= "INSERT INTO `account` (`account_id`, `username`, `email`, `password`, `type`)
            VALUES (DEFAULT, '".$email."', '".$email."', '".$user_password."', 'user');";
    
    if ($conn->multi_query($sql) === TRUE) {
        echo "Created account successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    if ($conn->query($sql) === TRUE) {
        echo "Created account successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$conn->close();
?>