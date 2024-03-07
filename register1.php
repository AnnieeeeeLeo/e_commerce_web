<?php
require('config.php');
if (isset($_REQUEST['email'])) 
{
  $fname = stripslashes($_REQUEST['fname']);
  $fname = mysqli_real_escape_string($conn,$fname); 

  $lname = stripslashes($_REQUEST['lname']);
  $lname = mysqli_real_escape_string($conn,$lname);

  $email = stripslashes($_REQUEST['email']);
  $email = mysqli_real_escape_string($conn,$email);
  
  $password = stripslashes($_REQUEST['password']);
  $password = mysqli_real_escape_string($conn,$password);
  
  $query = "INSERT into `register` (fname, lname, email, password) 
  VALUES ('$fname', '$lname', '$email', '$password')";
  $result = mysqli_query($conn,$query);

  if ($result == false) 
  {
    die("Error: " . mysqli_error($conn));
  } else {
    header("Location: login.php");
    exit;
  }
}


$conn ->close();
?>