<link rel="stylesheet" href="./../assets/style_header.css">

<header>
    <div class="header__phone flex-center">
        <div class="search">
            <input class="search-box" type="text" placeholder="Search...">
            <ion-icon class="icon search-icon" name="search"></ion-icon>
        </div>
    </div>
    <div class="header__logo flex-center">
        <a class="header__logo" href="../index.php"><img class="header__logo-img" src="https://theme.hstatic.net/200000305259/1000958796/14/partner_1.png?v=11" alt="Vergency"></a>
    </div>
    <div class="header__items center">
        <div class="cart">
            <?php
                if (isset($_SESSION["cart"])){
                    echo '<span class="product-quantity">'.count($_SESSION["cart"]).'</span>';
                }else{
                    echo '<span class="product-quantity">0</span>';
                }
            ?>
            <a href="../cart.php"><ion-icon class="icon" name="cart"></ion-icon></a>
        </div>
        <?php 
            if (!isAnyLogged()){
                echo '<a href="./login.php"><ion-icon class="icon" name="person"></ion-icon></a>';
            }else{
                // echo '<a href="./account/user.php"><ion-icon class="icon" name="person"></ion-icon></a>';
                // echo '<div style="font-size:14px;margin: auto;line-height: 1.2;">Hello<br> <span style="font-size:16px">'.$_SESSION["user_fullname"].'</span> </div>';
                echo '<a style="display: flex;text-decoration: none;color: #000;" href="./account/user.php">
                        <img style="max-width: 40px;height: auto;border-radius:50%;padding-right:5px;" src="'.$_SESSION["user"]["avatar"].'" alt="'.$_SESSION["user"]["full_name"].'">
                        <div style="font-size: 14px;margin: auto;line-height: 1.2;">Hello<br> <span style="font-size:16px">'.$_SESSION["user"]["full_name"].'</span> </div>
                    </a>';
            }
        ?> 
    </div>
</header>
<nav>
    <ul class="navbar__container flex-center">
        <li class="navbar__items pd16"><a href="../index.php">HOME</a></li>
        <li class="navbar__items pd16 drop-down">
            <a class="flex-center" href="../collections.php?type=all">SHOP<ion-icon name="caret-down-outline"></ion-icon></a>
            <div class="drop-down-menu">
                <ul>
                    <li><a href="./collections.php?type=t-shirts">T-SHIRTS</a></li>
                    <li><a href="./collections.php?type=shirts">SHIRTS</a></li>
                    <li><a href="./collections.php?type=sweaters">SWEATERS</a></li>
                    <li><a href="./collections.php?type=hoodies">HOODIES</a></li>
                    <li><a href="./collections.php?type=shorts">SHORTS</a></li>
                    <li><a href="./collections.php?type=bags">BAGS</a></li>
                    <li><a href="./collections.php?type=perfume">PERFUME</a></li>
                    <li><a href="./collections.php?type=jacket">JACKET</a></li>
                    <li><a href="./collections.php?type=accessories">ACCESSORIES</a></li>
                    <li><a href="./collections.php?type=polo">POLO</a></li>
                </ul>
            </div>
        </li>
        <li class="navbar__items pd16"><a href="../pages/contact.php">CONTACT</a></li>
        <li class="navbar__items pd16"><a href="../pages/about-us.php">ABOUT</a></li>
        <li class="navbar__items pd16"><a href="https://www.facebook.com/groups/vergency">VERGENCY GROUP</a></li>
        <li class="navbar__items pd16"><a href="https://www.instagram.com/vergency.vn">VERGENCY INSTAGRAM</a></li>
        <li class="navbar__items pd16"><div id="go-to-top"><ion-icon name="arrow-up"></ion-icon></div></li>
    </ul>
</nav>

<script>
    var search_btn = document.querySelector(".search-icon");
    var search_box = document.querySelector(".search-box");
    window.addEventListener("click", function(e){
        if (e.target == search_btn){
            search_box.style.display = search_box.style.display == "block" ? "none":"block";
        }else if (e.target == search_box){
            search_box.style.display = "block";
        }else{
            search_box.style.display = "none";
        }
    })
</script>

<script>
    function isOnScreen(element) {
        var curPos = element.getBoundingClientRect();
        return (curPos.bottom < 0);
    }
    var header = document.querySelector("header");
    var gotop_btn = document.querySelector("#go-to-top");

    window.addEventListener("scroll", (e)=>{
        if (isOnScreen(header)){
            gotop_btn.style.display = "none";
        }else{
            gotop_btn.style.display = "block";
        };
    });

    gotop_btn.addEventListener("click", ()=>{
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    })
</script>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>