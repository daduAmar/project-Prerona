<?php
  session_start();
  include_once "includes/connect.php";
  global $std_Id;
  //$std_Id = $_SESSION['std_id'];
     $std_Id = 31;
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

      //income certificate
      $incomeName = $_FILES['income']['name'];
			$incomeTmpName = $_FILES['income']['tmp_name'];
			$incomeSize = $_FILES['income']['size'];
      $incomeError = $_FILES['income']['error'];
			
			$incomeExt = explode('.', $incomeName);
      $incomeActualExt = strtolower(end($incomeExt));

       //bpl certificate
       $bplName = $_FILES['bpl']['name'];
       $bplTmpName = $_FILES['bpl']['tmp_name'];
       $bplSize = $_FILES['bpl']['size'];
       $bplError = $_FILES['bpl']['error'];
       
       $bplExt = explode('.', $bplName);
       $bplActualExt = strtolower(end($bplExt));
 


      //photo type
      $allowedType1 = array('jpg','jpeg', 'png');
      
      //other docs type
      $allowedType2 = array('jpg','jpeg','pdf','docx');

      if(!empty($photoName)){

        $photoDestination = checkFile($photoTmpName, $photoActualExt, $allowedType1, $photoError, $photoSize, 'JPG/JPEG', 'Photo');
        
      } else {
       $photoDestination = '';
       echo "Choose applicant's photo!<br>";
      }
      
      if(!empty($birthCertiName)){

        $birthDestination = checkFile($birthCertiTmpName, $birthCertiActualExt, $allowedType2, $birthCertiError, $birthCertiSize, 'JPG/JPEG/PDF/DOCX', 'Birth Certificate');
      
      } else {
        
        $birthDestination = '';
        echo "Choose applicant's Birth Certificate!<br>";
      }

      if(!empty($casteName)){

        $casteDestination = checkFile($casteTmpName, $casteActualExt, $allowedType2, $casteError, $casteSize, 'JPG/JPEG/PDF/DOCX', 'Caste Certificate');
        
      }else{
        $casteDestination = '';
      }

      if(!empty($disabilityName)){

        $disabilityDestination = checkFile($disabilityTmpName, $disabilityActualExt, $allowedType2, $disabilityError, $disabilitySize,  'JPG/JPEG/PDF/DOCX', 'Disability Certificate');

      }else {
        $disabilityDestination = '';
        echo "Choose  applicant's Disability Certificate!<br>";
      }

      if(!empty($incomeName)){

        $incomeDestination = checkFile($incomeTmpName, $incomeActualExt, $allowedType2, $incomeError, $incomeSize, 'JPG/JPEG/PDF/DOCX', 'Income Certificate');
        
      }else {
        $incomeDestination = '';
        echo "Choose  applicant's Parent Income Certificate!<br>";
      }

      if(!empty($bplName)){

        $bplDestination = checkFile($bplTmpName, $bplActualExt, $allowedType2, $bplError, $bplSize, 'JPG/JPEG/PDF/DOCX', 'BPL Card');
        
      }else {
        $bplDestination = '';
      }
      
      $is_Ok = false;

      if(!empty($photoDestination) && !empty($birthDestination) || !empty($casteDestination) && !empty($casteDestination) && !empty($incomeDestination) || !empty($bplDestination)){

        if(empty($casteDestination) && empty($bplDestination)){
            
          insertFun_No_Caste_Bpl($conn, $std_Id, $photoDestination, $birthDestination, $disabilityDestination, $incomeDestination);
          $is_Ok = true;

        }elseif(!empty($casteDestination) && empty($bplDestination)){
          
          insertFun($conn, $std_Id, $photoDestination, $birthDestination,  $casteDestination, $disabilityDestination, $incomeDestination, $bplDestination);
          $is_Ok = true;

        }elseif (empty($casteDestination) && !empty($bplDestination)) {

          insertFun($conn, $std_Id, $photoDestination, $birthDestination, $casteDestination, $disabilityDestination, $incomeDestination, $bplDestination);
          $is_Ok = true;

        }else {

          insertFun($conn, $std_Id, $photoDestination, $birthDestination, $casteDestination,$disabilityDestination, $incomeDestination, $bplDestination);
          $is_Ok = true;

        }
      }


      //therapy insertion
      if(!empty($_POST['check_list']) && $is_Ok === true){

        $therapy_list = [];

        foreach($_POST['check_list'] as $selected){
          array_push($therapy_list, $selected);
        }
        
        if(in_array(1, $therapy_list) && in_array(2, $therapy_list)){

          $sql = "INSERT INTO therapyRecipient (std_Id, therapy_Id) VALUES
                      ($std_Id, $therapy_list[0]),($std_Id, $therapy_list[1])";
                
          mysqli_query($conn, $sql);
      
        }else {

          if(in_array(1, $therapy_list) || in_array(2, $therapy_list)){

            $sql = "INSERT INTO therapyRecipient (std_Id, therapy_Id) VALUES($std_Id, $therapy_list[0])";
                
          mysqli_query($conn, $sql);

          }

        }
        
      }
    }
    
    function checkFile($fileTemName, $extension, $fileType, $fileError, $fileSize,  $format, $file){

    if(in_array($extension, $fileType)){

      if($fileError === 0){
        
        if($fileSize < 5000000){

         $fileNameNew = uniqid('',true).".".$extension;
          
         $fileDestination = 'uploads/'.$fileNameNew;
          
         move_uploaded_file($fileTemName, $fileDestination);
         return $fileDestination;

        } else {

          echo "Your file size is too big!<br>";

        }
      } else{

        echo "There was an error uploading $file!<br>";

      }
    
    }else {

      echo "$file must be in $format format!<br>";

    }

   
  }
  
  function insertFun($conn, $std_Id, $photoDestination, $birthDestination,  $casteDestination, $disabilityDestination, $incomeDestination, $bplDestination){

     // Prepare an insert statement
     $sql = "INSERT INTO studentDocuments (std_Id, photo, birthCertificate, casteCertificate, disabilityCertificate, incomeCertificate, bplCard) VALUES (?, ?, ?, ?, ?, ?, ?)";
              
      if($stmt = mysqli_prepare($conn, $sql)){

        if(!empty($photoDestination) && !empty($birthDestination) && empty($casteDestination) && !empty($casteDestination) && !empty($incomeDestination) && !empty($bplDestination)){

          // Bind variables to the prepared statement as parameters
          mysqli_stmt_bind_param($stmt, "issssss", $std_Id, $photoDestination, $birthDestination,
          $casteDestination, $disabilityDestination, $incomeDestination, $bplDestination);

          mysqli_stmt_execute($stmt);
          
          echo "Files Uploaded...<br>";

        }

        if (!empty($photoDestination) && !empty($birthDestination) && !empty($casteDestination) && !empty($casteDestination) && !empty($incomeDestination) && empty($bplDestination)) {

          // Bind variables to the prepared statement as parameters
          mysqli_stmt_bind_param($stmt, "issssss", $std_Id, $photoDestination, $birthDestination, $casteDestination, $disabilityDestination, $incomeDestination, $bplDestination);

          mysqli_stmt_execute($stmt);
          
          echo "Files Uploaded...<br>";

        }

        if(!empty($photoDestination) && !empty($birthDestination) && !empty($casteDestination) && !empty($casteDestination) && !empty($incomeDestination) && !empty($bplDestination)){

          // Bind variables to the prepared statement as parameters
          mysqli_stmt_bind_param($stmt, "issssss", $std_Id, $photoDestination, $birthDestination,  $casteDestination, $disabilityDestination, $incomeDestination, $bplDestination);

          mysqli_stmt_execute($stmt);
          
          echo "Files Uploaded...<br>";

        }

      }else {

           echo "ERROR: Could not prepare query: $sql. " . mysqli_error($conn);
      }
       // Close statement
       mysqli_stmt_close($stmt);
  }

  function insertFun_No_Caste_Bpl($conn, $std_Id, $photoDestination, $birthDestination, $disabilityDestination, $incomeDestination){

    // Prepare an insert statement
    $sql = "INSERT INTO studentDocuments (std_Id, photo, birthCertificate, disabilityCertificate, incomeCertificate) VALUES (?, ?, ?, ?, ?)";

     if($stmt = mysqli_prepare($conn, $sql)){

        if(!empty($photoDestination) && !empty($birthDestination) && !empty($disabilityDestination) && !empty($incomeDestination)){

          // Bind variables to the prepared statement as parameters
          mysqli_stmt_bind_param($stmt, "issss", $std_Id, $photoDestination, $birthDestination,   $disabilityDestination, $incomeDestination);
        
          mysqli_stmt_execute($stmt);
          
          echo "Files Uploaded...<br>";

        }  

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
  <header id="main-header" class="py-5 bg-primary text-white" style="">
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
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">

        <!-- therapy -->
        <div class="card shadow p-3 mb-5 bg-white rounded"">
          <div class="card-body">
            <div class="custom-control custom-switch">
              <input type="checkbox" onchange="showCheckBox(this.checked)" class="custom-control-input" id="switch" >
              <label class="custom-control-label font-weight-bold text-monospace" for="switch">Whether applicant need any therapy?</label>
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
          <div class="card-body">
          <p class="text-dark text-muted font-weight-bold text-monospace mt-3 id="heading">Provide the following documents of the applicant</p>   
            <div class="custom-file mt-4 mb-5">
              <input type="file" class="custom-file-input" name="photo" id="photo">
              <label class="custom-file-label" for="file">Photo of the applicant</label>
              <small class="text-info">*Photo must in JPG/JPEG format</small>
            </div>
            <div class="custom-file mb-5">
              <input type="file" class="custom-file-input" name="birthCerti" id="birthCerti">
              <label class="custom-file-label" for="file">Birth Certificate of the applicant</label>
              <small class="text-info">*Birth Certificate must in JPG/JPEG/PDF/DOCX format</small>
            </div>
            <div class="custom-file mb-5">
              <input type="file" class="custom-file-input" name="caste" id="caste">
              <label class="custom-file-label" for="file">Caste Certificate of the applicant,if any</label>
              <small class="text-info">*Caste Certificate must in JPG/JPEG/PDF/DOCX format</small>
            </div>
            <div class="custom-file mb-5">
              <input type="file" class="custom-file-input" name="disability" id="disability">
              <label class="custom-file-label" for="file">Disability Certificate of the applicant</label>
              <small class="text-info">*Disability Certificate must in JPG/JPEG/PDF/DOCX format</small>
            </div>
            <div class="custom-file mb-5">
              <input type="file" class="custom-file-input" name="income" id="income">
              <label class="custom-file-label" for="file">Income Certificate of the applicant</label>
              <small class="text-info">*Income Certificate must in JPG/JPEG/PDF/DOCX format</small>
            </div>
            <div class="custom-file mb-5">
              <input type="file" class="custom-file-input" name="bpl" id="bpl">
              <label class="custom-file-label" for="file">BPL Card of the applicant,if any</label>
              <small class="text-info">*BPL Card must in JPG/JPEG/PDF/DOCX format</small>
            </div>
          </div>
        </div>

        <br>
        <div class="row">
          <div class="col">
            <button type="submit" class="btn btn-primary btn-block" name="submit">Upload</button>
          </div>
          <div class="col">
          <button type="reset" class="btn btn-primary btn-block">Reset</button>
          </div>
          <div class="col">
          <button type="submit" name="next" class="btn btn-primary btn-block" onclick="pageTransition()" id="nextPg">Next</button>
          </div>
        </div>
      </form>  
    </div>
    
    
  <br><br><br>
  <!-- Footer -->
  <?php require "includes/footer.php"; ?>
                
   <!-- bootstrap script -->
   <script src="scripts/pageTransition.js"></script>
   <script src="scripts/thpy.js"></script>
   <script src="JS/bootstrapJquery.js"></script>
   <script src="JS/bootstrap.bundle.min.js"></script>
   <script src="JS/bootstrap.min.js"></script>
</body>
</html>