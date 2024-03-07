<?php
require('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);
  
    $sql = "SELECT * FROM register WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
  
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if ($password == $user['password']) {
            if ($email == "admin@gmail.com" && $password == "admin123") {
                // Redirect to user.php for admin
                echo "admin_success";
            } else {
                // Redirect to home.php for regular user
                echo "success";
            }
        } else {
            echo "<br>";
            echo "<div style='text-align: center;'>Incorrect Password</div>";
        }
    } else {
        echo "<br>";
        echo "<div style='text-align: center;'>Email not found</div>";
    }
    $stmt->close();
}
$conn->close();
?>
