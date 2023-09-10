<?php require_once("./session.php"); ?>
<?php require_once("./essentials.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/normalize.css">
    <link rel="stylesheet" href="./assets/style_search.css">
    <title>
        <?= $_GET["q"] ?> - Vergency
    </title>
</head>

<body>
    <?php require "header.php" ?>

    <div id="container" class="center">

        <div class="search-for">
            Search for:
            <?= $_GET["q"] ?>
        </div>

        <div class="filter">
            <!-- filter header? -->
            <div class="filter__header">Filter:</div>

            <!-- filter bar -->
            <div class="filter__bar">
                <!-- type filter -->
                <span class="filter__name">Type: </span>
                <select class="filter-item" id="filter-type" class="filter-item" onchange="update_result();">
                    <?php
                    $avaiable_types = array("all", "t-shirts", "shirts", "sweaters", "hoodies", "shorts", "bags", "perfume", "jacket", "accessories", "polo", "all"); // avaiable get types
                    foreach ($avaiable_types as $type) {
                        if ($type == $_GET["type"]) {
                            echo '<option value="' . $type . '" selected>' . strtoupper($type) . '</option>';
                        } else {
                            echo '<option value="' . $type . '">' . strtoupper($type) . '</option>';
                        }
                    }
                    ?>
                </select>

                <!-- price filter -->
                <span class="filter__name">Price: </span>
                <select class="filter-item" id="filter-price" class="filter-item" onchange="update_result();">
                    <?php
                    $avaiable_sort = array("asc" => "ASCENDING", "desc" => "DESCENDING");
                    foreach ($avaiable_sort as $sort => $sort_val) {
                        // echo $sort;
                        if ($sort == $_GET["sort"]) {
                            echo '<option value="' . $sort . '" selected>' . $sort_val . '</option>';
                        } else {
                            echo '<option value="' . $sort . '">' . $sort_val . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
        </div>

        <!-- render results here -->
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $q = $_GET["q"];
            $type = $_GET["type"];
            $sort = $_GET["sort"];

            $fmt = new NumberFormatter("vi-VN", NumberFormatter::CURRENCY);
            $conn = new mysqli($serverName, $username, $password, $dbName);

            if ($type == "all") {
                $sql = "SELECT product.name, product.price, product.old_price, product_image.img_1
                        FROM product
                        JOIN product_image ON product.id = product_image.id
                        WHERE product.name LIKE '%" . $q . "%'
                        ORDER BY product.price " . $sort . ";";
            } else {
                $sql = "SELECT product.name, product.price, product.old_price, product_image.img_1
                        FROM product
                        JOIN product_image ON product.id = product_image.id
                        WHERE product.name LIKE '%" . $q . "%' AND product.type = '" . $type . "'
                        ORDER BY product.price " . $sort . ";";
            }

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo '<div class="product__container">';
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
                echo '</div>';
            } else {
                echo '<div class="search-error">No products found!</div>';
            }
        }
        ?>

    </div>

    <?php require "footer.html" ?>

    <script>
        function update_result() {
            let filter_type = document.querySelector("#filter-type").value;
            let filter_price = document.querySelector("#filter-price").value;

            // get current "q" param in URL
            let params = new URLSearchParams(window.location.search);
            let q = params.get("q");

            // create new URL with new params then update the URL
            let queryString = "?q=" + q + "&sort=" + filter_price + "&type=" + filter_type;

            // update new URL
            window.location = "search.php" + queryString;
        }

    </script>
</body>

</html>