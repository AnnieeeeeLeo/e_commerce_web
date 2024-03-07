<?php

@include 'config.php';

function getCartItemCount($conn) {
   $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM `cart`");
   $row = mysqli_fetch_assoc($result);
   return $row['count'];
}

if(isset($_POST['add_to_cart'])){

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = 1;

   $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE p_name = '$product_name'");

   if(mysqli_num_rows($select_cart) > 0){
      $message[] = 'product already added to cart';
   }else{
      $insert_product = mysqli_query($conn, "INSERT INTO `cart`(p_name, p_price, p_image, p_qty) VALUES('$product_name', '$product_price', '$product_image', '$product_quantity')");
      $message[] = 'product added to cart succesfully';
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Products</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<!-- custom css file link  -->
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

<?php

if(isset($message)){
   foreach($message as $message){
      echo '<div class="message"><span>'.$message.'</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i> </div>';
   };
};

?>


<div class="container">

<section class="products">

   <h1 class="heading">Products</h1>

   <div class="box-container">

      <?php
      
      $select_products = mysqli_query($conn, "SELECT * FROM `products`");
      if(mysqli_num_rows($select_products) > 0){
         while($fetch_product = mysqli_fetch_assoc($select_products)){
      ?>

      <form action="" method="post">
         <div class="box">
            <img src="uploaded_img/<?php echo $fetch_product['pImage']; ?>" alt="">
            <h3><?php echo $fetch_product['pName']; ?></h3>
            <div class="price">₱<?php echo $fetch_product['pPrice']; ?></div>
            <div class="qty">-<?php echo $fetch_product['pQty']; ?>-</div>
            <input type="hidden" name="product_name" value="<?php echo $fetch_product['pName']; ?>">
            <input type="hidden" name="product_price" value="<?php echo $fetch_product['pPrice']; ?>">
            <input type="hidden" name="product_qty" value="<?php echo $fetch_product['pQty']; ?>">
            <input type="hidden" name="product_image" value="<?php echo $fetch_product['pImage']; ?>">
            <input type="submit" class="btn" value="add to cart" name="add_to_cart" <?php echo ($fetch_product['pQty'] == 0) ? 'disabled' : ''; ?>>
            </div>
      </form>  

      <?php
         };
      } else {      
        echo "<div class='heading'><h6>no products</h6></div>";
         
      };
      ?>

   </div>

</section>

</div>

<!-- custom js file link  -->
<script src="/script.js"></script>

</body>
</html>