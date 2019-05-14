<?php

  require "includes/connect.php";

      //$sql = "SELECT * FROM people";

      $sql = "SELECT userName,email FROM users";

      // final json response
      $data = array();        
  
      try {
        $stmt = mysqli_prepare($conn, $sql);
        
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

  
        $data['data'] = array();
  
          foreach ($rows as $row) {
             array_push($data['data'], $row['userName']);
             array_push($data['data'], $row['email']);
          }
      } 
      catch (Exception $e) {
          $data['data'] = null;
      }
  
      // Close statement
      mysqli_stmt_close($stmt);
  
       // send json to client
      echo json_encode($data);

      //print_r($data);
?>
