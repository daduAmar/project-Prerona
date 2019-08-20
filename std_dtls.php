<?php 
    session_start();
    include_once "includes/connect.php";

    if(!isset($_SESSION['username'])){
      header("Location: index.php");
    }

    $sql="SELECT * FROM scheme";
    $result = mysqli_query($conn,$sql) or die(mysqli_error($conn));

    if(isset($_POST["submit"])){
      
      $schemeId = trim($_POST["scheme_Id"]);
      $name = trim($_POST["name"]);
      $bDate = trim($_POST["birthDate"]);
      $stdAge = trim($_POST["stdAge"]);
      $bPlace = trim($_POST["birthPlace"]);
      $fatherName = trim($_POST["fatherName"]);
      $motherName = trim($_POST["motherName"]);
      $gender = trim($_POST["gender"]);
      $religion = trim($_POST["religion"]);
      $caste = trim($_POST["caste"]);
      $address = trim($_POST["address"]);
      $state = trim($_POST["state"]);
      $district = trim($_POST["dist"]);
      $zip = trim($_POST["zip"]);
      $phone = trim($_POST["phone"]);
      $class = trim($_POST["class"]);
      $disability = trim($_POST["disabilityType"]);
      $admissionDate = trim($_POST["admissionDate"]);
      $hostel = trim($_POST["hostel"]);
      $incomeGroup = trim($_POST["incomeGroup"]);
      $iCard = trim($_POST["iCard"]);
      $aadharNo = trim($_POST["aadhar"]);
      $bankAcNo = trim($_POST["bankDtls"]); 
      $bankIFSC = trim($_POST["ifsc"]);
      $bankBranch = trim($_POST["bankBranch"]);
      $transpotation = '';
      $is_empty = false;
      $inserted = false;
      $empty_msg = '';

      if(isset($_POST["transpotation"])){
        $transpotation = trim($_POST["transpotation"]);
      }
  
      // Prepare an insert statement
      $sql = "INSERT INTO students_Info (scheme_id, stdName, dob, placeOfBirth, fatherName, motherName, gender, age, religion, caste, addres, statee, district, zip, phone, class, disabilityType, dateOfAdmission, hostel, transpotation, incomeGroup, bankAcNo, ifsc, bankBranch, iCard,  aadharNo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
      
      if($stmt = mysqli_prepare($conn, $sql)){

        if(empty($name) || empty($stdAge) || empty($bPlace) || empty($fatherName) || empty($motherName) ||empty($address) || empty($state) || empty($district) || empty($zip) || empty($phone) || empty($class) || $schemeId == -1 || $gender == -1 || $religion == -1 || $caste == -1 || $disability == -1 || $hostel == -1 || $incomeGroup == -1){

          $is_empty =true;
          $empty_msg = "Please fill all the mandatory fields..!";

        } else{

          // Bind variables to the prepared statement as parameters
          mysqli_stmt_bind_param($stmt, "issssssisssssssssssssisssi", $schemeId, $name, $bDate, $bPlace, $fatherName, $motherName, $gender, $stdAge, $religion, $caste, $address, $state, $district, $zip,  $phone, $class, $disability, $admissionDate, $hostel, $transpotation, $incomeGroup, $bankAcNo, $bankIFSC, $bankBranch, $iCard, $aadharNo);

          if(mysqli_stmt_execute($stmt)){

            $s_Id = mysqli_insert_id($conn);

            $_SESSION['std_id'] = $s_Id;
            
            echo "Records inserted successfully.";

            $inserted = true;
          }
        
          
          if($hostel == 'Yes' && $inserted == true){

            header("Location: hostelAdmission.php");
            exit;

          }else {

            header("Location: upload.php");
            exit;

          }
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
  <link rel="stylesheet" href="CSS/bootstrap.min.css" > 
  <link rel="stylesheet" href="CSS/stdReg.css" > 
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
  <title>Student Registration</title>
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
            <a href="std_dtls.php" class="nav-link active">Student Registration</a>
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
  <header id="main-header" class="py-2 bg-info text-white">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <h1>
          <i class="fas fa-user-plus"></i> Student Registration</h1>
        </div>
      </div>
    </div>
  </header>

  <section id="search" class="p-3 bg-light">

    <p class="font-italic text-muted ml-2">Please Provide The Following Details To Register... </p>

    <div class="d-flex flex-row-reverse">
      <p class="text-danger font-italic mr-2">*Mandatory</p>
    </div>
  </section>



    <!-- body SECTION -->
    <section id="body-section" class="mt-3 mb-2">
      <div class="container">

      <?php if(isset($_POST["submit"]) && $is_empty === true): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <?php
            echo isset($empty_msg) ? $empty_msg : "";
          ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?php endif; ?>

        <div class="row">
          <div class="col-lg-6 offset-lg-3 rounded shadow-lg px-4 py-3 my-3">
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="form">

              <div class="mb-4 text-center">
                <span class="text-danger">*</span>
                <label for="scheme">Select Scheme</label>
                <select class="custom-select" id="scheme" name="scheme_Id"  onChange="validate(this.id)">
                    <option value="-1" selected>Select a scheme</option>
                  <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    
                    <option value="<?php echo $row['scheme_Id'] ?>"> <?php echo $row['schemeName'] ?> </option>
   
                  <?php endwhile; ?>
                </select>

                <div class="invalid-feedback">
                  Select a Scheme Name!
                </div>

              </div>

              <div class="form-group" >
                <span class="text-danger">*</span>
                <label>Student Name</label>
                <input type="text" class="form-control" id="stdName" name="name" placeholder="Enter name" value="<?php echo (isset($name)) ? $name: '';?>" require>
                <div class="invalid-feedback">
                  Name Should Be In Standard Format e.g. Amarjyoti Gautam
                </div>
              </div>

              <div class="row">  
                <div class="form-group col" >
                  <span class="text-danger">*</span>
                  <label for="dob">Date Of Birth</label>
                  <input type="date" class="form-control" name="birthDate" id="dob" value="<?php echo (isset($bDate)) ? $bDate: '';?>" require>
                </div>

                <div class="form-group col">
                  <span class="text-danger">*</span>
                  <label class="text-center">Age</label>
                  <input type="number" readonly class="form-control" name="stdAge" value="<?php echo (isset($stdAge)) ? $stdAge: '';?>" id="age" require>
                  <small class="text-muted">Age will be automatically calculated from DOB</small>
                </div>
              </div>  

              <div class="form-group" id="bPlace" >
                <span class="text-danger">*</span>
                <label for="pob">Place Of Birth</label>
                <input type="text" class="form-control" name="birthPlace" id="pob" placeholder="Enter place of birth" value="<?php echo (isset($bPlace)) ? $bPlace : '';?>" require>
                <div class="invalid-feedback">
                  Birth Place Should Start With A Uppercase Letter & Cannot Include Numeric!
                </div>
              </div>

              <div class="row">  
                <div class="form-group col" >
                  <span class="text-danger">*</span>
                  <label for="fname">Father Name</label>
                  <input type="text" class="form-control" name="fatherName" id="fname" placeholder="Father Name" value="<?php echo (isset($fatherName)) ? $fatherName : '';?>" require>
                  <div class="invalid-feedback">
                  Father Name Should Be In Standard Format e.g. Amarjyoti Gautam
                  </div>
                </div>

                <div class="form-group col" >
                  <span class="text-danger">*</span>
                  <label for="mname">Mother Name</label>
                  <input type="text" class="form-control" name="motherName" id="mname" placeholder="Mother Name" value="<?php echo (isset($motherName)) ? $motherName : '';?>" require>
                  <div class="invalid-feedback">
                  Mother Name Should Be In Standard Format e.g. Banashree Gautam
                  </div>
                </div>
              </div>  

              <div class="mb-4">
                <span class="text-danger">*</span>
                <label for="gender">Gender</label>
                <select class="custom-select custom-select-sm" name="gender" id="gender" onChange="validateGender(this.id)">
                  <option value="-1" selected>Select Gender</option>
                  <option value="male">Male</option>
                  <option value="female">Female</option>
                  <option value="others">Others</option>
                </select>
                <div class="invalid-feedback">
                  Select a Gender!
                </div>
              </div>

              <div class="row">
                <div class="mb-4 col">
                  <span class="text-danger">*</span>
                  <label for="religion">Religion</label>
                  <select class="custom-select custom-select-sm" name="religion" id="religion" onChange="validateReligion(this.id)">
                    <option value="-1" selected>Select religion</option>
                    <option value="hindu">Hindu</option>
                    <option value="muslim">Muslim</option>
                    <option value="christain">Christain</option>
                    <option value="sikh">Sikh</option>
                    <option value="jain">Jain</option>
                    <option value="buddhist">Buddhist</option>
                    <option value="parsi">Parsi</option>
                  </select>
                  <div class="invalid-feedback">
                  Select a Religion!
                  </div>
                </div>

                <div class="mb-4 col">
                  <span class="text-danger">*</span>
                  <label for="hostel">Caste</label>
                  <select class="custom-select custom-select-sm" name="caste" id="caste" onChange="validateCaste(this.id)">
                    <option value="-1" selected>Select Caste</option>
                    <option value="GEN">GEN</option>
                    <option value="OBC">OBC</option>
                    <option value="MOBC">MOBC</option>
                    <option value="SC">SC</option>
                    <option value="ST">ST</option>
                  </select>
                  <div class="invalid-feedback">
                  Select a Caste!
                </div>
                </div>
              </div>  

              <div class="form-group">
                <span class="text-danger">*</span>
                <label for="address">Address</label>
                <textarea class="form-control" name="address" id="address" placeholder="Enter applicant's address" require><?php echo (isset($address)) ? $address : '';?></textarea>
                <div class="invalid-feedback">
                  Should Start With An Uppercase Letter & No Special Characters Are Allowed!
                </div>
              </div>

              <div class="row">
                <div class="form-group col">
                  <span class="text-danger">*</span>
                  <label for="class">State</label>
                  <input type="text" class="form-control" name="state" id="state" placeholder="State" value="<?php echo (isset($state)) ? $state : '';?>" require>
                  <div class="invalid-feedback">
                  State  Should Start With An Uppercase Letter & Only Letters Allowed!
                  </div>
                </div>

                <div class="form-group col">
                  <span class="text-danger">*</span>
                  <label for="class">District</label>
                  <input type="text" class="form-control" name="dist" id="dist" placeholder="District" value="<?php echo (isset($district)) ? $district : '';?>" require>

                  <div class="invalid-feedback">
                  District Should Start With An Uppercase Letter & Only Letters Allowed!
                  </div>
                </div>

                <div class="form-group col">
                  <span class="text-danger">*</span>
                  <label for="class">Zip Code</label>
                  <input type="text" class="form-control" name="zip" id="zip" placeholder="Zip Code" value="<?php echo (isset($zip)) ? $zip : '';?>" require>
                  <div class="invalid-feedback">
                  Zip Should Have Exactly 6 Digits!
                  </div>
                </div>
              </div>  

              <div class="form-group">
                <span class="text-danger">*</span>
                <label for="class">Class</label>
                <input type="text" class="form-control" name="class" id="class" placeholder="Class" value="<?php echo (isset($class)) ? $class : '';?>" require>
                <div class="invalid-feedback">
                  Only Alpha-numerics Allowed!
                </div>
              </div>

              <div class="mb-4">
                <span class="text-danger">*</span>
                <label for="hostel">Disability Type</label>
                <select class="custom-select custom-select-sm" name="disabilityType" id="disability" onChange="validateDisability(this.id)">
                  <option value="-1" selected>Select Applicant's Disability</option>
                  <option value="Orthopedically Handicapped">Orthopedically Handicapped</option>
                  <option value="Cerebral Palsy">Cerebral Palsy</option>
                  <option value="Mentally Handicapped">Mentally Handicapped</option>
                  <option value="Visually Handicapped">Visually Handicapped</option>
                  <option value="Hearing Handicapped">Hearing Handicapped</option>
                  <option value="Multiple Disabilities">Multiple Disabilities</option>
                </select>
                <div class="invalid-feedback">
                  Select a Disability Type!
                </div>
              </div>

              <div class="row">
                <div class="form-group col">
                  <span class="text-danger">*</span>
                  <label for="admissionDate">Admission Date</label>
                  <input type="date" class="form-control" name="admissionDate" id="admissionDate" value="<?php echo (isset($admissionDate)) ? $admissionDate : '';?>" require>
                  <div class="invalid-feedback">
                
                  </div>
                </div>

                <div class="form-group col">
                  <span class="text-danger">*</span>
                  <label for="admissionDate">Phone</label>
                  <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone Number" value="<?php echo (isset($phone)) ? $phone : '';?>" require>
                  <div class="invalid-feedback">
                  Phone Number Must Have Exactly 10 Digits!
                  </div>
                </div>
              </div>
              

              <div class="row">  
                <div class="mb-4 col">
                <span class="text-danger">*</span>
                <label for="hostel">Respite</label>
                <select class="custom-select custom-select-sm" name="hostel" id="hostel" onChange="validateRespite(this.id)">
                  <option value="-1" selected>Choose..</option>
                  <option value="Yes">Yes</option>
                  <option value="No">No</option>
                </select>
                <div class="invalid-feedback">
                Select Yes/No!
                </div>
                </div>

                <div class="mb-4 col">
                <span class="text-danger">*</span>
                <label for="transpotation">Transpotation</label>
                <select class="custom-select custom-select-sm" name="transpotation" id="transpotation" onChange="validateTranspotation(this.id)">
                  <option value="-1" selected>Choose..</option>
                  <option value="Yes">Yes</option>
                  <option value="No">No</option>
                </select>
                <div class="invalid-feedback">
                Select Yes/No!
                </div>
                </div>

                <div class="mb-4 col">
                  <span class="text-danger">*</span>
                  <label for="bpl">Income Group</label>
                  <select class="custom-select custom-select-sm" name="incomeGroup" id="incomeGroup" onChange="validateIncome(this.id)">
                    <option value="-1" selected>Select a group</option>
                    <option value="BPL">BPL</option>
                    <option value="APL">APL</option>
                    <option value="HIG">HIG</option>
                  </select>
                  <div class="invalid-feedback">
                  Select a Income Group!
                  </div>
                </div>
              </div>  

              <div class="form-group" >
                <label for="iCard">I-Card Number</label>
                <input type="text" class="form-control" name="iCard" id="iCard" placeholder="Provide applicant's school I-Card number,if any..." value="<?php echo (isset($iCard)) ? $iCard : '';?>">
                <div class="invalid-feedback">
                
                </div>
              </div>

              <div class="form-group" >
                <label for="aadhar">Aadhar Number</label>
                <input type="text" class="form-control" name="aadhar" id="aadhar" placeholder="Provide aadhar number if any!" value="<?php echo (isset($aadharNo)) ? $aadharNo : '';?>">
                <div class="invalid-feedback">
                  Only Digits Allowed!
                </div>
              </div>

              <div class="row">
                <div class="form-group col" >
                  <label for="bankDtls">Bank A/c Number</label>
                  <input type="text" class="form-control" name="bankDtls" id="ac" placeholder="A/c No. if any... " value="<?php echo (isset($bankAcNo)) ? $bankAcNo : '';?>">
                  <div class="invalid-feedback">
                  Only Digits Allowed!
                  </div>
                </div>

                <div class="form-group col" >
                  <label for="ifsc">IFSC Code</label>
                  <input type="text" class="form-control" name="ifsc" id="ifsc" placeholder="IFSC Code,if any..." value="<?php echo (isset($bankIFSC)) ? $bankIFSC : '';?>">
                  <div class="invalid-feedback">
                  Only Alpha-numerics Allowed!
                  </div>
                </div>

                <div class="form-group col" >
                  <label for="bankBranch">Branch Name</label>
                  <input type="text" class="form-control" name="bankBranch" id="branch" placeholder="Branch,if any...">
                  <div class="invalid-feedback" value="<?php echo (isset($bankBranch)) ? $bankBranch : '';?>">
                  Branch Name Should Start With An Uppercase Letter & Only Letters Allowed!
                  </div>
                </div>
                
              </div>

              <button type="submit" id="sub" name="submit" class="btn btn-info btn-block mt-2">Save & Next</button>
              <br>
            </form>
          </div>  
        </div>   
      </div>
    </section>
 
  
  <!-- FOOTER -->
  <?php require "includes/footer.php"; ?>
  
  <!-- bootstrap script -->
  <script src="scripts/age.js"></script>
  <script src="scripts/validateStd_dlts.js"></script>
  <script src="JS/bootstrapJquery.js"></script>
  <script src="JS/popper.min.js"></script>
  <script src="JS/bootstrap.min.js"></script>
</body>
</html>