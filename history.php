<?php

@include 'config.php';


if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $delete_query = mysqli_query($conn, "DELETE FROM `admin_history` WHERE ID = $delete_id ") or die('query failed');
    if($delete_query){
       header('location:history.php');
       $message[] = 'Transaction has been deleted';
    }else{
       header('location:history.php');
       $message[] = 'Transaction could not be deleted';
    };
 };

 if(isset($_GET['delete_all'])){
   mysqli_query($conn, "DELETE FROM `admin_history`");
   header('location:history.php');
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

    <title>Transactions</title>



</head>

<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-white" id="sidebar-wrapper">
            <div class="sidebar-heading text-center py-4 primary-text fs-4 fw-bold text-uppercase border-bottom"><img src = "carpe-denims/carpe_denims_logo.png"></div>
            <div class="list-group list-group-flush my-3">
                <a href="dashboard.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
                <a href="inventory.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fas fa-bars me-2"></i>Inventory</a>
                <a href="history.php" class="list-group-item list-group-item-action bg-transparent second-text active"><i
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
                    <h2 class="fs-2 m-0">Dashboard</h2>
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
         
            $orders = mysqli_query($conn, "SELECT * FROM `admin_history`");
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
               <a href="history.php?delete=<?php echo $row['ID']; ?>" class="delete-btn" onclick="return confirm('are your sure you want to delete this?');"> <i class="fas fa-trash"></i> delete </a>
              
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
            <td><a href="history.php?delete_all" onclick="return confirm('are you sure you want to delete all?');" class="delete-btn"> <i class="fas fa-trash"></i> delete all </a></td>
         </tr>
      </thead>

      
   </table>

</section>

<!-- custom js file link  -->
<script src="/script.js"></script>

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