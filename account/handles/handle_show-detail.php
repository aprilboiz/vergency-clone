<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/essentials.php";

if ($_SERVER["REQUEST_METHOD"] == "GET"){
    $id = $_GET["id"];

    $conn = new mysqli($serverName, $username, $password, $dbName);
    $fmt = new NumberFormatter("vi-VN", NumberFormatter::CURRENCY);

    $total = 0;

    $sql = "SELECT *
            FROM invoice_detail
            JOIN invoice ON invoice.id = invoice_detail.invoice_id
            WHERE invoice.id =".$id.";";

    $result = $conn->query($sql);

    if ($result->num_rows > 0){
        while ($row = $result->fetch_assoc()){
            echo '<tr>
                    <td style="text-align: center;padding: 10px;">'.$row["product_name"].'</td>
                    <td style="text-align: center;padding: 10px;">'.$row["product_quantity"].'</td>
                    <td style="text-align: center;padding: 10px;">'.$fmt->formatCurrency($row["product_price"], "VND").'</td>
                    <td style="text-align: center;padding: 10px;">'.$fmt->formatCurrency($row["product_price"], "VND").'</td>
                </tr>';
            $total += $row["product_price"];
        }
        echo '<tr> <td colspan="3" style="text-align: center;padding: 10px;font-weight:bold;">Total</td> <td style="text-align: center;padding: 10px; font-weight: bold; font-size:18px">'.$fmt->formatCurrency($total, "VND").'</td></tr>';
    }else{
        echo "No result!";
    }
}
?>