<?php

@include 'config.php';

function getCartItemCount($conn) {
   $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM `cart`");
   $row = mysqli_fetch_assoc($result);
   return $row['count'];
}

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $delete_query = mysqli_query($conn, "DELETE FROM `order` WHERE ID = $delete_id ") or die('query failed');
    if($delete_query){
       header('location:user_th.php');
       $message[] = 'Transaction has been deleted';
    }else{
       header('location:user_th.php');
       $message[] = 'Transaction could not be deleted';
    };
 };

 if(isset($_GET['delete_all'])){
   mysqli_query($conn, "DELETE FROM `order`");
   header('location:user_th.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Transaction History</title>

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


?>


<section class="display-product-table">

   <table>
   <h1 class="heading">Transaction History</h1>
      <thead>
         <th>Name</th>
         <th>Number</th>
         <th>Email</th>
         <th>Payment Method</th>
         <th>Address</th>
         <th>Ordered Products</th>
         <th>Total Price</th>
         <th>Action</th>

         <tbody>
         <?php
         
            $orders = mysqli_query($conn, "SELECT * FROM `order`");
            if(mysqli_num_rows($orders) > 0){
               while($row = mysqli_fetch_assoc($orders)){
         ?>

         <tr>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['number']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['method']; ?></td>
            <td><?php echo $row['address']; ?></td>
            <td><?php echo $row['total_products']; ?></td>
            <td>₱<?php echo $row['total_price']; ?></td>
            <td>
               <a href="user_th.php?delete=<?php echo $row['ID']; ?>" class="delete-btn" onclick="return confirm('are your sure you want to delete this?');"> <i class="fas fa-trash"></i> delete </a>
              
            </td>
         </tr>

         <?php
            };    
            }else{
               echo "<div class='empty'>No Transaction History</div>";
            };
         ?>
      </tbody>

         <tr class="table-bottom">
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td><a href="user_th.php?delete_all" onclick="return confirm('are you sure you want to delete all?');" class="delete-btn"> <i class="fas fa-trash"></i> delete all </a></td>
         </tr>
      </thead>

      
   </table>

</section>

<!-- custom js file link  -->
<script src="/script.js"></script>

</body>
</html>