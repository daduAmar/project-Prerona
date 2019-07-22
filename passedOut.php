<?php
  session_start();
  require_once "includes/connect.php";
  
  if(isset($_GET['s_id']))
  {
    $std_id=$_GET['s_id'];
    
    $sql="UPDATE students_Info SET active = 0 WHERE std_Id= $std_id";
    mysqli_query($conn, $sql);
    
    header("Location: studentsView.php?passed");
    exit;
  }
?>