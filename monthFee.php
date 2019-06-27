<?php
  session_start();
  require_once "includes/connect.php";

  //monthly fee record
  if(isset($_POST["submit"])){

    $sId = $_SESSION['stdId_pro'];
    $date = $_POST["feeDate"];
    $month = $_POST["feeMon"];
    $year = $_POST["feeYear"];
    $schFeeId = $_POST["sFeeId"];
    $schFee = $_POST["pSFee"];
    $respiteFeeId = $_POST["hstFeeId"];
    $respiteFee = $_POST["pHstFee"];
    $therapyFeeId = $_POST["thyFeeId"];
    $therapyFee = $_POST["pThyFee"];
    $conveyFeeId = $_POST["conveyFeeId"];
    $conveyFee = $_POST["pConFee"];

    if($respiteFeeId == 'Select a fee type'){
      $respiteFeeId = '';
    }

    if($therapyFeeId == 'Select a fee type'){
      $therapyFeeId = '';
    }
    
    if($conveyFeeId == 'Select a fee type'){
      $conveyFeeId = '';
    }
    
    if(!empty($respiteFeeId) || !empty($therapyFeeId) ||
     !empty($conveyFeeId)){


      if(!empty($respiteFeeId) && empty($therapyFeeId) &&
      empty($conveyFeeId)){

        // insert statement
        $sql = "INSERT INTO stdPaidFees (mFee_Id, std_Id, feeMonth, feeYear, paidFee, payDate) VALUES ('$schFeeId', '$sId', '$month', '$year', '$schFee', '$date'), ('$respiteFeeId', '$sId', '$month', '$year', '$respiteFee', '$date')";

        if(mysqli_query($conn, $sql)){
          header("Location: studentsView.php?succ");
        }

      } elseif (empty($respiteFeeId) && !empty($therapyFeeId) &&
      empty($conveyFeeId)) {

        // insert statement
        $sql = "INSERT INTO stdPaidFees (mFee_Id, std_Id, feeMonth, feeYear, paidFee, payDate) VALUES ('$schFeeId', '$sId',' $month', '$year', '$schFee', '$date'), ('$therapyFeeId', '$sId', '$month', '$year', '$therapyFee', '$date')";

        if(mysqli_query($conn, $sql)){
          header("Location: studentsView.php?succ");
        }

      } elseif (empty($respiteFeeId) && empty($therapyFeeId) &&
      !empty($conveyFeeId)) {
       
        // insert statement
        $sql = "INSERT INTO stdPaidFees (mFee_Id, std_Id, feeMonth, feeYear, paidFee, payDate) VALUES ('$schFeeId', '$sId', '$month', '$year', '$schFee', '$date'), ('$conveyFeeId', '$sId', '$month', '$year', '$conveyFee', '$date')";

        if(mysqli_query($conn, $sql)){
          header("Location: studentsView.php?succ");
        }

      } elseif (!empty($respiteFeeId) && !empty($therapyFeeId) &&
      empty($conveyFeeId)) {
       
        // insert statement
        $sql = "INSERT INTO stdPaidFees (mFee_Id, std_Id, feeMonth, feeYear, paidFee, payDate) VALUES ('$schFeeId', '$sId', '$month', '$year', '$schFee', '$date'), ('$respiteFeeId', '$sId', '$month', '$year', '$respiteFee', '$date'), ('$therapyFeeId', '$sId',' $month', '$year', '$therapyFee',' $date')";

        if(mysqli_query($conn, $sql)){
          
          header("Location: studentsView.php?succ");
        }

      } else {
        
        // insert statement
        $sql = "INSERT INTO stdPaidFees (mFee_Id, std_Id, feeMonth, feeYear, paidFee, payDate) VALUES ('$schFeeId', '$sId', '$month', '$year', '$schFee', '$date'), ('$therapyFeeId', '$sId', '$month', '$year', '$therapyFee', '$date'), ('$conveyFeeId', '$sId', '$month', '$year', '$conveyFee', '$date')";

        if(mysqli_query($conn, $sql)){
          header("Location: studentsView.php?succ");
        }

      }

    }else {
     
      // insert statement
      $sql = "INSERT INTO stdPaidFees (mFee_Id, std_Id, feeMonth, feeYear, paidFee, payDate) VALUES ('$schFeeId', '$sId', '$month', '$year', '$schFee', '$date')";

      if(mysqli_query($conn, $sql)){
        
        header("Location: studentsView.php?succ");
        
      }
     
    }

  }

?>