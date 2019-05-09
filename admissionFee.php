<?php
  session_start();
  include_once "includes/connect.php";
  $std_Id = $_SESSION['std_id'];
   //$std_Id = 30;

  if(isset($_POST["submit"])){

    $paidSchAdFee = $_POST["payFee"];
    $respiteFee = $_POST["hPayFee"];
    $transFee = $_POST["transFee"]; 

    if(!empty($_POST["payFee"]) && !empty($_POST["transFee"])){

      // Prepare an insert statement
      $sql = "UPDATE students_Info SET admissionFee = ?, transpotationFee = ? WHERE std_Id = ?";

      if($stmt = mysqli_prepare($conn, $sql)){
            
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "iii", $paidSchAdFee, $transFee, $std_Id);
        
        mysqli_stmt_execute($stmt);
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
          
        } else{

          echo "ERROR: Could not prepare query: $sql. " . mysqli_error($conn);

        }
    }
  }

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Fee</title>
  <link rel="stylesheet" href="CSS/bootstrap.min.css" >
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
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
            <a href="#" class="nav-link">DDRC</a>
          </li>
          <li class="nav-item px-2">
            <a href="#" class="nav-link">Users</a>
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
  <header id="main-header" class="py-2 bg-primary text-white">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <h1>
          <i class="fas fa-funnel-dollar mr-2"></i>Admission Fee</h1>
        </div>
      </div>
    </div>
  </header>


  <!-- SEARCH -->
  <section id="search" class="py-4 mb-4 bg-light">
    <div class="container">
      <br>
    </div>
  </section>

  <!-- student name               -->
  <?php

      $query = "SELECT stdName FROM students_Info WHERE std_Id = $std_Id";

      $rslts = mysqli_query($conn, $query)
        or die("Error in fetching records");

        $fetchrows = mysqli_fetch_all($rslts);

        if ($rslts === false) {

        exit("Couldn't execute the query." . mysqli_error($conn));

        }       
  ?>

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

  <!-- therapy fee -->
  <?php

    $query = "SELECT  sum(therapy.fee) FROM therapy INNER JOIN therapyRecipient ON therapy.therapy_Id = therapyRecipient.therapy_Id WHERE therapyRecipient.std_Id =  $std_Id";

      $rslts = mysqli_query($conn, $query)
      or die("Error in fetching records");

      $tRows = mysqli_fetch_all($rslts);
      
      if ($rslts === false) {

        exit("Couldn't execute the query." . mysqli_error($conn));

      } 
      
      
  ?>
   
    <br>
    <div class="container">
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <?php foreach ($fetchrows as $fRow):  ?>
          <div class="form-group" >
            <label>Student Name</label>
            <input type="text" class="form-control" id="sName" name="sname" value="<?php echo  ucwords($fRow[0]); ?>" disabled>
          </div>
        <?php endforeach;  ?>  
       
        <div class="form-group" >
          <label>School Admission Fee</label>
          <input type="text" class="form-control" id="aFee" name="admFee" value="2000" disabled>
        </div>

        <div class="form-group" >
          <label>Payable School Admission Fee</label>
          <input type="number" class="form-control" id="pFee" name="payFee" placeholder="Payable Fee Amount">
        </div>

        <?php foreach ($rows as $row):  ?>
          <div class="form-group" >
            <label>Respite Admission Fee</label>
            <input type="number" class="form-control" id="hAdmFee" name="hAdmFee" value="<?php echo  $row[0]; ?>" disabled>
          </div>
        <?php endforeach;  ?>   

        <div class="form-group" >
          <label>Payable Respite Admission Fee</label>
          <input type="number" class="form-control" id="hPayFee" name="hPayFee" placeholder="Payable Fee Amount">
        </div>

        <div class="form-group" >
          <label>Transpotation Fee</label>
          <input type="number" class="form-control" id="transFee" name="transFee"
          placeholder="Transpotation Fee">
        </div>
        
        <?php foreach ($tRows as $tRow):  ?>
          <div class="form-group" >
            <label>Therapy Fee</label>
            <input type="number" class="form-control" id="tFee" name="tFee" value="<?php echo  $tRow[0]; ?>" disabled>
          </div>
        <?php endforeach;  ?> 

        <div class="form-group" >
          <label>Total Fee</label>
          <input type="number" class="form-control" id="totFee" name="totFee" disabled>
        </div>

        <input type="submit" value="Submit" class="btn btn-primary btn-block" name="submit">
      </form>  
    </div>
    
    
  <br><br><br>
  <!-- Footer -->
  <?php require "includes/footer.php"; ?>
  
   <!-- bootstrap script -->
  <script src="JS/bootstrapJquery.js"></script>
  <script src="JS/popper.min.js"></script>
  <script src="JS/bootstrap.min.js"></script>
  <script src="scripts/admsnFee.js"></script>
        
</body>
</html>