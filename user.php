<?php

@include 'config.php';

function getCartItemCount($conn) {
   $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM `cart`");
   $row = mysqli_fetch_assoc($result);
   return $row['count'];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <link rel="stylesheet" href="style1.css">
    <link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="navstyle.css">
</head>
<body>
<section class = "header-section">
    <div class = header-wrapper>
        <nav>
        <div class = "logo-container">
            <a href = "user.php"><img src = "carpe-denims/carpe_denims_logo.png"></a>
        </div>
            <div class = "nav-links-wrapper">
                <ul>
                    <li><a href = "user.php"><i class="fas fa-home"></i> HOME</a></li>
                    <li><a href = "products.php"><i class="fas fa-bars"></i> PRODUCTS</a></li>
                    <li><a href = "user_th.php"><i class="fas fa-clock"></i> TRANSACTION HISTORY</a></li>
                </ul>
                <div class = "nav-links-icons-wrapper">
                    <ul>
                    <li><a class="nav-link" href="cart.php"><i class="fas fa-shopping-cart"></i> <span id="cart-item" class="badge badge-danger"><?= getCartItemCount($conn); ?></span></a></li>
                        <li><a class="nav-link" href="login.php"><i class="fas fa-user"></i> <span id="user_profile"></span>LOGOUT</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    
</section>
            <div class = "hero-body-wrapper">
                <div class = "text-wrapper">
                    <div class = "title-text">
                        <img src = "carpe-denims/black-rectangle.svg">
                        <h1>SHOP ONLINE WITHOUT HASSLE</h1>
                    </div>
                    <div class = "main-body-text">
                        <p>Lorem ipsum dolor sit amet. Et corrupti officiis et rerum ipsam ut cupiditate nihil ea maxime nihil. Vel fuga vitae eum illo quas et vitae dignissimos sit similique alias.

                        Hic omnis dolores ea voluptatem incidunt eos quis maxime? A harum eaque qui dignissimos ipsa eos dolorem fuga ea voluptatibus laboriosam sit quaerat consequuntur. Nam deserunt omnis At commodi voluptatem eum consequatur cumque.</p>
                    </div>
                </div>
                <div class = "img-container">
                    <img src="carpe-denims/stall_location.jpg">
                </div>
            </div>
    </main>
</section>


<section class = "featured-section">
    <div class = "featured-wrapper">
        <h2>FEATURED CATEGORIES</h2>
        <div class = "featured-products-cards-wrapper">
            <div class = "card">
                <div class = "image_placeholder">

                </div>
                <div class = "text-div">
                    <img src="carpe-denims/white-rectangle.svg">
                    <a href = "index.html"><h3>TOP SELLERS</h3></a>
                </div>
            </div>
            <div class = "card">
                <div class = "image_placeholder">
    
                </div>
                <div class = "text-div">
                    <img src="carpe-denims/white-rectangle.svg">
                    <a href = "index.html"><h3>BEST DEALS</h3></a>
                </div>
            </div>
            <div class = "card">
                <div class = "image_placeholder">
    
                </div>
                <div class = "text-div">
                    <img src="carpe-denims/white-rectangle.svg">
                    <a href = index.html><h3>NEWCOMERS</h3></a>
                </div>
            </div>
    
        </div>
    </div>
</section>

<footer>
    <div class = "footer-wrapper">
            <div class = "icon-group">
                <a href = "instagram_page.html"><img src = "carpe-denims/ig_logo.svg"></a>
                <a href = "twitter_page.html"><img src = "carpe-denims/x_logo.svg"></a>
                <a href = "https://www.tiktok.com/@carpedenims"><img src="carpe-denims/tiktok_logo.svg"></a>
                <a href = "https://www.facebook.com/carpedenims"><img src = "carpe-denims/fb_logo.svg"></a>
            </div>
            <div class = "text-group">
                <h5>IT'S NOT ABOUT BRAND, IT'S ABOUT STYLE</h5>
                <div class = "pptac">
                    <h5>PRIVACY POLICY</h5>
                    <h5>TERMS AND CONDITIONS</h5>
                </div>
            </div>
        </div>
</footer>
</html>