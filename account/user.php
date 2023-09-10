<?php
    require_once "../session.php";
    require_once "../essentials.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/normalize.css">
    <link rel="stylesheet" href="./style_user.css">
    <title>Vergency</title>
</head>
<body>
    <?php require "./templates/header.php"?>
    <?php
        $default_ava = "https://icon-library.com/images/default-profile-icon/default-profile-icon-24.jpg";
        $name = $_SESSION["user"]["full_name"];
        $avatar = $_SESSION["user"]["avatar"];
        $email = $_SESSION["user"]["username"];

        $conn = new mysqli($serverName, $username, $password, $dbName);
        $fmt = new NumberFormatter("vi-VN", NumberFormatter::CURRENCY);
    ?>
    <div id="container">
        <div class="account_panel" style="position:relative">
            <div class="account_panel-info">
                <div class="account_panel-info_ava">
                    <img src="<?php echo $avatar?>" alt="Avatar">
                </div>
                <div class="account_panel-info_name"><?php echo $name?></div>
            </div>
            <ul class="account_panel-features">
                <li class="feature"><a href="">Purchased orders.</a></li>
                <!-- <li class="feature"><a href="">Chinh sua thong tin</a></li> -->
                <button id="myButton" style="
    position: absolute;
    bottom: 0;
    right: 0;
    margin: 10px;
    cursor: pointer;
">Click me to log out.</button>
            </ul>

        </div>
        <div class="history_panel">
            <h1 class="history_panel-header">Order History</h1>
            <?php
                echo '<table class="history_panel-order">
                    <tr>
                        <th style="width:25%; text-align:center;">Order ID</th>
                        <th style="width:25%; text-align:center;">Date</th>
                        <th style="width:25%; text-align:center;">Total</th>
                        <th style="width:25%; text-align:center;">Detail</th>
                    </tr>';
                $sql = "SELECT SUM(product_price) as total, invoice.date_purchased, invoice.id
                        FROM invoice
                        JOIN invoice_detail ON invoice.id = invoice_detail.invoice_id
                        WHERE invoice.member_email = '".$email."'
                        GROUP BY date_purchased;";
                
                $result = $conn->query($sql);

                if ($result->num_rows > 0){
                    while ($row = $result->fetch_assoc()){
                        echo '<tr>
                                <td class="id">'.$row["id"].'</td>
                                <td class="date">'.$row["date_purchased"].'</td>
                                <td class="total">'.$fmt->formatCurrency($row["total"], "VND").'</td>
                                <td class="detail">
                                    <button onclick="showDetail('.$row["id"].');">DETAIL</button>
                                </td>
                            </tr>';
                    }
                }
                
                
                echo '</table>';
            ?>
            
        </div>

    </div>
    <div id="popup">
        <div class="popup_content">
            <div class="popup_content-header">
                Detail Information
                <span class="close-button">
                    <ion-icon name="close-outline"></ion-icon>
                </span>
            </div>
            <div class="popup_content-body">
                <!-- <table style="width:100%;">
                    <tr>
                        <th style="width:25%; text-align:center; padding:10px; font-weight:bold">Customer Name</th>
                        <th style="width:25%; text-align:center; padding:10px; font-weight:bold">Phone Number</th>
                        <th style="width:25%; text-align:center; padding:10px; font-weight:bold">Price</th>
                    </tr>
                    <tbody>

                    </tbody>
                </table> -->
                <table style="width:100%;">
                    <tr>
                        <th style="width:25%; text-align:center; padding:10px; font-weight:bold">Product Name</th>
                        <th style="width:25%; text-align:center; padding:10px; font-weight:bold">Quantity</th>
                        <th style="width:25%; text-align:center; padding:10px; font-weight:bold">Price</th>
                        <th style="width:25%; text-align:center; padding:10px; font-weight:bold">Subtotal</th>
                    </tr>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
            <div class="popup_content-footer"></div>
        </div>
    </div>
    <?php require "./templates/footer.html"?>

    <script>
        document.getElementById("myButton").addEventListener("click", function() {
            window.location = "./handles/handle_logout.php";
        });
    </script>

    <script>
        let popup_outside =document.querySelector("#popup");
        let header_closeBtn =document.querySelector(".close-button");
        let tableBody =document.querySelector(".popup_content-body>table>tbody");

        function showDetail(id){
            popup_outside.style.display = "flex";

            let xhr = new XMLHttpRequest();
            xhr.open("GET", "./handles/handle_show-detail.php?id="+id);
            xhr.onload = function(){
                if (xhr.status == 200){
                    tableBody.insertAdjacentHTML("beforeend", xhr.responseText);
                }
            }
            xhr.send();
        }

        popup_outside.addEventListener("click", function(){
            popup_outside.style.display = "none";
            tableBody.innerHTML = '<tr><th style="width:25%; text-align:center; padding:10px; font-weight:bold">Product Name</th><th style="width:25%; text-align:center; padding:10px; font-weight:bold">Quantity</th><th style="width:25%; text-align:center; padding:10px; font-weight:bold">Price</th><th style="width:25%; text-align:center; padding:10px; font-weight:bold">Subtotal</th></tr>';
        })
        
        header_closeBtn.addEventListener("click", function(){
            popup_outside.style.display = "none";
            tableBody.innerHTML = '<tr><th style="width:25%; text-align:center; padding:10px; font-weight:bold">Product Name</th><th style="width:25%; text-align:center; padding:10px; font-weight:bold">Quantity</th><th style="width:25%; text-align:center; padding:10px; font-weight:bold">Price</th><th style="width:25%; text-align:center; padding:10px; font-weight:bold">Subtotal</th></tr>';
        })
    </script>

    <script>
        
    </script>
</body>
</html>


