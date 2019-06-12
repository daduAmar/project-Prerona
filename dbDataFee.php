<?php

  require "includes/connect.php";

      $sql = "SELECT 	mFee_Id,totalFeeAmt FROM monthlyFee";

      // final json response
      //$dataFeeId = array();
      $dataFee = array();        
  
      try {
        $stmt = mysqli_prepare($conn, $sql);
        
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

        //print_r($rows);

        //$dataFeeId['id'] = array();
        $dataFee['data'] = array();

        foreach ($rows as $row) {
            //array_push($dataFeeId['id'], $row['mFee_Id']);
            array_push($dataFee['data'], $row['mFee_Id'], $row['totalFeeAmt']);
        }
      
      } 
      catch (Exception $e) {
        //$dataFeeId['id'] = null;
        $dataFee['data'] = null;
      }

      // Close statement
      mysqli_stmt_close($stmt);
  
       // send json to client
      //echo json_encode($dataFeeId);
      echo json_encode($dataFee);
?>



