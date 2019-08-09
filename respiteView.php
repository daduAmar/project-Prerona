<?php
  session_start();
  include_once "includes/connect.php";

  $is_checked = true;
  $not_found = false;
  $not_found_msg = '';

  if(!isset($_SESSION['username'])){
    header("Location: preronaHome.php");
  }

  //delete hosteller
  if(isset($_GET['ahst_id'])){

    $id=$_GET['ahst_id'];

    $sql="DELETE FROM hostelAdmission WHERE hAdmission_Id = $id";
    mysqli_query($conn, $sql);
    
    header("Location: respiteView.php?deleted");

  }

  //delete hostel
  if(isset($_GET['hst_id'])){

  $id=$_GET['hst_id'];

  $sql="DELETE FROM respite WHERE hst_Id = $id";
  mysqli_query($conn, $sql);
  
  header("Location: respiteView.php?Resdeleted");

}

 //add respite
//  if(isset($_POST["addRespite"])){

//   $admissionFee = $_POST["admissionFee"];
//   $monthlyFee = $_POST["monFee"];
//   $capacity = $_POST["capacity"];
//   $warden = $_POST["warden"];

//   // Prepare an insert statement
//   $sql = "INSERT INTO respite (admissionFee, monthlyFee, capacity, warden) VALUES (?, ?, ?, ?)";


//   if($stmt = mysqli_prepare($conn, $sql)){
        
//     // Bind variables to the prepared statement as parameters
//     mysqli_stmt_bind_param($stmt, "iiis", $admissionFee, $monthlyFee, $capacity, $warden);
    
//     mysqli_stmt_execute($stmt);

//     echo "success!";

//     } 
//     else {

//       echo "ERROR: Could not prepare query: $sql. " . mysqli_error($conn);

//     }
// }



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
            <a href="adminHome.php" class="nav-link">Dashboard</a>
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
  <header id="main-header" class="py-2 bg-success text-white">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <h1>
          <i class="fas fa-hotel"></i>  Respite</h1>
        </div>
      </div>
    </div>
  </header>

  <?php 

    if(isset($_GET["search"])){

      $is_checked = false;

      $name = $_GET["searchNm"];
      //echo $name;

      $sql = "SELECT students_Info.stdName, hostelAdmission.hAdmission_Id, hostelAdmission.paidAdmissionFee,hostelAdmission.admissionDate, hostelAdmission.roomNo FROM hostelAdmission INNER JOIN students_Info ON students_Info.std_Id = hostelAdmission.std_Id WHERE students_Info.stdName LIKE '%$name%'";

      $result = mysqli_query($conn, $sql)
          or die("Error in fetching records");

      $hstlSrRows = mysqli_fetch_all($result, MYSQLI_ASSOC);

      if(mysqli_num_rows($result) == 0){

        $not_found = true;
        $not_found_msg = "Result Not Found!";
      }
     
        
      if ($result === false) {
          exit("Couldn't execute the query." . mysqli_error($conn));
      }
      
      

    }   
    
    if(!isset($_GET["search"])){
      
      $is_checked = true;
      //hostellers info
      $sql = "SELECT students_Info.stdName, hostelAdmission.hAdmission_Id, hostelAdmission.paidAdmissionFee,hostelAdmission.admissionDate, hostelAdmission.roomNo FROM hostelAdmission INNER JOIN students_Info ON students_Info.std_Id = hostelAdmission.std_Id";

      $result = mysqli_query($conn, $sql)
            or die("Error in fetching records");

      $hstlRows = mysqli_fetch_all($result, MYSQLI_ASSOC);
      //print_r($hstlRows);
        
      if ($result === false) {
          exit("Couldn't execute the query." . mysqli_error($conn));
      }
    }   
  ?>
  
  <!-- SEARCH -->
  <section id="search" class="py-3 mb-4 bg-light">
    <div class="container">
      <div class="d-flex flex-row-reverse">
        <div class="ml-2">
          <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="get">
            <div class="input-group">
              <input type="text" class="form-control" name="searchNm" placeholder="Hosteller Name...">
                <div class="input-group-append">
                  <button type="submit" class="btn btn-success" name="search">Search</button>
                </div> 
            </div>  
          </form>     
        </div>          
        <div class="mr-1">
          <a href="#" class="btn btn-success" data-toggle="modal" data-target="#addRespiteModal">
          <i class="fas fa-sliders-h mr-1"></i>Manage Respite
          </a>        
        </div>
      </div>
    </div>
  </section>

  

  <!-- respite -->
  <section id="respite">
    <div class="container">
      <div class="row">
        <div class="col">
    <?php if(isset($_GET["res_succ"]) || isset($_GET["host_succ"])): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">

        <?php

          if(isset($_GET["res_succ"])){
            echo "Respite Details Updated!";
          }

          if(isset($_GET["host_succ"])){
            echo "Hosteller Details Updated!";
          }
         
        ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <?php endif; ?>

    <?php if(isset($_GET["search"]) && $not_found === true): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">

        <?php 
          echo isset($not_found_msg) ? $not_found_msg : "";
        ?>

        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <?php endif; ?>
          <div class="card shadow-lg mt-4 mb-5 bg-white">
            <div class="card card-body">
              <h3 class="font-weight-bold text-monospace">Hostellers Details</h3>
              <div class="table-responsive-sm">
                <table class="table table-striped table-bordered table-hover">
                  <thead class="thead-dark">
                    <tr>
                      <th class="text-center">Name</th>
                      <th class="text-center">Admission Fee</th>
                      <th class="text-center">Admission Date</th>
                      <th class="text-center">Seat</th>
                      <th class="text-center" colspan="2">Action</th>
                    </tr>  
                  </thead>
                  <tbody>

                    <?php if($is_checked === true):  ?>
                    <?php foreach($hstlRows as $hstlRow):  ?>
                      <tr>
                        <td class="text-center"><?php echo $hstlRow['stdName']; ?></td>
                        <td class="text-center"><?php echo $hstlRow['paidAdmissionFee']; ?></td>
                        <td class="text-center"><?php echo $hstlRow['admissionDate']; ?></td>
                        <td class="text-center"><?php echo $hstlRow['roomNo']; ?></td>
                        <td class="text-center">
                          <a href="respiteView.php?ahst_id=<?php echo $hstlRow['hAdmission_Id']; ?>" class="btn btn-danger btn-sm" onclick="return confirmDelete()">
                          <i class="fas fa-minus-circle"></i> Remove
                          </a>
                        </td>
                        <td class="text-center">
                          <a href="modalUpdate.php?ahst_id=<?php echo $hstlRow['hAdmission_Id']; ?>" class="btn btn-info btn-sm">
                          <i class="fas fa-tools"></i> Update 
                          </a>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                    <?php endif;  ?>

                    <?php if(isset($_GET["search"])):  ?>
                    <?php foreach($hstlSrRows as $hstlSrRow):  ?>

                      <tr>
                        <td class="text-center"><?php echo $hstlSrRow['stdName']; ?></td>
                        <td class="text-center"><?php echo $hstlSrRow['paidAdmissionFee']; ?></td>
                        <td class="text-center"><?php echo $hstlSrRow['admissionDate']; ?></td>
                        <td class="text-center"><?php echo $hstlSrRow['roomNo']; ?></td>
                        <td class="text-center">
                          <a href="respiteView.php?ahst_id=<?php echo $hstlSrRow['hAdmission_Id']; ?>" class="btn btn-danger btn-sm" onclick="return confirmDelete()">
                          <i class="fas fa-minus-circle"></i> Remove
                          </a>
                        </td>
                        <td class="text-center">
                          <a href="modalUpdate.php?ahst_id=<?php echo $hstlSrRow['hAdmission_Id']; ?>" class="btn btn-info btn-sm" data-toggle="modal" data-target="#updateHostellersModal">
                          <i class="fas fa-tools"></i> Update 
                          </a>
                        </td>
                      </tr>
                    <?php endforeach; ?> 
                    <?php endif;  ?>
                  </tbody>
                </table>  
              </div>    
            </div>  
          </div>
        </div>
      </div>
    </div>
  </section>
    <br>

  <?php 
    //respite
    $sql = "SELECT * FROM respite";

    $rslt = mysqli_query($conn, $sql)
          or die("Error in fetching records");

    $rowsResRslt = mysqli_fetch_all($rslt, MYSQLI_ASSOC);


  ?>

  <!--************* MODAL ******************-->
  <!-- ADD RESPITE MODAL -->
  <div class="modal fade" id="addRespiteModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title">Manage Respite</h5>
        </div>
        <div class="modal-body">
        <h3 class="text-monospace text-success text-center">Respite Details</h3>
        <table class="table table-striped table-bordered table-hover">
          <thead>
            <tr>
              <th scope="col" class="text-center">Admission Fee</th>
              <th scope="col" class="text-center">Monthly Fee</th>
              <th scope="col" class="text-center">Capacity</th>
              <th scope="col" class="text-center" colspan="2">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php  foreach ($rowsResRslt as $rowResRslt): ?>
            <tr>
              <td class="text-center"><?php echo $rowResRslt['admissionFee']; ?></td>
              <td class="text-center"><?php echo $rowResRslt['monthlyFee']; ?></td>
              <td class="text-center"><?php echo $rowResRslt['capacity']; ?></td>
              <td class="text-center">
                <a href="respiteView.php?hst_id=<?php echo $rowResRslt['hst_Id']; ?>" class="btn btn-danger btn-sm" onclick="return confirmDelete()">
                <i class="fas fa-minus-circle"></i> Remove
                </a>
              </td>
              <td class="text-center">
                <a href="modalUpdate.php?hst_id=<?php echo $rowResRslt['hst_Id']; ?>" class="btn btn-info btn-sm">
                <i class="fas fa-tools"></i> Update 
                </a>
              </td>
            </tr>
            <?php endforeach; ?> 
          </tbody>
        </table>

          <!-- <form action="<?php  ?>" method="post">
            <div class="form-group">
              <label for="admissionfee" class="text-success">Admission Fee</label>
              <input type="text" class="form-control" name="admissionFee" id="admissionFee" placeholder="Fee Amount">
            </div>
            <div class="form-group">
              <label for="admissionfee" class="text-success">Monthly Fee</label>
              <input type="text" class="form-control" name="monFee" id="monFee" placeholder="Fee Amount">
            </div>
            <div class="form-group">
              <label for="admissionfee" class="text-success">Capacity</label>
              <input type="text" class="form-control" name="capacity" id="capacity" placeholder="Total Capacity">
            </div>
            <div class="form-group">
              <label for="admissionfee" class="text-success">Warden</label>
              <input type="text" class="form-control" name="warden" id="warden" placeholder="Warden Name">
            </div>
            <input type="submit" class="btn btn-outline-success btn-block" value="Add Scheme" name="addRespite">
          </form> -->
        </div>
        <div class="modal-footer">
        <button class="btn btn-success" data-dismiss="modal">Close</button>
        
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
      window.location = 'respiteView.php';
    });
  </script>
</body>
</html>