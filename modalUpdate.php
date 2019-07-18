<?php
  session_start();
  include_once "includes/connect.php";

  if(!isset($_SESSION['username'])){
    header("Location: preronaHome.php");
  }


  if(isset($_POST["updateScheme"])){

    $sch_id = $_POST["uptdSchId"];

    $newSchmName = $_POST["newSchmName"];

    $sql="UPDATE scheme SET schemeName = '$newSchmName'  WHERE scheme_Id = '$sch_id'";

    if (mysqli_query($conn,$sql)){
     header("Location: adminHome.php?schm_succ");
    }
    else{
     header("Location: modalUpdate.php?fail");
    }

  }

  if(isset($_POST["updateTherapy"])){

    $thp_id = $_POST["uptdThpyId"];

    $newThpyName = $_POST["newThpyName"];

    $sql="UPDATE therapy SET name = '$newThpyName'  WHERE therapy_Id = '$thp_id'";

    if (mysqli_query($conn,$sql)){
     header("Location: adminHome.php?thpy_succ");
    }
    else{
     header("Location: modalUpdate.php?fail");
    }

  }

  if(isset($_POST["updateFeeType"])){

    $uptdMonFeeId = $_POST["uptdMonFeeId"];
    $newFeeType = $_POST["newFeeType"];
    $newFeeAmt = $_POST["newFeeAmt"];

    $sql="UPDATE monthlyFee SET feeType = '$newFeeType', totalFeeAmt = '$newFeeAmt'  WHERE mFee_Id = '$uptdMonFeeId'";

    if (mysqli_query($conn,$sql)){
     header("Location: adminHome.php?fee_succ");
    }
    else{
     header("Location: modalUpdate.php?fail");
    }

  }

  if(isset($_POST["updateRespite"])){

    $uptdRespiteId = $_POST["uptdRespiteId"];
    $newAdmFee = $_POST["newAdmFee"];
    $newMonthFee = $_POST["newMonthFee"];
    $newCapacity = $_POST["newCapacity"];

    $sql="UPDATE respite SET admissionFee = '$newAdmFee', monthlyFee = '$newMonthFee', capacity = '$newCapacity'  WHERE hst_Id = '$uptdRespiteId'";

    if (mysqli_query($conn,$sql)){
     header("Location: respiteView.php?res_succ");
    }
    else{
     header("Location: modalUpdate.php?fail");
    }

  }

  if(isset($_POST["updateHostellers"])){

    $uptdAhstId = $_POST["uptdAhstId"];
    $newName = $_POST["newName"];
    $newAdmFee = $_POST["newAdmFee"];
    $newAdmDate = $_POST["newAdmDate"];
    $newSeat = $_POST["newSeat"];

    $sql="UPDATE hostelAdmission, students_Info SET students_Info.stdName = '$newName', hostelAdmission.paidAdmissionFee = '$newAdmFee', hostelAdmission.admissionDate = '$newAdmDate', hostelAdmission.roomNo = '$newSeat' WHERE hAdmission_Id = '$uptdAhstId' AND hostelAdmission.std_Id = students_Info.std_Id";

    if (mysqli_query($conn,$sql)){
     header("Location: respiteView.php?host_succ");
    }
    else{
     header("Location: modalUpdate.php?fail");
    }

  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>update</title>
  <link rel="stylesheet" href="CSS/bootstrap.min.css" >
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

  <?php if(isset($_GET['scheme_id'])): ?>
  <style>
  #update #cardTherapy{ display : none; }
  #update #cardMonthFee{ display : none; }
  #update #cardRespite{ display : none; }
  #update #cardHosteller{ display : none; }
  </style>
  <?php endif; ?>

  <?php if(isset($_GET['thpy_id'])): ?>
  <style>
  #update #cardScheme{ display : none; }
  #update #cardMonthFee{ display : none; }
  #update #cardRespite{ display : none; }
  #update #cardHosteller{ display : none; }
  </style>
  <?php endif; ?>

  <?php if(isset($_GET['m_id'])): ?>
  <style>
  #update #cardScheme{ display : none; }
  #update #cardTherapy{ display : none; }
  #update #cardRespite{ display : none; }
  #update #cardHosteller{ display : none; }
  </style>
  <?php endif; ?>

  <?php if(isset($_GET["hst_id"])): ?>
  <style>
  #update #cardScheme{ display : none; }
  #update #cardTherapy{ display : none; }
  #update #cardMonthFee{ display : none; }
  #update #cardHosteller{ display : none; }
  </style>
  <?php endif; ?>

  <?php if(isset($_GET["ahst_id"])): ?>
  <style>
  #update #cardScheme{ display : none; }
  #update #cardTherapy{ display : none; }
  #update #cardMonthFee{ display : none; }
  #update #cardRespite{ display : none; }
  </style>
  <?php endif; ?>

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
  <header id="main-header" style="background-image: linear-gradient(to right, #4185dc, #3d86de, #3986e0, #3487e1, #2e88e3, #228be2, #148de1, #0090e0, #0095db, #0099d5, #009ccd, #149fc6);" class="py-2 text-white">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <h1>
          <i class="fas fa-user-edit"></i> Update</h1>
        </div>
      </div>
    </div>
  </header>
  <!-- SEARCH -->
  <section id="search" class="py-4 mb-4 bg-light">
    <div class="container">
      <div class="row">
        <div class="col-md-6 ml-auto">
        </div>
      </div>
    </div>
  </section>
  <?php
    //students details
    if(isset($_GET['scheme_id'])){

    $id = $_GET['scheme_id'];  

    $sql="SELECT schemeName FROM scheme WHERE scheme_Id= $id";

    $result = mysqli_query($conn, $sql)
    or die("Error in fetching records");

    $rowsSch = mysqli_fetch_all($result);

     //print_r($rowsR);

    foreach ($rowsSch as $rowSch){

    }
    //print_r($rowR);
    if ($result === false) {

    exit("Couldn't execute the query." . mysqli_error($conn));

    }
  }  

   //therapy details
   if(isset($_GET['thpy_id'])){

    $thp_id = $_GET["thpy_id"];  

    $sql="SELECT name FROM therapy WHERE therapy_Id= $thp_id";

    $result1 = mysqli_query($conn, $sql)
    or die("Error in fetching records");

    $rowsThp = mysqli_fetch_all($result1);

     //print_r($rowsR);

    foreach ($rowsThp as $rowThp){

    }
    //print_r($rowR);
    if ($result1 === false) {

    exit("Couldn't execute the query." . mysqli_error($conn));

    }
  }  

  //monthly fee details
  if(isset($_GET["m_id"])){

    $mFee_id = $_GET["m_id"];  

    $sql="SELECT feeType,totalFeeAmt FROM monthlyFee WHERE mFee_Id = $mFee_id";

    $result = mysqli_query($conn, $sql)
    or die("Error in fetching records");

    $rowsMonFee = mysqli_fetch_all($result);

     //print_r($rowsMonFee);

    foreach ($rowsMonFee as $rowMonFee){

    }
    //print_r($rowR);
    if ($result === false) {

    exit("Couldn't execute the query." . mysqli_error($conn));

    }
  }  

  //monthly fee details
  if(isset($_GET["hst_id"])){

    $res_id = $_GET["hst_id"];  

    $sql="SELECT * FROM respite WHERE hst_Id = $res_id";

    $result = mysqli_query($conn, $sql)
    or die("Error in fetching records");

    $rowsMonFee = mysqli_fetch_all($result);

     //print_r($rowsMonFee);

    foreach ($rowsMonFee as $rowMonFee){

    }
    //print_r($rowR);
    if ($result === false) {

    exit("Couldn't execute the query." . mysqli_error($conn));

    }
  } 
  
  //hostellers details
  if(isset($_GET["ahst_id"])){

    $id = $_GET["ahst_id"];

    $sql = "SELECT students_Info.stdName, hostelAdmission.hAdmission_Id, hostelAdmission.paidAdmissionFee,hostelAdmission.admissionDate, hostelAdmission.roomNo FROM hostelAdmission INNER JOIN students_Info ON students_Info.std_Id = hostelAdmission.std_Id WHERE hAdmission_Id =  $id";

    $rslt = mysqli_query($conn, $sql)
          or die("Error in fetching records");

    $rows = mysqli_fetch_all($rslt, MYSQLI_ASSOC);
    //print_r($rows);

    foreach($rows as $row){

    }
  }



  ?>
  <!-- updates -->
  <section id="update">
    <div class="container">
      <div class="row">
        <div class="col">
          <div class="card card-header text-center shadow-lg p-2 mb-3 bg-white rounded" id="cardScheme">
            <h4 class="font-weight-bold  pt-1">Scheme Update</h4>
            <div class="card-body">
              <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="form-group">
                  <label for="schmName" class="text-dark text-monospace">Scheme Name</label>
                  <input type="hidden" value="<?php echo $id; ?>" name="uptdSchId">
                  <input type="text" class="form-control text-center" name="newSchmName" id="schmName" value="<?php echo $rowSch[0]; ?>">
                </div>
                <input type="submit" class="btn btn-outline-info btn-block" value="Update Scheme" name="updateScheme">
              </form>
            </div>  
          </div>

          <div class="card card-header text-center shadow-lg p-2 mb-3 bg-white rounded " id="cardTherapy">
          <h4 class="font-weight-bold pt-1">Therapy Update</h4>
            <div class="card-body">
              <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="form-group">
                  <label for="thpyName" class="text-dark text-monospace">Therapy Name</label>
                  <input type="hidden" value="<?php echo $thp_id; ?>" name="uptdThpyId">
                  <input type="text" class="form-control text-center" name="newThpyName" id="thpyName" value="<?php echo $rowThp[0]; ?>">
                </div>
                <input type="submit" class="btn btn-outline-info btn-block" value="Update Therapy" name="updateTherapy">
              </form>
            </div>  
          </div>

          <div class="card card-header text-center shadow-lg p-2 mb-3 bg-white rounded"       id="cardMonthFee">
            <h4 class="font-weight-bold pt-1">Monthly Fee Update</h4>
            <div class="card-body">
              <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="form-group">
                  <label for="feeType" class="text-dark text-monospace">Fee Type</label>
                  <input type="hidden" value="<?php echo $mFee_id; ?>" name="uptdMonFeeId">
                  <input type="text" class="form-control text-center" name="newFeeType" id="feeType" value="<?php echo $rowMonFee[0]; ?>">
                </div>
                <div class="form-group text-center">
                  <label for="feeAmt" class="text-dark text-monospace">Fee Amount</label>
                  <input type="number" class="form-control text-center" name="newFeeAmt" id="feeAmt" value="<?php echo $rowMonFee[1]; ?>">
                </div>
                <input type="submit" class="btn btn-outline-info btn-block" value="Update Fee Type" name="updateFeeType">
              </form>
            </div>  
          </div>

          <div class="card card-header text-center shadow-lg p-2 mb-3 bg-white rounded"       id="cardRespite">
            <h4 class="font-weight-bold pt-1">Respite Update</h4>
            <div class="card-body">
              <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="form-group">
                  <label for="feeType" class="text-dark text-monospace">Admission Fee</label>
                  <input type="hidden" value="<?php echo $rowMonFee[0]; ?>" name="uptdRespiteId">
                  <input type="text" class="form-control text-center" name="newAdmFee" value="<?php echo $rowMonFee[1]; ?>">
                </div>
                <div class="form-group text-center">
                  <label for="feeAmt" class="text-dark text-monospace">Monthly Fee</label>
                  <input type="number" class="form-control text-center" name="newMonthFee" value="<?php echo $rowMonFee[2]; ?>">
                </div>
                <div class="form-group text-center">
                  <label for="feeAmt" class="text-dark text-monospace">Capacity</label>
                  <input type="number" class="form-control text-center" name="newCapacity" value="<?php echo $rowMonFee[3]; ?>">
                </div>
                <input type="submit" class="btn btn-outline-info btn-block" value="Update Respite" name="updateRespite">
              </form>
            </div>  
          </div>

          <div class="card card-header text-center shadow-lg p-2 mb-3 bg-white rounded"       id="cardHosteller">
            <h4 class="font-weight-bold pt-1">Hostellers Update</h4>
            <div class="card-body">
              <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="form-group">
                  <label for="feeType" class="text-dark text-monospace">Name</label>
                  <input type="hidden" value="<?php echo $row['hAdmission_Id']; ?>" name="uptdAhstId">
                  <input type="text" class="form-control text-center" name="newName" value="<?php echo $row['stdName']; ?>">
                </div>
                <div class="form-group text-center">
                  <label for="feeAmt" class="text-dark text-monospace">Admission Fee</label>
                  <input type="number" class="form-control text-center" name="newAdmFee" value="<?php echo $row['paidAdmissionFee']; ?>">
                </div>
                <div class="form-group text-center">
                  <label for="feeAmt" class="text-dark text-monospace">Admission Date</label>
                  <input type="date" class="form-control text-center" name="newAdmDate" value="<?php echo $row['admissionDate']; ?>">
                </div>
                <div class="form-group text-center">
                  <label for="feeAmt" class="text-dark text-monospace">Seat</label>
                  <input type="number" class="form-control text-center" name="newSeat" value="<?php echo $row['roomNo']; ?>">
                </div>
                <input type="submit" class="btn btn-outline-info btn-block" value="Update Hostellers Details" name="updateHostellers">
              </form>
            </div>  
          </div>
        </div>
      </div>
    </div>
  </section>
  <br>
  <!-- Footer -->
  <?php require "includes/footer.php"; ?>
  
<!-- bootstrap script -->
<!-- <script src="scripts/tweaks.js"></script> -->
<script src="JS/bootstrapJquery.js"></script>
<script src="JS/popper.min.js"></script>
<script src="JS/bootstrap.min.js"></script>
</body>
</html>