<?php
  session_start();
  require_once "includes/connect.php";
  
  if(isset($_GET['s_id']))
  {
    $id=$_GET['s_id'];
    
    $sql="DELETE FROM users where users_Id= $id";
    mysqli_query($conn, $sql);
    
    header("Location: users.php?removed");
    exit;
  }
?>