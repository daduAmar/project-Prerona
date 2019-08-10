<?php
  session_start();
  include_once "includes/connect.php";

  if(!isset($_SESSION['username'])){
    header("Location: index.php");
  }

  $std_Id = $_SESSION['std_id'];
  //$std_Id = 12;
  $executed = false;

  if(isset($_POST["submit"])){

    $paidSchAdFee = $_POST["payFee"];
    $respiteFee = $_POST["hPayFee"];

    if(!empty($_POST["payFee"])){

      // Prepare an insert statement
      $sql = "UPDATE students_Info SET paidAdmissionFee = ? WHERE std_Id = ?";

      if($stmt = mysqli_prepare($conn, $sql)){
            
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ii", $paidSchAdFee, $std_Id);
        
        mysqli_stmt_execute($stmt);
        $executed = true;
        } else{

          echo "ERROR: Could not prepare query: $sql. " . mysqli_error($conn);

        }
    }

    if(!empty($_POST["hPayFee"])){

      // Prepare an insert statement
      $sql = "UPDATE hostelAdmission SET paidAdmissionFee = ? WHERE std_Id = ?";

      if($stmt = mysqli_prepare($conn, $sql)){
            
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ii", $respiteFee, $std_Id);
        
        mysqli_stmt_execute($stmt);
        $executed = true;
          
        } else{
          
          echo "ERROR: Could not prepare query: $sql. " . mysqli_error($conn);

        }
    }
    if($executed === true){
      header("Location: adminHome.php?success");
      exit;
    }else {
      echo "something went wrong!!";
    }
   
  }

  // update admissionFee
  if(isset($_POST["update"])){

    $newAdmFee = $_POST["updFee"];

    // Prepare an insert statement
    $sql = "UPDATE students_Info SET admissionFee = ? WHERE std_Id = ?";

    if($stmt = mysqli_prepare($conn, $sql)){
          
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "ii", $newAdmFee, $std_Id);
      
      mysqli_stmt_execute($stmt);

      echo "success!";

      } 
      else {

        echo "ERROR: Could not prepare query: $sql. " . mysqli_error($conn);

      }
  }

    
?>
 <!-- student name -->
 <?php

$query = "SELECT stdName, admissionFee,hostel FROM students_Info WHERE std_Id = $std_Id";

$rslts = mysqli_query($conn, $query)
  or die("Error in fetching records");

  $fetchrows = mysqli_fetch_all($rslts);
 
  if ($rslts === false) {

  exit("Couldn't execute the query." . mysqli_error($conn));

  }       
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Fee</title>
  <link rel="stylesheet" href="CSS/bootstrap.min.css" >
  <link rel="stylesheet" href="CSS/admissionFee.css" >
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

   <!-- hostel fee input hide -->
  
  <?php foreach ($fetchrows as $fRow):  ?>
  <?php if ($fRow[1] == 'No'):  ?>
  <style>
    #hAdmFeeDiv, #hPayFeeDiv{display : none;}
  </style>
  <?php endif; ?>
  <?php endforeach;  ?> 

</head>
<body>

  <!-- navbar -->
  <nav class="navbar navbar-expand-sm navbar-dark bg-dark p-0">
    <div class="container">
      <a href="#" class="navbar-brand">PRERONA</a>
      <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav">
          <li class="nav-item px-2">
            <a href="adminHome.php" class="nav-link ">Admin Dashboard</a>
          </li>
          <li class="nav-item px-2">
            <a href="std_dtls.php" class="nav-link active"> Student Registration </a>
          </li>
          <li class="nav-item px-2">
            <a href="ddrc.php" class="nav-link">DDRC</a>
          </li>
          <li class="nav-item px-2">
          <a href="studentsView.php" class="nav-link">Student Details</a>
          </li>
        </ul>

        <ul class="navbar-nav ml-auto">
          <li class="nav-item dropdown mr-3">
            <a href="#" class="nav-link active">
              <i class="fas fa-user"></i> Welcome
              <?php 
              
                if(isset($_SESSION['username']))
                {
                echo $_SESSION['username'];
                }
              ?>
            </a>
          </li>
          <li class="nav-item">
            <a href="u_logout.php" class="nav-link">
              <i class="fas fa-user-times"></i> Logout
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- HEADER -->
  <header class="py-2 text-white mb-3">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <!-- <h1>
          <i class="fas fa-funnel-dollar mr-2"></i>Fees</h1> -->
        </div>
      </div>
    </div>
  </header>

  <!-- respite fee -->
  <?php

    $query = "SELECT admissionFee FROM respite";

    $rslts = mysqli_query($conn, $query)
      or die("Error in fetching records");

      $rows = mysqli_fetch_all($rslts);

      if ($rslts === false) {

      exit("Couldn't execute the query." . mysqli_error($conn));

      }       
  ?>
    <br>
    <div class="container" id="bill">
      <div class="row">
        <div class="col-md-6 offset-md-3 py-4" id="con">
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="form1">
            <span> <h1>
              <i class="fas fa-funnel-dollar mr-2 mb-3"></i>Fees</h1>
            </span>
            <?php foreach ($fetchrows as $fRow):  ?>
              <div class="form-group">
                <label>Student Name</label>
                <input type="text" class="form-control" id="sName" name="sname" value="<?php echo  ucwords($fRow[0]); ?>" disabled>
              </div>
            
              <div class="form-group" >
                <label>School Admission Fee</label>
                <div class="input-group" >
                <input type="number" class="form-control" id="aFee" name="admFee" value="<?php echo $fRow[1]; ?>" disabled>
                <div class="input-group-append" id="edit">
                  <button type="button" class="btn text-white" data-toggle="collapse" data-target="#updateInp" aria-expanded="false" aria-controls="updateInp">
                    <i class="fas fa-edit"></i>
                  </button>
                </div>
                </div>
              </div>

            <?php endforeach;  ?> 
              <div class="form-group" >
                <label>Payable School Admission Fee</label>
                <input type="number" class="form-control" id="pFee" name="payFee">
              </div>
              <div class="row">
                <?php foreach ($rows as $row):  ?>
                  <div class="form-group col" id="hAdmFeeDiv">
                    <label>Respite Admission Fee</label>
                    <input type="number" class="form-control" id="hAdmFee" name="hAdmFee" value="<?php echo  $row[0]; ?>" disabled>
                  </div>
                <?php endforeach;  ?>   

              <div class="form-group col" id="hPayFeeDiv">
                <label>Payable Respite Admission Fee</label>
                <input type="number" class="form-control" id="hPayFee" name="hPayFee" >
              </div>
            </div>
            
            <div class="form-group">
              <label>Net Payable Fee</label><br>
              <div class="input-group" >
                <input type="number" class="form-control" id="totFee" name="totFee" disabled>
                <div class="input-group-append"  id="calculateBtn">
                  <button type="button" class="btn text-white input-group-text" >Calculate Fee</button>
                </div>
              </div>
            </div>

            <div class="mb-0 mt-0" id="loadImg">
              <img src="img/loading2.gif" alt="" width="400" height="140">
            </div>

            <input type="submit" value="Submit" class="btn btn-primary btn-block mt-2" name="submit" id="sub">
            
          </form> 
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="form2">
            <div class="form-group collapse mt-3" id="updateInp">
              <label>Update Admission Fee</label><br>
              <div class="input-group" >
                <input type="number" class="form-control" id="updFee" name="updFee" placeholder="New Admission Fee">
                <div class="input-group-append"  id="updateInput">
                <button type="submit" class="btn text-white input-group-text" name="update">Update Fee
                </button>
                </div>
              </div> 
            </div>
          </form>
        </div>
      </div>
    </div>
    
    
  <br><br><br>
  <!-- Footer -->
  <?php require "includes/footer.php"; ?>
  
   <!-- bootstrap script -->
 
  <script src="JS/bootstrapJquery.js"></script>
  <script src="JS/popper.min.js"></script>
  <script src="JS/bootstrap.min.js"></script>
  <script src="scripts/fee.js"></script>
</script>
</body>
</html>