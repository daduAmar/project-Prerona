<?php
  session_start();
  include_once "includes/connect.php";
  
  if(!isset($_SESSION['username'])){
    header("Location: preronaHome.php");
  }

  //add scheme
  if(isset($_POST["addScheme"])){

    $newSchemeName = $_POST["schmName"];

    // Prepare an insert statement
    $sql = "INSERT INTO scheme (schemeName) VALUES (?)";


    if($stmt = mysqli_prepare($conn, $sql)){
          
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "s", $newSchemeName);
      
      mysqli_stmt_execute($stmt);

      echo "success!";

      } 
      else {

        echo "ERROR: Could not prepare query: $sql. " . mysqli_error($conn);

      }
  }

  //delete scheme
  // if(isset($_GET['scheme_id'])){

  //   $id=$_GET['scheme_id'];

  //   $sql="DELETE FROM scheme WHERE scheme_Id = $id";
  //   mysqli_query($conn, $sql);
    
  //   header("Location: adminHome.php?deleted");

  // }

  //add therapy
  if(isset($_POST["addTherapy"])){

    $newTherapyName = $_POST["thpyName"];

    // Prepare an insert statement
    $sql = "INSERT INTO therapy (name) VALUES (?)";


    if($stmt = mysqli_prepare($conn, $sql)){
          
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "s", $newTherapyName);
      
      mysqli_stmt_execute($stmt);

      echo "success!";

    } 
    else {

      echo "ERROR: Could not prepare query: $sql. " . mysqli_error($conn);

    }
  }

  //delete therapy
  if(isset($_GET['thpy_id'])){

    $thy_id = $_GET['thpy_id'];

    $sql="DELETE FROM therapy WHERE therapy_Id = $thy_id";
    mysqli_query($conn, $sql);
    
    header("Location: adminHome.php?deleted");

  }


  //add monthly fee
  if(isset($_POST["addFeeType"])){

    $feeType = $_POST["feeType"];
    $feeAmt = $_POST["feeAmt"];

    // Prepare an insert statement
    $sql = "INSERT INTO monthlyFee (feeType, totalFeeAmt) VALUES (?, ?)";


    if($stmt = mysqli_prepare($conn, $sql)){
          
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "si", $feeType, $feeAmt);
      
      mysqli_stmt_execute($stmt);

      echo "success!";

    } 
    else {

      echo "ERROR: Could not prepare query: $sql. " . mysqli_error($conn);

    }
  }

  //delete therapy
  if(isset($_GET['m_id'])){

    $type_id = $_GET['m_id'];

    $sql="DELETE FROM monthlyFee WHERE mFee_Id = $type_id";
    mysqli_query($conn, $sql);
    
    header("Location: adminHome.php?deleted");

  }


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="CSS/bootstrap.min.css" >
  <link rel="stylesheet" href="CSS/admin.page.css" >
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
  <title>Dashboard</title>
</head>
<body>
   <!-- navbar -->
   <nav class="navbar navbar-expand-md navbar-dark bg-dark p-0">
    <div class="container">
      <a href="#" class="navbar-brand">PRERONA</a>
      <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav">
          <li class="nav-item px-2">
            <a href="adminHome.php" class="nav-link active">Dashboard</a>
          </li>
          <li class="nav-item px-2">
            <a href="std_dtls.php" class="nav-link"> Student Registration </a>
          </li>
          <li class="nav-item px-2">
            <a href="ddrc.php" class="nav-link">DDRC</a>
          </li>
          <li class="nav-item px-2">
            <a href="studentsView.php" class="nav-link">Students Details</a>
          </li>
        </ul>

        <ul class="navbar-nav ml-auto">
          <li class="nav-item dropdown mr-3">
            <a href="#" class="nav-link active">
              <i class="fas fa-user"></i> Welcome
              <?php 
              
                if(isset($_SESSION['username']))
                {
                echo ucwords($_SESSION['username']);
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
  <header id="main-header" class="py-2 text-white">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <h1>
          <i class="fas fa-users-cog mr-1"></i> Dashboard</h1>
        </div>
      </div>
    </div>
  </header>

  <!-- ACTIONS -->
  <section id="actions" class="py-4 mb-4 bg-light">
    <div class="container">
      <div class="row">
        <div class="col-md-3">
          <a href="#" class="btn btn-info btn-block" data-toggle="modal" data-target="#addSchemeModal">
          <i class="fas fa-sliders-h mr-1"></i> Scheme
          </a>
        </div>
        <div class="col-md-3">
          <a href="#" class="btn btn-success btn-block" data-toggle="modal" data-target="#addTherapyModal">
          <i class="fas fa-sliders-h mr-1"></i> Therapy
          </a>
        </div>
        <div class="col-md-3 ">
          <a href="#" class="btn bg-user btn-block" data-toggle="modal" data-target="#addMonthlyModal">
          <i class="fas fa-sliders-h mr-1"></i> Monthly Fee
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- BODY  -->
  <?php
    require_once "includes/connect.php";

    //user count
    $sql = "SELECT * FROM users WHERE is_active = 1";

    $result = mysqli_query($conn, $sql)
          or die("Error in fetching records");

    $totalRow = mysqli_num_rows($result);

    //students count
    $sql = "SELECT * FROM students_Info";

    $result = mysqli_query($conn, $sql)
          or die("Error in fetching records");

    $rowCount = mysqli_num_rows($result);

    //hostellers count
    $sql = "SELECT * FROM hostelAdmission";

    $result = mysqli_query($conn, $sql)
          or die("Error in fetching records");

    $hstlRowCount = mysqli_num_rows($result);

  ?>

  <br>
  <section id="home_section">
    <div class="container my-4">
    <!-- **notificaion -->
    <?php if(isset($_GET["success"])): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php
          echo "Congratulations!...Registration Is Successfully Completed";
        ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <?php endif; ?>

    <?php if(isset($_GET["schm_succ"]) || isset($_GET["thpy_succ"]) || isset($_GET["fee_succ"]) || isset($_GET["res_succ"])): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
      
        <?php
          if(isset($_GET["schm_succ"])){
            echo "Scheme Details Updated!";
          }

          if(isset($_GET["thpy_succ"])){
            echo "Therapy Details Updated!";
          }

          if(isset($_GET["fee_succ"])){
            echo "Monthly Fee Details Updated!";
          }

          if(isset($_GET["res_succ"])){
            echo "Respite Details Updated!";
          }
         
        ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <?php endif; ?>
      <div class="row">
        <div class="col-md-4">
          <div class="card text-center bg-info text-white mb-3">
            <div class="card-body">
              <h3>Students</h3>  
              <h4 class="display-4">
              <i class="fas fa-wheelchair mr-3"></i><?php echo $rowCount; ?>
              </h4>
              <a href="studentsView.php" class="btn btn-outline-light btn-sm">View</a>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card text-center bg-success text-white mb-3">
            <div class="card-body">
              <h3>Respite</h3>
              <h4 class="display-4">
              <i class="fas fa-hotel"></i> <?php echo $hstlRowCount; ?>
              </h4>
              <a href="respiteView.php" class="btn btn-outline-light btn-sm">View</a>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card text-center bg-user text-white mb-3" >
            <div class="card-body">
              <h3>Users</h3>
              <h4 class="display-4">
                <i class="fas fa-users mr-3"></i><?php echo $totalRow; ?>
              </h4>
              <a href="users.php" class="btn btn-outline-light btn-sm">View</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <br>

  <!-- MODALS -->
  <?php

    //scheme
    $sql = "SELECT * FROM scheme";

    $result = mysqli_query($conn, $sql)
          or die("Error in fetching records");

    $rowRslt = mysqli_fetch_all($result, MYSQLI_ASSOC);

    //therapy
    $sql = "SELECT * FROM therapy";

    $rslts = mysqli_query($conn, $sql)
          or die("Error in fetching records");

    $rowsThRslt = mysqli_fetch_all($rslts, MYSQLI_ASSOC);

    //monthly fee
    $sql = "SELECT * FROM monthlyFee";

    $rslt = mysqli_query($conn, $sql)
          or die("Error in fetching records");

    $rowsMonthRslt = mysqli_fetch_all($rslt, MYSQLI_ASSOC);



  ?>

  <!-- ADD SCHEME MODAL -->
  <div class="modal fade" id="addSchemeModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-info text-white">
          <h5 class="modal-title">Manage Scheme</h5>
        </div>
        <div class="modal-body">
        <h3 class="text-monospace text-info text-center">Scheme Details</h3>
        <table class="table table-striped table-bordered table-hover">
          <thead>
            <tr>
              <th scope="col" class="text-center">Id</th>
              <th scope="col" class="text-center">Scheme Name</th>
              <th scope="col" class="text-center" colspan="1">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php  foreach ($rowRslt as $schRow): ?>
            <tr>
              <td class="text-center"><?php echo $schRow['scheme_Id']; ?></td>
              <td class="text-center"><?php echo ucwords($schRow['schemeName']); ?></td>
              <!-- <td class="text-center">
                <a href="adminHome.php?scheme_id=<?php //schemeId; ?>" class="btn btn-danger btn-sm" onclick="return confirmDelete()">
                <i class="fas fa-minus-circle"></i> Remove
                </a>
              </td> -->
              <td class="text-center">
                <a href="modalUpdate.php?scheme_id=<?php echo $schRow['scheme_Id']; ?>" class="btn btn-info btn-sm">
                <i class="fas fa-tools"></i> Update 
                </a>
              </td>
            </tr>
            <?php endforeach; ?> 
          </tbody>
        </table>

          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="form-group">
              <label for="schmName" class="text-info">Scheme Name</label>
              <input type="text" class="form-control" name="schmName" id="schmName" placeholder="New Scheme Name">
            </div>
            <input type="submit" class="btn btn-outline-info btn-block" value="Add Scheme" name="addScheme">
          </form>
        </div>
        <div class="modal-footer">
        <button class="btn btn-info" data-dismiss="modal">Close</button>
        
        </div>
      </div>
    </div>
  </div>

  <!-- ADD THERAPY MODAL -->
  <div class="modal fade" id="addTherapyModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title">Manage Therapy</h5>
        </div>
        <div class="modal-body">
          <h3 class="text-monospace text-success text-center">Therapeutic Services</h3>
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th scope="col" class="text-center">Id</th>
                <th scope="col" class="text-center">Therapy Name</th>
                <th scope="col" class="text-center" colspan="2">Action</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach($rowsThRslt as $thyRow):  ?>
            <tr>
              <td class="text-center"><?php echo $thyRow['therapy_Id'];  ?></td>
              <td class="text-center"><?php echo ucwords($thyRow['name']); ?></td>
              <td class="text-center">
                <a href="adminHome.php?thpy_id=<?php echo $thyRow['therapy_Id']; ?>" class="btn btn-danger btn-sm" onclick="return confirmDelete()">
                <i class="fas fa-minus-circle"></i> Remove
                </a>
              </td>
              <td class="text-center">
                <a href="modalUpdate.php?thpy_id=<?php echo $thyRow['therapy_Id']; ?>" class="btn btn-info btn-sm">
                <i class="fas fa-tools"></i> Update 
                </a>
              </td>
            </tr>
              <?php endforeach; ?> 
          </tbody>
        </table>

          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="form-group">
              <label for="thpyName" class="text-success">Therapy Name</label>
              <input type="text" class="form-control" name="thpyName" id="thpyName" placeholder="New Therapy Name">
            </div>
            <input type="submit" class="btn btn-outline-success btn-block" value="Add Therapy" name="addTherapy">
          </form>
          
        </div>
        <div class="modal-footer">
          <button class="btn btn-success" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

   <!-- ADD MONTHLY MODAL -->
   <div class="modal fade" id="addMonthlyModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-user text-white">
          <h5 class="modal-title">Manage Monthly Fee</h5>
        </div>
        <div class="modal-body">
          <h3 class="text-monospace text-warning text-center">Monthly Fees</h3>
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th scope="col" class="text-center">Id</th>
                <th scope="col" class="text-center">Fee Type</th>
                <th scope="col" class="text-center">Fee Amount</th>
                <th scope="col" class="text-center" colspan="2">Action</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach($rowsMonthRslt as $monthRow):  ?>
            <tr>
              <td class="text-center"><?php echo $monthRow['mFee_Id']; ?></td>
              <td class="text-center"><?php echo ucwords($monthRow['feeType']); ?></td>
              <td class="text-center"><?php echo $monthRow['totalFeeAmt']; ?></td>
              <td class="text-center">
                <a href="adminHome.php?m_id=<?php echo $monthRow['mFee_Id']; ?>" class="btn btn-danger btn-sm" onclick="return confirmDelete()">
                <i class="fas fa-minus-circle"></i> Remove
                </a>
              </td>
              <td class="text-center">
                <a href="modalUpdate.php?m_id=<?php echo $monthRow['mFee_Id']; ?>" class="btn btn-info btn-sm">
                <i class="fas fa-tools"></i> Update 
                </a>
              </td>
            </tr>
              <?php endforeach; ?> 
          </tbody>
        </table>

          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="form-group">
              <label for="feeType" class="text-warning">Fee Type</label>
              <input type="text" class="form-control" name="feeType" id="feeType" placeholder="New Fee Type">
            </div>
            <div class="form-group">
              <label for="feeAmt" class="text-warning">Fee Amount</label>
              <input type="number" class="form-control" name="feeAmt" id="feeAmt" placeholder="Fee Amount">
            </div>
            <input type="submit" class="btn btn-outline-warning btn-block" value="Add Fee" name="addFeeType">
          </form>
          
        </div>
        <div class="modal-footer">
          <button class="btn bg-user" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


  <!-- Footer -->
  <?php require "includes/footer.php"; ?>

  <!-- bootstrap script -->
  <script src="JS/bootstrapJquery.js"></script>
  <script src="JS/popper.min.js"></script>
  <script src="JS/bootstrap.min.js"></script>
  <script language="javascript" type="text/javascript">

    function confirmDelete(){

      return confirm('Remove, Are you sure?');

    }

    document.querySelector('.close').addEventListener('click', function () {
      window.location = 'adminHome.php';
    });
  </script>

</body>
</html>

  

 

