<?php

@include 'config.php';



if(isset($_POST['add_product'])){
   $p_name = $_POST['p_name'];
   $p_price = $_POST['p_price'];
   $p_qty = $_POST['p_qty'];
   $p_image = $_FILES['p_image']['name'];
   $p_image_tmp_name = $_FILES['p_image']['tmp_name'];
   $p_image_folder = 'uploaded_img/'.$p_image;

   $insert_query = mysqli_query($conn, "INSERT INTO `products`(pName, pPrice, pQty, pImage) VALUES('$p_name', '$p_price', '$p_qty', '$p_image')") or die('query failed');

   if($insert_query){
      move_uploaded_file($p_image_tmp_name, $p_image_folder);
      $message[] = 'product add succesfully';
   }else{
      $message[] = 'could not add the product';
   }
};


if (isset($_GET['delete'])) {
    $deleteProductId = $_GET['delete'];

    // Retrieve product name before deletion
    $selectProductQuery = "SELECT pName FROM `products` WHERE ID = $deleteProductId";
    $selectProductResult = mysqli_query($conn, $selectProductQuery);

    if ($selectProductResult) {
        $productRow = mysqli_fetch_assoc($selectProductResult);
        $deletedProductName = $productRow['pName'];

        // Delete the product from the products table
        $deleteProductQuery = "DELETE FROM `products` WHERE ID = $deleteProductId";
        $deleteProductResult = mysqli_query($conn, $deleteProductQuery);

        if ($deleteProductResult) {
            // Delete the corresponding items from the cart
            $deleteCartItemsQuery = "DELETE FROM `cart` WHERE p_name = '$deletedProductName'";
            $deleteCartItemsResult = mysqli_query($conn, $deleteCartItemsQuery);

            if (!$deleteCartItemsResult) {
                die('Error deleting cart items: ' . mysqli_error($conn));
            }

            header('Location: admin.php'); // Redirect to admin page after deletion
        } else {
            die('Error deleting product: ' . mysqli_error($conn));
        }
    } else {
        die('Error retrieving product information: ' . mysqli_error($conn));
    }
}



if(isset($_POST['update_product'])){
   $update_p_id = $_POST['update_p_id'];
   $update_p_name = $_POST['update_p_name'];
   $update_p_price = $_POST['update_p_price'];
   $update_p_qty = $_POST['update_p_qty'];
   $update_p_image = $_FILES['update_p_image']['name'];
   $update_p_image_tmp_name = $_FILES['update_p_image']['tmp_name'];
   $update_p_image_folder = 'uploaded_img/'.$update_p_image;

   $update_query = mysqli_query($conn, "UPDATE `products` SET pName = '$update_p_name', pPrice = '$update_p_price', pQty = '$update_p_qty', pImage = '$update_p_image' WHERE ID = '$update_p_id'");

   if($update_query){
      move_uploaded_file($update_p_image_tmp_name, $update_p_image_folder);
      $message[] = 'product updated succesfully';
      header('location:inventory.php');
   }else{
      $message[] = 'product could not be updated';
      header('location:inventory.php');
   }

}

if(isset($_GET['delete_all'])){
   mysqli_query($conn, "DELETE FROM `products`");
   header('location:inventory.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="dashboard.css" />
    <link rel="stylesheet" href="style.css" />
    <title>Inventory</title>



</head>

<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-white" id="sidebar-wrapper">
            <div class="sidebar-heading text-center py-4 primary-text fs-4 fw-bold text-uppercase border-bottom"><img src = "carpe-denims/carpe_denims_logo.png"></div>
            <div class="list-group list-group-flush my-3">
                <a href="dashboard.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
                <a href="inventory.php" class="list-group-item list-group-item-action bg-transparent second-text active"><i
                        class="fas fa-bars me-2"></i>Inventory</a>
                <a href="history.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fas fa-clock me-2"></i>Transactions</a>
                <a href="login.php" class="list-group-item list-group-item-action bg-transparent text-danger fw-bold"><i
                        class="fas fa-power-off me-2"></i>Logout</a>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                    <h2 class="fs-2 m-0">Inventory</h2>
                </div>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle second-text fw-bold" href="#" id="navbarDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user me-2"></i>Admin
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="login.php">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>

            <?php

if(isset($message)){
   foreach($message as $message){
      echo '<div class="message"><span>'.$message.'</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i> </div>';
   };
};

?>

<?php include 'header.php'; ?>

<div class="container">

<section>

<form action="" method="post" class="add-product-form" enctype="multipart/form-data">
   <h3>add a new product</h3>
   <input type="text" name="p_name" placeholder="Product Name" class="box" required>
   <input type="number" name="p_price" min="0" placeholder="Price" class="box" required>
   <input type="number" name="p_qty" min="0" placeholder="Stocks" class="box" required>
   <input type="file" name="p_image" accept="image/png, image/jpg, image/jpeg" class="box" required>
   <input type="submit" value="add the product" name="add_product" class="btn">
</form>

</section>

<section class="display-product-table">

   <table>

      <thead>
         <th>product image</th>
         <th>product name</th>
         <th>product price</th>
         <th>product stocks</th>
         <th>action</th>
      </thead>

      <tbody>
         <?php
         
            $select_products = mysqli_query($conn, "SELECT * FROM `products`");
            if(mysqli_num_rows($select_products) > 0){
               while($row = mysqli_fetch_assoc($select_products)){
         ?>

         <tr>
            <td><img src="uploaded_img/<?php echo $row['pImage']; ?>" height="200" alt=""></td>
            <td><?php echo $row['pName']; ?></td>
            <td>₱<?php echo $row['pPrice']; ?>/-</td>
            <td><?php echo $row['pQty']; ?></td>
            <td>
               <a href="inventory.php?delete=<?php echo $row['ID']; ?>" class="delete-btn" onclick="return confirm('are your sure you want to delete this?');"> <i class="fas fa-trash"></i> delete </a>
               <a href="inventory.php?edit=<?php echo $row['ID']; ?>" class="option-btn"> <i class="fas fa-edit"></i> update </a>
            </td>
         </tr>

         <?php
            };    
            }else{
               echo "<div class='empty'>no product added</div>";
            };
         ?>
      </tbody>
      <tr class="table-bottom">
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td><a href="inventory.php?delete_all" onclick="return confirm('are you sure you want to delete all?');" class="delete-btn"> <i class="fas fa-trash"></i> delete all </a></td>
         </tr>
   </table>

</section>

<section class="edit-form-container">

   <?php
   
   if(isset($_GET['edit'])){
      $edit_id = $_GET['edit'];
      $edit_query = mysqli_query($conn, "SELECT * FROM `products` WHERE ID = $edit_id");
      if(mysqli_num_rows($edit_query) > 0){
         while($fetch_edit = mysqli_fetch_assoc($edit_query)){
   ?>

   <form action="" method="post" enctype="multipart/form-data">
      <img src="uploaded_img/<?php echo $fetch_edit['pImage']; ?>" height="200" alt="">
      <input type="hidden" name="update_p_id" value="<?php echo $fetch_edit['ID']; ?>">
      <input type="text" class="box" required name="update_p_name" value="<?php echo $fetch_edit['pName']; ?>">
      <input type="number" min="0" class="box" required name="update_p_price" value="<?php echo $fetch_edit['pPrice']; ?>">
      <input type="number" min="0" class="box" required name="update_p_qty" value="<?php echo $fetch_edit['pQty']; ?>">
      <input type="file" class="box" required name="update_p_image" accept="image/png, image/jpg, image/jpeg">
      <input type="submit" value="update the product" name="update_product" class="update-btn">
      <input type="reset" value="cancel" id="close-edit" class="cancel-btn">
   </form>

   <?php
            };
         };
         echo "<script>document.querySelector('.edit-form-container').style.display = 'flex';</script>";
      };
   ?>

</section>

</div>




<script>
    document.querySelector('#close-edit').onclick = () =>{
    document.querySelector('.edit-form-container').style.display = 'none';
    window.location.href = 'inventory.php';
        };
</script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        var el = document.getElementById("wrapper");
        var toggleButton = document.getElementById("menu-toggle");

        toggleButton.onclick = function () {
            el.classList.toggle("toggled");
        };
    </script>
</body>

</html>