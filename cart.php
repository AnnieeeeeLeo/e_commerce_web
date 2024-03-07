<?php

@include 'config.php';

function getCartItemCount($conn) {
   $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM `cart`");
   $row = mysqli_fetch_assoc($result);
   return $row['count'];
}
function isQuantityValid($conn) {
   $select_cart = mysqli_query($conn, "SELECT * FROM `cart`");
   while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
       $product_name = $fetch_cart['p_name'];
       $product_quantity = $fetch_cart['p_qty'];
       
       $select_product = mysqli_query($conn, "SELECT pQty FROM `products` WHERE pName = '$product_name'");
       $fetch_product = mysqli_fetch_assoc($select_product);

       if ($product_quantity > $fetch_product['pQty']) {
           return false; // Quantity is not valid
       }
   }
   return true; // All quantities are valid
}

if(isset($_POST['update_update_btn'])){
   $update_value = $_POST['update_quantity'];
   $update_id = $_POST['update_quantity_id'];
   $update_quantity_query = mysqli_query($conn, "UPDATE `cart` SET p_qty = '$update_value' WHERE ID = '$update_id'");
   if($update_quantity_query){
      header('location:cart.php');
   };
};

if(isset($_GET['remove'])){
   $remove_id = $_GET['remove'];
   mysqli_query($conn, "DELETE FROM `cart` WHERE ID = '$remove_id'");
   header('location:cart.php');
};

if(isset($_GET['delete_all'])){
   mysqli_query($conn, "DELETE FROM `cart`");
   header('location:cart.php');
}

$quantityValid = isQuantityValid($conn);

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Shopping cart</title>

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

<section class="shopping-cart">

   <h1 class="heading">shopping cart</h1>

   <table>

      <thead>
         <th>image</th>
         <th>name</th>
         <th>price</th>
         <th>quantity</th>
         <th>total price</th>
         <th>action</th>
      </thead>

      <tbody>

         <?php 
         
         $select_cart = mysqli_query($conn, "SELECT * FROM `cart`");
         $grand_total = 0;
         $select_products = mysqli_query($conn, "SELECT * FROM `products`");
         if(mysqli_num_rows($select_products) > 0) {
         if(mysqli_num_rows($select_cart) > 0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){
         ?>

         <tr>
            <td><img src="uploaded_img/<?php echo $fetch_cart['p_image']; ?>" height="200" alt=""></td>
            <td><?php echo $fetch_cart['p_name']; ?></td>
            <td>₱<?php echo ($fetch_cart['p_price']); ?>/-</td>
            <td>
               <form action="" method="post">
                  <input type="hidden" name="update_quantity_id"  value="<?php echo $fetch_cart['ID']; ?>" >
                  <input type="number" name="update_quantity" min="1"  value="<?php echo $fetch_cart['p_qty']; ?>" >
                  <input type="submit" value="update" name="update_update_btn">
               </form>   
            </td>
            <td>₱<?php echo $sub_total = ($fetch_cart['p_price'] * $fetch_cart['p_qty']); ?>/-</td>
            <td><a href="cart.php?remove=<?php echo $fetch_cart['ID']; ?>" onclick="return confirm('remove item from cart?')" class="delete-btn"> <i class="fas fa-trash"></i> remove</a></td>
         </tr>
         <?php
           $grand_total += $sub_total;  
            };
         }} else {
            mysqli_query($conn, "DELETE FROM `cart`");
         };
         ?>
         <tr class="table-bottom">
            <td><a href="products.php" class="option-btn" style="margin-top: 0;">continue shopping</a></td>
            <td colspan="3">grand total</td>
            <td>₱<?php echo number_format($grand_total); ?>/-</td>
            <td><a href="cart.php?delete_all" onclick="return confirm('are you sure you want to delete all?');" class="delete-btn"> <i class="fas fa-trash"></i> delete all </a></td>
         </tr>

      </tbody>

   </table>

   <div class="checkout-btn">
   <a href="checkout.php" class="btn <?= ($grand_total > 1 && $quantityValid) ? '' : 'disabled'; ?>">Proceed to Checkout</a>
   </div>

</section>

</div>
   
<!-- custom js file link  -->
<script src="script.js"></script>

</body>
</html>