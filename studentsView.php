<?php
  session_start();
  include_once "includes/connect.php";

  if(!isset($_SESSION['username'])){
    header("Location: index.php");
  }

  // sys month & year
  //setting time zone
  date_default_timezone_set('Asia/Kolkata');

  //get current month
  $month = date('F');

  //get current time
  $year = date('Y');

  // fetching students id's
  $sql = "SELECT DISTINCT(std_Id) FROM stdPaidFees WHERE feeMonth = '$month' AND feeYear = '$year'";

  $result = mysqli_query($conn, $sql) or die("Error in fetching records");

  $feeIdRows = mysqli_fetch_all($result);

  $paidIds = array();

  foreach($feeIdRows as $feeIdRow){
    $paidIds[] = $feeIdRow[0];
  }
  //print_r($ids);
    
  if ($result === false) {
       exit("Couldn't execute the query." . mysqli_error($conn));
  } 

  //search students
  if(isset($_GET["stdSearch"]) && isset($_GET["searchSname"]) && $_GET["searchSname"] != ''){

    $name = $_GET["searchSname"];

    $sql = "SELECT std_Id, stdName, dateOfAdmission FROM students_Info WHERE stdName LIKE '%$name%'";

    $result = mysqli_query($conn, $sql) or die("Error in fetching records");

    $stdRows = mysqli_fetch_all($result);

    //print_r($stdRows);
      
    if ($result === false) {
        exit("Couldn't execute the query." . mysqli_error($conn));
    } 

  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>studentsView</title>
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
            <a href="adminHome.php" class="nav-link">Dashboard</a>
          </li>
          <li class="nav-item px-2">
            <a href="std_dtls.php" class="nav-link"> Student Registration </a>
          </li>
          <li class="nav-item px-2">
            <a href="ddrc.php" class="nav-link">DDRC</a>
          </li>
          <li class="nav-item px-2">
          <a href="studentsView.php" class="nav-link active">Student Details</a>
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
  <header id="main-header" class="py-2 bg-info text-white">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <h1>
          <i class="fas fa-wheelchair"></i> Students Details</h1>
        </div>
      </div>
    </div>
  </header>
  <!-- SEARCH -->
  <section id="search" class="py-4 mb-4 bg-light">
    <div class="container">
      <div class="row">
        <div class="col-md-6 ml-auto">
          <div class="ml-2">
            <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="get">
              <div class="input-group">
                <input type="text" class="form-control" name="searchSname" placeholder="Student Name...">
                  <div class="input-group-append">
                    <button type="submit" class="btn btn-info" name="stdSearch">Search</button>
                  </div> 
              </div>  
            </form>     
          </div>          
        </div>
      </div>
    </div>
  </section>


  <?php
  
    //special school students count  
    $sql = "SELECT * FROM students_Info WHERE scheme_id = 2 AND active = 1";

    $result = mysqli_query($conn, $sql)
          or die("Error in fetching records");

    $totalRow = mysqli_num_rows($result);


    //disha students count            
    $query = "SELECT * FROM students_Info WHERE scheme_id = 1 AND active = 1";

    $rslt = mysqli_query($conn, $query)
          or die("Error in fetching records");

    $totRow = mysqli_num_rows($rslt);


    // passed out student count            
    $query = "SELECT * FROM students_Info WHERE active = 0";

    $rslts = mysqli_query($conn, $query)
          or die("Error in fetching records");

    $totRowP = mysqli_num_rows($rslts);

  ?>


  <!-- students -->
  <!-- notifications -->
  <section id="students">
    <div class="container">
    <?php if(isset($_GET["succ"])): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php
          echo "Fees Recorded Successfully For The Cuurent Month";
        ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <?php endif; ?>

    <?php if(isset($_GET["smsSend"])): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php
          echo "SMS Send....!";
        ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <?php endif; ?>

    <?php if(isset($_GET["sucs"])): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php
          echo "Student Details Updated Successfully!";
        ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <?php endif; ?>

    <?php if(isset($_GET["passed"])): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php
          echo "Student Has Been Passed Out From The Institute!";
        ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <?php endif; ?>

    <?php if(isset($_GET["fail"])): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php
          echo "Student Details Cannot Be Updated!";
        ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <?php endif; ?>


      <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-header">
                <!-- special school -->
              <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#T1" aria-expanded="false" aria-controls="ssTab">
                Special School <span class="badge badge-light"><?php echo $totalRow; ?></span>
              </button>
                <!-- disha -->
              <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#dTab" aria-expanded="false" aria-controls="dTab">
                Disha <span class="badge badge-light"><?php echo $totRow; ?></span>
              </button>
                <!-- passed out -->
              <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#psdTab" aria-expanded="false" aria-controls="psdTab">
               Passed Out <span class="badge badge-light"><?php echo $totRowP; ?></span>
              </button>
            </div>

              <!-- special school collapse -->
            <div class="collapse" id="T1">
              <div class="card card-body">
                <table class="table table-striped">
                  <thead class="thead-dark">
                    <tr>
                      <th class="text-center">Name</th>
                      <th class="text-center">Admission Date</th>
                      <th class="text-center">Monthly Fees</th>
                      <th class="text-center" colspan="2">Action</th>
                    </tr>  
                  </thead>
                  <tbody>
                  <?php 
        
                    $sql = "SELECT * FROM students_Info WHERE scheme_id = 2 AND active = 1";

                    $result = mysqli_query($conn, $sql)
                          or die("Error in fetching records");
                    $rows = mysqli_fetch_all($result);
                      
                    if ($result === false) {
                         exit("Couldn't execute the query." . mysqli_error($conn));
                    } 
                  ?>
                  <?php  foreach ($rows as $row): ?>
                    <tr>
                      <td class="text-center"><?php echo ucfirst($row[2]); ?></td>
                      <td class="text-center"><?php echo $row[19]; ?></td>
                      <td class="text-center">
                        <?php if(in_array($row[0], $paidIds)): ?>
                          <h4><span class="badge badge-success">Paid</span></h4>
                        <?php else: ?>
                            <h4><span class="badge badge-danger">Due</span></h4>
                        <?php endif; ?>
                      </td>
                      <td class="text-center">
                      <a href="std_profile.php?s_id=<?php echo $row[0]; ?>" class="btn btn-warning">
                      <i class="fas fa-angle-double-right"></i> More Details
                      </a>
                      </td>
                      <td class="text-center">
                      <a href="passedOut.php?s_id=<?php echo $row[0]; ?>" class="btn btn-danger">
                      <i class="far fa-paper-plane mr-1"></i> Passed Out</a>
                      </td>
                    </tr>
                  <?php endforeach; ?> 
                  </tbody>
                </table>   
              </div>
            </div>
             <!-- disha collapse -->
            <div class="collapse" id="dTab">
              <div class="card card-body">
                <table class="table table-striped">
                  <thead class="thead-dark">
                    <tr>
                    <th class="text-center">Name</th>
                      <th class="text-center">Admission Date</th>
                      <th class="text-center">Monthly Fees</th>
                      <th class="text-center" colspan="2">Action</th>
                    </tr>  
                  </thead>
                  <tbody>
                  <?php 
                      $sql = "SELECT * FROM students_Info WHERE scheme_id = 1 AND active = 1";

                      $result = mysqli_query($conn, $sql)
                            or die("Error in fetching records");
                      $rows = mysqli_fetch_all($result);
                        
                      if ($result === false) {
                          exit("Couldn't execute the query." . mysqli_error($conn));
                      } 
                  ?>
                   <?php  foreach ($rows as $row): ?>
                    <tr>
                      <td class="text-center"><?php echo ucfirst($row[2]); ?></td>
                      <td class="text-center"><?php echo $row[19]; ?></td>
                      <td class="text-center">
                        <?php if(in_array($row[0], $paidIds)): ?>
                          <h4><span class="badge badge-success">Paid</span></h4>
                        <?php else: ?>
                            <h4><span class="badge badge-danger">Due</span></h4>
                        <?php endif; ?>
                      </td>
                      <td class="text-center">
                      <a href="std_profile.php?s_id=<?php echo $row[0]; ?>" class="btn btn-warning">
                      <i class="fas fa-angle-double-right"></i> More Details
                      </a>
                      </td>
                      <td class="text-center">
                      <a href="passedOut.php?s_id=<?php echo $row[0]; ?>" class="btn btn-danger">
                      <i class="far fa-paper-plane mr-1"></i> Passed Out</a>
                      </td>
                    </tr>
                  <?php endforeach; ?> 
                  </tbody>
                </table>   
              </div>
            </div>
             <!-- passed out collapse -->
            <div class="collapse" id="psdTab">
              <div class="card card-body">
                <table class="table table-striped">
                  <thead class="thead-dark">
                    <tr>
                    <th class="text-center">Name</th>
                      <th class="text-center">Admission Date</th>
                      <th class="text-center" colspan="2">Action</th>
                    </tr>  
                  </thead>
                  <tbody>
                  <?php 
                      $sql = "SELECT * FROM students_Info WHERE active = 0";

                      $result = mysqli_query($conn, $sql)
                            or die("Error in fetching records");
                      $rows = mysqli_fetch_all($result);
                        
                      if ($result === false) {
                          exit("Couldn't execute the query." . mysqli_error($conn));
                      } 
                  ?>
                   <?php  foreach ($rows as $row): ?>
                    <tr>
                      <td class="text-center"><?php echo ucfirst($row[2]); ?></td>
                      <td class="text-center"><?php echo $row[19]; ?></td>
                      <td class="text-center">
                      <a href="std_profile.php?s_id=<?php echo $row[0]; ?>" class="btn btn-warning">
                      <i class="fas fa-angle-double-right"></i> More Details
                      </a>
                      </td>
                    </tr>
                  <?php endforeach; ?> 
                  </tbody>
                </table>   
              </div>
            </div>        
          </div>
          <?php  if(isset($_GET["stdSearch"]) && $_GET["searchSname"] != ''): ?>
          <div class="card card-body">
            <table class="table table-striped">
              <thead class="thead-dark">
                <tr>
                <th class="text-center">Name</th>
                  <th class="text-center">Admission Date</th>
                  <th class="text-center">Monthly Fees</th>
                  <th class="text-center" colspan="2">Action</th>
                </tr>  
              </thead>
              <tbody>
              <?php  foreach ($stdRows as $stdRow): ?>
                <tr>
                  <td class="text-center"><?php echo ucfirst($stdRow[1]); ?></td>
                  <td class="text-center"><?php echo $stdRow[2]; ?></td>
                  <td class="text-center">
                    <?php if(in_array($row[0], $paidIds)): ?>
                      <h4><span class="badge badge-success">Paid</span></h4>
                    <?php else: ?>
                        <h4><span class="badge badge-danger">Due</span></h4>
                    <?php endif; ?>
                  </td>
                  <td class="text-center">
                  <a href="std_profile.php?s_id=<?php echo $stdRow[0]; ?>" class="btn btn-warning">
                  <i class="fas fa-angle-double-right"></i> More Details
                  </a>
                  </td>
                  <td class="text-center">
                  <a href="passedOut.php?s_id=<?php echo $stdRow[0]; ?>" class="btn btn-danger">
                  <i class="far fa-paper-plane mr-1"></i> Passed Out</a>
                  </td>
                </tr>
              <?php endforeach; ?> 
              </tbody>
            </table>            
          </div>
          <?php endif; ?>   
        </div>
      </div>
    </div>
  </section>
  <br>
  <!-- Footer -->
  <?php require "includes/footer.php"; ?>
  
<!-- bootstrap script -->
<script src="scripts/tweaks.js"></script>
<script src="JS/bootstrapJquery.js"></script>
<script src="JS/popper.min.js"></script>
<script src="JS/bootstrap.min.js"></script>
</body>
</html>