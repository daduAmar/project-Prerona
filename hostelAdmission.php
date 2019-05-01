<?php
  session_start();
  include_once "includes/connect.php";
  $std_Id = $_SESSION['std_id'];

  if(isset($_POST["submit"])){

    $paidAdFee = $_POST["payFee"];
    $monthlyFee = $_POST["monthFee"];
    $feeDate = $_POST["admDate"];
    $roomNo = $_POST["roomNo"];
    $hst_Id = 1;

    // Prepare an insert statement
    $sql = "INSERT INTO hostelAdmission (std_Id, hst_Id, paidAdmissionFee, paidMonthlyFee, admissionDate, roomNo) VALUES (?, ?, ?, ?, ?, ?)";

    if($stmt = mysqli_prepare($conn, $sql)){
         
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "iiiisi", $std_Id, $hst_Id, $paidAdFee, $monthlyFee, $feeDate, $roomNo);
    
      mysqli_stmt_execute($stmt);
      
      echo "Records inserted successfully.";
      
    } else{
      echo "ERROR: Could not prepare query: $sql. " . mysqli_error($conn);
    }
  // Close statement
  mysqli_stmt_close($stmt);
  }
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Respite</title>
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
          <i class="fas fa-hotel"></i> Respite Admission</h1>
        </div>
      </div>
    </div>
  </header>


    <!-- retriving students name -->
  <?php
      $sql="SELECT stdName FROM students_Info WHERE std_Id = $std_Id";
      $result = mysqli_query($conn,$sql) or die(mysqli_error($conn));
      $row = mysqli_fetch_assoc($result);

      if ($result === false) {

        exit("Couldn't execute the query." . mysqli_error($conn));

      } 
    ?>

  <!-- SEARCH -->
  <section id="search" class="py-4 mb-4 bg-light">
    <div class="container">
      <br>
    </div>
  </section>

    <!-- retriving hostel data -->
    <?php
      $sql="SELECT * FROM respite";
      $result = mysqli_query($conn,$sql) or die(mysqli_error($conn));
      $rows = mysqli_fetch_all($result);

      if ($result === false) {
        exit("Couldn't execute the query." . mysqli_error($conn));

      } 
    ?>
    <br>
    <div class="container">
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

        <div class="form-group" >
          <label>Student Name</label>
          <input type="text" class="form-control" id="sName" name="sname" value="<?php echo $row['stdName']; ?>" disabled>
        </div>

        <?php foreach ($rows as $row):  ?>

        <div class="form-group" >
          <label>Admission Fee</label>
          <input type="text" class="form-control" id="aFee" name="admFee" value="<?php echo $row[1]; ?>" disabled>
        </div>

        <div class="form-group" >
          <label>Monthly Fee</label>
          <input type="text" class="form-control" id="monFee" name="monthlyFee" value="<?php echo $row[2]; ?>" disabled>
        </div>

        <?php endforeach;  ?>
        
        <div class="form-group" >
          <label>Payable Admission Fee</label>
          <input type="number" class="form-control" id="pFee" name="payFee" placeholder="Payable Fee Amount">
        </div>

        <div class="form-group" >
          <label>Payable Monthly Fee</label>
          <input type="number" class="form-control" id="mFee" name="monthFee" placeholder="Payable Monthly Amount">
        </div>

        <div class="form-group" >
          <label>Admission Date</label>
          <input type="date" class="form-control" id="admDate" name="admDate">
        </div>

        <div class="form-group" >
          <label>Room Number</label>
          <input type="number" class="form-control" id="roomNo" name="roomNo" placeholder="Room Number">
        </div>
    
        <input type="submit" value="Submit" class="btn btn-primary btn-block" name="submit">
      </form>  
    </div>
    
    
  <br><br><br>
  <!-- Footer -->
  <?php require "includes/footer.php"; ?>
  
   <!-- bootstrap script -->
   <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
   <script src="JS/popper.min.js"></script>
   <script src="JS/bootstrap.min.js"></script>

    
   <script>
            $('#admDate').dateDropper();
    </script>
        
</body>
</html>