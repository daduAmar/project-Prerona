<?php

require "includes/connect.php";

if(isset($_GET['code'])){

  $resetCode = filter_input(INPUT_GET, 'code', FILTER_SANITIZE_STRING);


  //getting data from users table
  $sql = "SELECT resetCode FROM users WHERE resetCode = ?";
      
     if($stmt = mysqli_prepare($conn, $sql)){
        
       // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $resetCode);
       
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_assoc($result);

        $dbResetCode = $row['resetCode'];

        if($resetCode == $dbResetCode){

          $query = "UPDATE users SET is_active = 1, resetCode = '' WHERE resetCode = ?";

          $stmt = mysqli_prepare($conn, $query);

          // Bind variables to the prepared statement as parameters
          mysqli_stmt_bind_param($stmt, "s", $resetCode);
       
          mysqli_stmt_execute($stmt);

          header("Location: preronaHome.php?ac_verified");

        }
        
     } else{
         echo "ERROR: Could not prepare query: $sql. " . mysqli_error($conn);
     }
     // Close statement
     mysqli_stmt_close($stmt);

}