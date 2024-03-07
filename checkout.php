<?php

@include 'config.php';

function getCartItemCount($conn) {
   $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM `cart`");
   $row = mysqli_fetch_assoc($result);
   return $row['count'];
}

if(isset($_POST['order_btn'])){

   $name = $_POST['name'];
   $number = $_POST['number'];
   $email = $_POST['email'];
   $method = $_POST['method'];
   $address = $_POST['address'];


   $cart_query = mysqli_query($conn, "SELECT * FROM `cart`");
   $price_total = 0;
   $productQuantities = [];



   if(mysqli_num_rows($cart_query) > 0){
      while($product_item = mysqli_fetch_assoc($cart_query)){
          $productQuantities[$product_item['p_name']] = $product_item['p_qty'];
          $product_name[] = $product_item['p_name'] .' ('. $product_item['p_qty'] .') ';
          $total_product = $productQuantities[$product_item['p_name']];
          $total_qty = $product_item['p_qty'];
          $product_price = ($product_item['p_price'] * $product_item['p_qty']);
          $price_total += $product_price;
      };
  };

  $total_product = is_array($product_name) ? implode(', ', $product_name) : $product_name;
  $detail_query = mysqli_query($conn, "INSERT INTO `order`(name, number, email, method, address, total_products, total_price) VALUES('$name','$number','$email','$method','$address', '$total_product','$price_total')") or die('query failed');
  $detail_query1 = mysqli_query($conn, "INSERT INTO `admin_history`(name, number, email, method, address, total_products, total_price) VALUES('$name','$number','$email','$method','$address', '$total_product','$price_total')") or die('query failed');


   foreach ($productQuantities as $productName => $quantity) {
      mysqli_query($conn, "UPDATE `products` SET pQty = pQty - $quantity WHERE pName = '$productName'");
      mysqli_query($conn, "DELETE FROM `cart`");
  }

   if($cart_query && $detail_query){
      echo "
      <div class='order-message-container'>
      <div class='message-container'>
         <h3>Thank you for shopping!</h3>
         <div class='order-detail'>
            <span>".$total_product."</span>
            <span class='total'> Total : ₱".$price_total."/-  </span>
         </div>
         <div class='customer-details'>
            <p> Your name : <span>".$name."</span> </p>
            <p> your number : <span>".$number."</span> </p>
            <p> your email : <span>".$email."</span> </p>
            <p> your address : <span>".$address."</span> </p>
            <p> your payment mode : <span>".$method."</span> </p>
            <p>(*pay when product arrives*)</p>
         </div>
            <a href='products.php' class='btn'>continue shopping</a>
         </div>
      </div>
      ";
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Checkout</title>

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

<?php include 'header.php'; ?>

<div class="container">

<section class="checkout-form">

   <h1 class="heading">complete your order</h1>

   <form action="" method="post">

   <div class="display-order">
      <?php
         $select_cart = mysqli_query($conn, "SELECT * FROM `cart`");
         $total = 0;
         $grand_total = 0;
         if(mysqli_num_rows($select_cart) > 0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){
            $total_price = ($fetch_cart['p_price'] * $fetch_cart['p_qty']);
            $grand_total = $total += $total_price;
      ?>
      <span>
        <?= $fetch_cart['p_name']; ?>(<?= $fetch_cart['p_qty']; ?>)= ₱<?= $total_price; ?> </span>
      <?php
         }
      }else{
         echo "<div class='display-order'><span>your cart is empty!</span></div>";
      }
      ?>
      <span class="grand-total"> grand total : ₱<?= number_format($grand_total); ?>/- </span>
   </div>

      <div class="flex">
         <div class="inputBox">
            <span>Enter Name</span>
            <input type="text" placeholder="Fullname:" name="name" required>
         </div>
         <div class="inputBox">
            <span>Enter Contact Number</span>
            <input type="number" placeholder="Contact number:" name="number" required>
         </div>
         <div class="inputBox">
            <span>Enter Email</span>
            <input type="email" placeholder="Email:" name="email" required>
         </div>
         <div class="inputBox">
            <span>payment method</span>
            <select name="method">
               <option value="cash on delivery" selected>Cash On Delivery</option>
            </select>
         </div>
         <div class="inputBox">
            <span>Enter Address</span>
            <input type="text" placeholder="Full Address:" name="address" required>
         </div>
         
      </div>
      <input type="submit" value="order now" name="order_btn" class="btn">
   </form>

</section>

</div>

<!-- custom js file link  -->
<script src="script.js"></script>
   
</body>
</html>