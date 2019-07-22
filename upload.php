<?php
  session_start();
  include_once "includes/connect.php";

  if(!isset($_SESSION['username'])){
    header("Location: preronaHome.php");
  }

  global $std_Id;
  $std_Id = $_SESSION['std_id'];
  //$std_Id = 16;
  $its_ok_photo = true;
  $its_ok_disability = true;
  $its_ok_birth = true;
  $photo = $disability = $birth = $success = '';
    if(isset($_POST['submit'])){

      //photo
      $photoName = $_FILES['photo']['name'];
			$photoTmpName = $_FILES['photo']['tmp_name'];
			$photoSize = $_FILES['photo']['size'];
      $photoError = $_FILES['photo']['error'];
			
			$photoExt = explode('.', $photoName);
      $photoActualExt = strtolower(end($photoExt));
      

      //birth certificate
      $birthCertiName = $_FILES['birthCerti']['name'];
			$birthCertiTmpName = $_FILES['birthCerti']['tmp_name'];
			$birthCertiSize = $_FILES['birthCerti']['size'];
      $birthCertiError = $_FILES['birthCerti']['error'];
			
			$birthCertiExt = explode('.', $birthCertiName);
      $birthCertiActualExt = strtolower(end($birthCertiExt));
      
      //caste
      $casteName = $_FILES['caste']['name'];
			$casteTmpName = $_FILES['caste']['tmp_name'];
			$casteSize = $_FILES['caste']['size'];
      $casteError = $_FILES['caste']['error'];
			
			$casteExt = explode('.', $casteName);
      $casteActualExt = strtolower(end($casteExt));

      //disability certificate
      $disabilityName = $_FILES['disability']['name'];
			$disabilityTmpName = $_FILES['disability']['tmp_name'];
			$disabilitySize = $_FILES['disability']['size'];
      $disabilityError = $_FILES['disability']['error'];
			
			$disabilityExt = explode('.', $disabilityName);
      $disabilityActualExt = strtolower(end($disabilityExt));

      //income certificate or bpl
      $incomeName = $_FILES['income']['name'];
			$incomeTmpName = $_FILES['income']['tmp_name'];
			$incomeSize = $_FILES['income']['size'];
      $incomeError = $_FILES['income']['error'];
			
			$incomeExt = explode('.', $incomeName);
      $incomeActualExt = strtolower(end($incomeExt));

       //guardianship certificate
       $guardianName = $_FILES['guardian']['name'];
       $guardianTmpName = $_FILES['guardian']['tmp_name'];
       $guardianSize = $_FILES['guardian']['size'];
       $guardianError = $_FILES['guardian']['error'];
       
       $guardianExt = explode('.', $guardianName);
       $guardianActualExt = strtolower(end($guardianExt));

       //niramaya health
       $niramayaName = $_FILES['niramaya']['name'];
       $niramayaTmpName = $_FILES['niramaya']['tmp_name'];
       $niramayaSize = $_FILES['niramaya']['size'];
       $niramayaError = $_FILES['niramaya']['error'];
       
       $niramayaExt = explode('.', $niramayaName);
       $niramayaActualExt = strtolower(end($niramayaExt));
 


      //photo type
      $allowedType1 = array('jpg','jpeg', 'png');
      
      //other docs type
      $allowedType2 = array('jpg','jpeg','pdf','docx');

      if(!empty($photoName)){

        $photoDestination = checkFile($photoTmpName, $photoActualExt);
        
      } else {

       $photoDestination = '';
       $photo = "Please Provide Applicant's photo!";
       $its_ok_photo = false;

      }
      
      if(!empty($birthCertiName)){

        $birthDestination = checkFile($birthCertiTmpName, $birthCertiActualExt);
      
      } else {
        
        $birthDestination = '';
        $birth = "Please Provide Applicant's Birth Certificate!";
        $its_ok_birth = false;

      }

      if(!empty($casteName)){

        $casteDestination = checkFile($casteTmpName, $casteActualExt);
        
      }else{
        $casteDestination = '';
      }

      if(!empty($disabilityName)){

        $disabilityDestination = checkFile($disabilityTmpName, $disabilityActualExt);

      }else {

        $disabilityDestination = '';
        $disability = "Please Provide  Applicant's Disability Certificate!";
        $its_ok_disability = false;

      }

      if(!empty($incomeName)){

        $incomeDestination = checkFile($incomeTmpName, $incomeActualExt);
        
      }else {
        $incomeDestination = '';
      }

      if(!empty($guardianName)){

        $guardianDestination = checkFile($guardianTmpName, $guardianActualExt);
        
      }else {
        $guardianDestination = '';
      }

      if(!empty($niramayaName)){

        $niramayaDestination = checkFile($niramayaTmpName, $niramayaActualExt);
        
      }else {
        $niramayaDestination = '';
      }
      
      $is_Ok = false;

      if(!empty($photoDestination) && !empty($birthDestination) && !empty($disabilityDestination) || !empty($casteDestination) || !empty($incomeDestination) || !empty($guardianDestination) || !empty($niramayaDestination)){

        insertFun($conn, $std_Id, $photoDestination, $birthDestination, $disabilityDestination, $casteDestination,  $incomeDestination, $guardianDestination, $niramayaDestination);
        $is_Ok = true;
      }
      //therapy insertion
      if(!empty($_POST['check_list']) && $is_Ok === true){

        $therapy_list = [];

        foreach($_POST['check_list'] as $selected){
          array_push($therapy_list, $selected);
        }

        for ($i=0; $i < sizeof($therapy_list); $i++) { 

          $sql = "INSERT INTO therapyRecipient (std_Id, therapy_Id) VALUES ($std_Id, $therapy_list[$i])";
              
          mysqli_query($conn, $sql);
        }
      }
    }
    
  function checkFile($fileTemName, $extension){

    $fileNameNew = uniqid('',true).".".$extension;
    
    $fileDestination = 'uploads/'.$fileNameNew;
    
    move_uploaded_file($fileTemName, $fileDestination);
    return $fileDestination;

  }
  
function insertFun($conn, $std_Id, $photoDestination, $birthDestination, $disabilityDestination, $casteDestination, $incomeDestination, $guardianDestination, $niramayaDestination){

  // Prepare an insert statement
  $sql = "INSERT INTO studentDocuments (std_Id, photo, birthCertificate, casteCertificate, disabilityCertificate, incomeCertificate, 	guardianCertificate, 	niramayaCard) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
  
  if(!empty($photoDestination) && !empty($birthDestination) && !empty($disabilityDestination)){

    if($stmt = mysqli_prepare($conn, $sql)){

      
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "isssssss", $std_Id, $photoDestination, $birthDestination,
      $casteDestination, $disabilityDestination, $incomeDestination, $guardianDestination, $niramayaDestination);

      mysqli_stmt_execute($stmt);
      
      $success = "Files Uploaded...! Click Next";
      $its_ok_photo = true;
      $its_ok_birth = true;
      $its_ok_disability = true;


    }else {

      echo "ERROR: Could not prepare query: $sql. " . mysqli_error($conn);

    }

  }else {

    //echo "1st 3 req";

  } 
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Docs</title>
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
            <a href="adminHome.php" class="nav-link ">Dashboard</a>
          </li>
          <li class="nav-item px-2">
            <a href="std_dtls.php" class="nav-link active"> Student Registration </a>
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
  <header id="main-header" class="py-3 bg-info text-white">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <h1><i class="fas fa-file-alt"></i> Therapy & Docs</h1>
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
  
    <?php
      $sql="SELECT * FROM therapy";
      $result = mysqli_query($conn,$sql) or die(mysqli_error($conn));
      $rows = mysqli_fetch_all($result);

      if ($result === false) {
        exit("Couldn't execute the query." . mysqli_error($conn));

      } 
    ?>            
    <br>
    <div class="container">

      <!-- files validation-->
      <?php if(isset($_POST["submit"]) && $its_ok_photo === false): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <?php
            echo isset($photo) ? $photo : "";
          ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?php endif; ?>

      <?php if(isset($_POST["submit"]) && $its_ok_disability === false ): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <?php
            echo isset($disability) ? $disability : "";
          ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?php endif; ?>

      <?php if(isset($_POST["submit"]) && $its_ok_birth === false): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <?php
            echo isset($birth) ? $birth : "";
          ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?php endif; ?>

      <?php if(isset($_POST["submit"]) && $its_ok_photo === true && $its_ok_disability === true && $its_ok_birth === true): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <?php
            echo "Files Uploaded...! Click Next"; 
          ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?php endif; ?>

      <?php if(isset($_GET["enroll"])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <?php
            echo "Student Is Successfully Enrolled Into Respite!"; 
          ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?php endif; ?>




      <!-- file form -->
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">

        <!-- therapy -->
        <div class="card shadow p-3 mb-5 bg-white rounded"">
          <div class="card-body">
            <div class="custom-control custom-switch">
              <input type="checkbox" onchange="showCheckBox(this.checked)" class="custom-control-input" id="switch" >
              <label class="custom-control-label font-weight-bold text-monospace" for="switch">Whether Applicant Need Any Therapeutic Service?</label>
            </div>
            <div id="therapy" class="ml-3 mt-3">
              <?php foreach ($rows as $row): ?>
                <div class="form-check form-check-inline" >
                  <input class="form-check-input" type="checkbox" name="check_list[]" id="inlineCheckbox1" value="<?php echo $row[0]; ?>">
                  <label class="form-check-label" for="inlineCheckbox1"><?php echo $row[1]; ?></label>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>

        <!-- docs input -->
        <div class="card mt-5 shadow-lg p-3 mb-5 bg-white rounded">
        <!-- error msg -->
          <div class="card-body">
          <p class="text-dark text-muted font-weight-bold text-monospace mt-3 id="heading">Provide the following documents of the applicant</p>
            
              <div class="custom-file mt-4">
                <input type="file" class="custom-file-input" name="photo" id="stdPhoto" onchange="photoValidate()">

                <label class="custom-file-label" for="file">Photo of the applicant</label>

                <small class="text-danger">*Necessary</small>
              </div>
              <div id="msgPhoto">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="mb-3" id="prePhoto"></div>

            <div class="custom-file mb-3">
              <input type="file" class="custom-file-input" name="birthCerti" id="birthCerti" onchange="birthValidate()">

              <label class="custom-file-label" for="file">Birth Certificate of the applicant</label>

              <small class="text-danger">*Necessary</small>
            </div>
            <div id="msgBirth">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            <div class="mb-3 alert alert-success text-center" id="bth"></div>

            <div class="custom-file mb-3">
              <input type="file" class="custom-file-input" name="disability" id="disability" onchange="disaValidate()">

              <label class="custom-file-label" for="file">Disability Certificate of the applicant</label>

              <small class="text-danger">*Necessary</small>
            </div>
            <div id="msgDisability">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="mb-3 alert alert-success text-center" id="dis"></div>

            <div class="custom-file mb-4">
              <input type="file" class="custom-file-input" name="caste" id="caste" onchange="casteValidate()">

              <label class="custom-file-label" for="file">Caste Certificate of the applicant,if any..</label>
            </div>
            <div id="msgCaste">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="mb-3 alert alert-success text-center" id="cast"></div>
            
            <div class="custom-file mb-4">
              <input type="file" class="custom-file-input" name="income" id="income" onchange="incomeValidate()">

              <label class="custom-file-label" for="file">Income Certificate/BPL Card of the applicant,if any..</label>
            </div>
            <div id="msgIncome">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="mb-3 alert alert-success text-center" id="incm"></div>

            <div class="custom-file mb-4">
              <input type="file" class="custom-file-input" name="guardian" id="guardian" onchange="guardValidate()">

              <label class="custom-file-label" for="file">Guardianship Certificate of the applicant,if any..</label>
            </div>
            <div id="msgGuard">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="mb-3 alert alert-success text-center" id="guard"></div>

            <div class="custom-file mb-4">
              <input type="file" class="custom-file-input" name="niramaya" id="niramaya" onchange="niraValidate()">

              <label class="custom-file-label" for="file">Niramaya Health Card of the applicant,if any..</label>
            </div>
            <div id="msgNira">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="alert alert-success text-center" id="nira"></div>
          </div>
        </div>

        <br>
        <div class="row">
          <div class="col">
            <button type="submit" id="sub" class="btn btn-info btn-block" name="submit">Upload</button>
          </div>
          <div class="col">
          <button type="button" name="next" class="btn btn-info btn-block" onClick="pageTransition()" id="nextPg">Next</button>
          </div>
        </div>
      </form>  
    </div>
    
    
  <br><br><br>
  <!-- Footer -->
  <?php require "includes/footer.php"; ?>
                
   <!-- bootstrap script -->
   <script src="scripts/uploads.js"></script>
   <script src="scripts/pageTransition.js"></script>
   <script src="scripts/thpy.js"></script>
   <script src="JS/bootstrapJquery.js"></script>
   <script src="JS/bootstrap.bundle.min.js"></script>
   <script src="JS/bootstrap.min.js"></script>
</body>
</html>
