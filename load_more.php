<?php
$offset = $_POST["offset"];
$type = $_POST["type"];

$serverName = "localhost";
$username = "root";
$password = "";
$dbName = "vergency";

$fmt = new NumberFormatter("vi-VN", NumberFormatter::CURRENCY);

$conn = new mysqli($serverName, $username, $password, $dbName);
if ($type != "all") {
    $sql = "SELECT product.name, product.price, product.old_price, product_image.img_1
            FROM product
            JOIN product_image ON product.id = product_image.id
            WHERE product.type = '" . $type . "'
            LIMIT 10 OFFSET " . $offset . ";";

} else {
    $sql = "SELECT product.name, product.price, product.old_price, product_image.img_1
            FROM product
            JOIN product_image ON product.id = product_image.id
            LIMIT 10 OFFSET " . $offset . ";";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="product__information">
                <div class="product__img">
                    <a href="./product.php?product=' . strtolower(str_replace(array(' ', '/'), '-', $row["name"])) . '"><img src="' . $row["img_1"] . '" alt=""></a>
                </div>
                <div class="product__detail">
                    <a href="./product.php?product=' . strtolower(str_replace(array(' ', '/'), '-', $row["name"])) . '" class="product__name">' . $row["name"] . '</a>
                    <div class="product__vendor">VERGENCY</div>
                    <div class="product__rating">
                        <ion-icon name="star"></ion-icon>
                        <ion-icon name="star"></ion-icon>
                        <ion-icon name="star"></ion-icon>
                        <ion-icon name="star"></ion-icon>
                        <ion-icon name="star"></ion-icon>
                    </div>
                    <div class="product__price">
                        <div class="product__price-after">' . $fmt->formatCurrency($row["price"], "VND") . '</div>
                        <div class="product__price-before">' . $fmt->formatCurrency($row["old_price"], "VND") . '</div>
                    </div>
                </div>
            </div>';
    }
}
$conn->close();
?>