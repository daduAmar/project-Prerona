<?php 
   session_start();
   include_once "includes/connect.php";

   if(!isset($_SESSION['username'])){
    header("Location: preronaHome.php");
  }

   if(isset($_POST['submit'])){

    $beneficaryName = $_POST["bName"];
    $disabilityType = $_POST["disaType"];
    $fatherName = $_POST["fName"];
    $motherName = $_POST["mName"];
    $age = $_POST["age"];
    $gender = $_POST["gender"];
    $religion = $_POST["religion"];
    $disabilityPercent = $_POST["disaPer"];
    $appointmentDate = $_POST["aDate"];
    $address = $_POST["add"];
    $ph = $_POST["ph"];
    $service = $_POST["service"];
    $recommend = $_POST["recommend"];
    $aadhar = $_POST["aadhar"];
    $check_In = false;
    $check_Out = false;
    $sizeError = $fileError = $successMsg = $inputError = '';

     //photo
     $photoName = $_FILES['photo']['name'];
     $photoTmpName = $_FILES['photo']['tmp_name'];
     $photoSize = $_FILES['photo']['size'];
     $photoError = $_FILES['photo']['error'];
     
     $photoExt = explode('.', $photoName);
     $photoActualExt = strtolower(end($photoExt));

    //photo type
    $allowedType = array('jpg','jpeg', 'png');

    if(!empty($_FILES['photo'])){

      if(in_array($photoActualExt, $allowedType)){

        if($photoError === 0){
          
          if($photoSize < 5000000){
    
            $photoNameNew = uniqid('',true).".".$photoActualExt;
            
            $photoDestination = 'uploads/'.$photoNameNew;
            
            move_uploaded_file($photoTmpName, $photoDestination);
    
          } else {
            
            $sizeError = "<em>Your file size is too big!</em>";
            $check_In = true;
    
          }
        } else{
    
          $fileError = "<em>There was an error uploading!</em>";
          $check_In = true;
    
        }
      
      }else {
    
        //echo "File must be in JPG/JPEG/PNG format!<br>";
    
      }
    }   

    //beneficary id
    $Cur_year = date("Y");
    $beneficary_Id = generate_serial($Cur_year);


    // Prepare an insert statement
    $sql = "INSERT INTO DDRC (beneficiary_Id, bName, disabilityType, age, disabilityPercent, dateOfAppointment, fatherName, motherName, gender, religion, addres, phone, aadharNo, serviceOffered, recommendedBy, photo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
      
    if($stmt = mysqli_prepare($conn, $sql)){

      if(!empty($photoDestination)){

        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "sssiissssssiisss", $beneficary_Id, $beneficaryName, $disabilityType, $age, $disabilityPercent, $appointmentDate, $fatherName, $motherName, $gender, $religion,$address, $ph, $aadhar,  $service, $recommend, $photoDestination);
        
        mysqli_stmt_execute($stmt);

        $Id = mysqli_insert_id($conn);

        $successMsg = "<strong>Records inserted successfully</strong>";
        $check_Out = true;

      }else{

        $inputError = "<em>Check your inputs!</em>";
        $check_In = true;
        
      }
       
        
    } else{
        echo "ERROR: Could not prepare query: $sql. " . mysqli_error($conn);
    }
    // Close statement
    mysqli_stmt_close($stmt);

   }

   function generate_serial($year) {
    static $max = 6046; // ZZZZZZ in decimal
    return sprintf(
        "%04s-%04s",
        "DDRC".'-'.$year.'-'.base_convert(random_int(0, $max), 10, 10),
        base_convert(random_int(0, $max), 10, 10)
    );
  }  
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="CSS/bootstrap.min.css" > 
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
  <link rel="stylesheet" href="CSS/ddrc.css">
  <title>DDRC</title>
</head>
   
<body >
  <nav class="navbar navbar-expand-md bg-dark navbar-dark fixed-top" id="main-nav">
    <div class="container">
      <p href="#" class="navbar-brand active font-weight-bolder text-white">DISTRICT DISABILITY REHABILATION CENTER</p>
      <button class="navbar-toggler"
      type="button" data-toggle="collapse"
       data-target="#navbarNav" aria-controls="navbarNav"
       aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a href="ddrcBeneficary.php" class="nav-link font-weight-bolder active"><i class="fas fa-list mr-1"></i>Beneficary List
            </a>
          </li>
          <li class="nav-item">
            <a href="adminHome.php" class="nav-link active"><i class="fas fa-users-cog"></i>Dashboard</a>
          </li>
          <li class="nav-item">
          <a href="u_logout.php" class="nav-link active">
              <i class="fas fa-user-times"></i> Logout
            </a>
          </li>
          
        </ul>
      </div>
    </div>
  </nav>

  
  <!-- HOME SECTION -->
 
  <header id="home-section">
    <div class="dark-overlay">
      <div class="home-inner container mb-5">
      <?php if(isset($_POST["submit"]) && $check_In === true): ?>
        <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
          <?php
            echo isset($sizeError) ? $sizeError : "";
            echo isset($fileError) ? $fileError : "";
            echo isset($inputError) ? $inputError : "";
          ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?php endif; ?>

      <?php if(isset($_POST["submit"]) && $check_Out === true): ?>
        <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
          <?php
            echo isset($successMsg) ? $successMsg : "";
          ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?php endif; ?>
        <div class="row">
          <div class="col-sm-6 offset-sm-3">
            <div class="card bg-success text-center card-form">
              <div class="card-body">
                <form method="post" action="" enctype="multipart/form-data">
                  <div class="row">
                    <div class="form-group col">
                      <input type="text" class="form-control" name="bName" id="bName" placeholder="Beneficary Name" required>
                    </div>
                    <div class="col">
                      <select class="custom-select custom-select" name="disaType" id="disaType">
                        <option selected>Disability Type</option>
                        <option value="Orthopedically Handicapped">Orthopedically Handicapped</option>
                        <option value="Mentally Handicapped">Mentally Handicapped</option>
                        <option value="Visually Handicapped">Visually Handicapped</option>
                        <option value="Hearing Handicapped">Hearing Handicapped</option>
                        <option value="Multiple Disabilities">Multiple Disabilities</option>
                      </select>
                    </div>
                  </div>  

                  <div class="row">
                    <div class="form-group col">
                      <input type="text" class="form-control" name="fName" id="fName" placeholder="Father Name" required>
                    </div>
                    <div class="form-group col">
                      <input type="text" class="form-control" name="mName" id="mName" placeholder="Mother Name" required>
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col">
                      <input type="text" class="form-control" name="disaPer" id="disaPer" placeholder="Disability %" required>
                    </div>
                    <div class="form-group col">
                      <input type="text" class="form-control" name="ph" id="ph" placeholder="Phone" required>
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col">
                      <textarea class="form-control" name="add" id="add" placeholder="Address" required></textarea>
                    </div>
                    <div class="form-group col">
                      <input type="date" class="form-control" name="aDate" id="aDate" placeholder="Appointment Date" required>
                      <small class="text-white">Appointment Date</small>
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col">
                      <input type="text" class="form-control" name="age" id="age" placeholder="Age" required>
                    </div>
                    <div class="col">
                      <select class="custom-select custom-select" name="gender" id="gender">
                        <option selected>Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Others">Others</option>
                      </select>
                    </div>
                    <div class="col">
                      <select class="custom-select custom-select" name="religion" id="religion">
                        <option selected>Religion</option>
                        <option value="hindu">Hindu</option>
                        <option value="muslim">Muslim</option>
                        <option value="christain">Christain</option>
                        <option value="sikh">Sikh</option>
                        <option value="jain">Jain</option>
                        <option value="buddhist">Buddhist</option>
                        <option value="parsi">Parsi</option>
                      </select>
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col">
                      <input type="text" class="form-control" name="service" id="service" placeholder="Service Offered" required>
                    </div>
                    <div class="form-group col">
                      <input type="text" class="form-control" name="recommend" id="recommend" placeholder="Recommended By" required>
                    </div>
                  </div>

                  <div class="form-group">
                      <input type="text" class="form-control" name="aadhar" id="aadhar" placeholder="Adhaar No" required>
                  </div>

                  <div class="custom-file mb-3">
                    <input type="file" class="custom-file-input" name="photo" id="photo" onChange="fileValidate()" require>
                    <label class="custom-file-label" for="file">Beneficary's Photo</label>
                  </div>

                  <div class="mb-3" id="prePhoto"> </div>
              
                  <input type="submit" value="Submit" name="submit" id="submit" class="btn btn-outline-light btn-block">
                </form>
              </div>
            </div>
          </div> 
        </div>
      </div>
    </div>
  </header>
  
  


  <!-- scripts -->
  <script src="scripts/fileValidate.js"></script>
  <script src="JS/bootstrapJquery.js"></script>
  <script src="JS/popper.min.js"></script>
  <script src="JS/bootstrap.min.js"></script>
 
</body>

</html>