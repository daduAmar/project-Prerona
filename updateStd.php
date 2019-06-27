<?php
 session_start();
 require_once "includes/connect.php";

 //$sid = $_GET['s_id'];

 if(!isset($_SESSION['username'])){
  header("Location: preronaHome.php");
}

$sql="SELECT * FROM scheme";
    $result = mysqli_query($conn,$sql) or die(mysqli_error($conn));

 
 if(isset($_GET['s_id'])){

    $sid = $_GET['s_id'];
    
    //students docs retrieve
    $sql1="SELECT * FROM studentDocuments WHERE std_Id= $sid";

    $result1 = mysqli_query($conn, $sql1)
    or die("Error in fetching records");

    $rows = mysqli_fetch_all($result1);


    foreach ($rows as $row){
    
    }

    if ($result1 === false) {

    exit("Couldn't execute the query." . mysqli_error($conn));

    }

    //students details
    $sql2="SELECT * FROM students_Info WHERE std_Id= $sid";

    $result2 = mysqli_query($conn, $sql2)
    or die("Error in fetching records");

    $rowsR = mysqli_fetch_all($result2);

     //print_r($rowsR);

    foreach ($rowsR as $rowR){

    }
    //print_r($rowR);
    if ($result2 === false) {

    exit("Couldn't execute the query." . mysqli_error($conn));

    }
 }

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>sprofile</title>
<link rel="stylesheet" href="CSS/bootstrap.min.css" >
<link rel="stylesheet" href="CSS/monFee.css" >
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css" />
<link rel="stylesheet" href="CSS/stdProfile.css">
</head>
<body>

  <div class="container">
    <header id="main-header">
      <div class="row no-gutters">
        <div class="col-lg-3 col-md-5">
          <a href="<?php echo $row[2]; ?>" data-toggle="lightbox">
            <img src="<?php echo $row[2]; ?>" alt="" width="267" height="260"
            class="img-fluid img-thumbnail"> 
          </a>
        </div>
        <div class="col-lg-9 col-md-7">
          <div class="d-flex flex-column">
            <div class="p-4 bg-dark text-white">
              <h1 class="display-5"><?php echo ucwords($rowR[2]); ?>
              </h1>
              <small class="font-italic h3 ml-2"><?php echo ucfirst($rowR[7]); ?></small>
            </div>

            <div class="text-white bg-secondary text-center p-4">
              <div class="d-flex flex-row text-white ">
                <div class="port-item text-center font-weight-bold text-monospace">
                <h1 class="display-4">Update </h1>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </header>

    


    <!-- FOOTER -->
    <footer id="main-footer" class="p-5 card card-body shadow-lg shadow-lg">
    <div class="container">
      <div class="row">
        <div class="col">
        <form method="post" action="stdUpd.php" id="form">
          <div class="mb-4">
            <label for="scheme">Select Scheme</label>
            <?php 
                $schVal = $rowR[0];
             ?>
            <select class="custom-select custom-select-lg" id="scheme" name="scheme_Id"  onchange="validate(this.id)">
              <?php while ($row = mysqli_fetch_assoc($result)): ?>

              <?php if($schVal == $row['schemeName']): ?>

                <option selected="selected" value="<?php echo $row['scheme_Id'] ?>"> <?php echo $row['schemeName'];?> </option>

              <?php else: ?>

              <option value="<?php echo $row['scheme_Id'] ?>"> <?php echo $row['schemeName'];?>
             </option>

              <?php endif; ?>

              <?php endwhile; ?>
            </select>

            <div class="invalid-feedback">
              Select a Scheme Name!
            </div>

          </div>

          <div class="form-group">
            <input type="hidden" name="sid" class="form-control" value="<?php echo $rowR[0]; ?>">
          </div>

          <div class="form-group" >
            <label>Student Name</label>
            <input type="text" class="form-control form-control" value="<?php echo $rowR[2]; ?>" id="stdName" name="name" placeholder="Enter name" require>
            <div class="invalid-feedback">
              Name Should Be In Standard Format e.g. Amarjyoti Gautam
            </div>
          </div>

          <div class="row">  
            <div class="form-group col" >
              <label for="dob">Date Of Birth</label>
              <input type="date" class="form-control" value="<?php echo $rowR[3]; ?>" name="birthDate" id="dob" require>
              <div class="invalid-feedback">
            
              </div>
            </div>

            <div class="form-group col">
              <label class="text-center">Age</label>
              <input type="number" readonly class="form-control" value="<?php echo $rowR[8]; ?>" name="stdAge" id="age" require>
              <small class="text-muted">Enter Date Of Birth to calculate age!</small>
            </div>
          </div>  

          <div class="form-group" id="bPlace" >
            <label for="pob">Place Of Birth</label>
            <input type="text" class="form-control" value="<?php echo $rowR[4]; ?>" name="birthPlace" id="pob" placeholder="Enter place of birth" require>
            <div class="invalid-feedback">
              Birth Place Should Start With A Uppercase Letter & Cannot Include Numeric!
            </div>
          </div>

          <div class="row">  
            <div class="form-group col" >
              <label for="fname">Father Name</label>
              <input type="text" class="form-control" value="<?php echo $rowR[5]; ?>" name="fatherName" id="fname" placeholder="Father Name" require>
              <div class="invalid-feedback">
              Father Name Should Be In Standard Format e.g. Amarjyoti Gautam
              </div>
            </div>

            <div class="form-group col" >
              <label for="mname">Mother Name</label>
              <input type="text" class="form-control" value="<?php echo $rowR[6]; ?>" name="motherName" id="mname" placeholder="Mother Name" require>
              <div class="invalid-feedback">
              Mother Name Should Be In Standard Format e.g. Banashree Gautam
              </div>
            </div>
          </div>  

          <div class="mb-4">
          <label for="gender">Gender</label>
          <?php 
            $genVal = $rowR[7];
          ?>
          <select class="custom-select custom-select" value="<?php echo $rowR[7]; ?>" name="gender" id="gender" onchange="validateGender(this.id)">
            <?php if($genVal == 'male'): ?>
              <option selected value="male">Male</option>
            <?php else: ?>
            <option value="male">Male</option>
            <?php endif; ?>
            <?php if($genVal == 'female'): ?>
            <option selected value="female">Female</option>
            <?php else: ?>
            <option  value="female">Female</option>
            <?php endif; ?>
            <?php if($genVal == 'others'): ?>
            <option selected value="others">Others</option>
            <?php else: ?>
            <option value="others">Others</option>
            <?php endif; ?>
           
          </select>
          <div class="invalid-feedback">
            Select a Gender!
          </div>
          </div>

          <div class="row">
            <div class="mb-4 col">
            <label for="religion">Religion</label>
            <select class="custom-select custom-select-sm" value="<?php echo $rowR[9]; ?>" name="religion" id="religion">

            
            <?php if($rowR[9] == 'hindu'): ?>
              <option value="hindu" selected>Hindu</option>
            <?php else: ?>
              <option value="hindu">Hindu</option>
            <?php endif; ?>

            <?php if($rowR[9] == 'muslim'): ?>
              <option value="muslim" selected>Muslim</option>
            <?php else: ?>
              <option value="muslim">Muslim</option>
            <?php endif; ?>


            <?php if($rowR[9] == 'christain'): ?>
              <option value="christain" selected>Christain</option>
            <?php else: ?>
              <option value="christain">Christain</option>
            <?php endif; ?>

            <?php if($rowR[9] == 'sikh'): ?>
              <option value="sikh" selected>Sikh</option>
            <?php else: ?>
              <option value="sikh">Sikh</option>
            <?php endif; ?>

            <?php if($rowR[9] == 'jain'): ?>
              <option value="jain" selected>Jain</option>
            <?php else: ?>
              <option value="jain">Jain</option>
            <?php endif; ?>

            <?php if($rowR[9] == 'buddhist'): ?>
              <option value="buddhist" selected>Buddhist</option>
            <?php else: ?>
              <option value="buddhist">Buddhist</option>
            <?php endif; ?>

            <?php if($rowR[9] == 'parsi'): ?>
              <option value="parsi" selected>Parsi</option>
            <?php else: ?>
              <option value="parsi">Parsi</option>
            <?php endif; ?>

            </select>
            <div class="invalid-feedback">
            
            </div>
            </div>

            <div class="mb-4 col">
              <label for="hostel">Caste</label>
              <select class="custom-select custom-select-sm" value="<?php echo $rowR[10]; ?>" name="caste" id="caste">
                <option selected>Select Caste</option>
                <option value="GEN">GEN</option>
                <option value="OBC">OBC</option>
                <option value="MOBC">MOBC</option>
                <option value="SC">SC</option>
                <option value="ST">ST</option>
              </select>
              <div class="invalid-feedback">
            
            </div>
            </div>
          </div>  

          <div class="form-group">
            <label for="address">Address</label>
            <textarea class="form-control" name="address"  id="address" placeholder="Enter applicant's address" require><?php echo $rowR[11]; ?></textarea>
            <div class="invalid-feedback">
              Should Start With An Uppercase Letter & No Special Characters Are Allowed!
            </div>
          </div>

          <div class="row">
            <div class="form-group col">
              <label for="class">State</label>
              <input type="text" class="form-control" value="<?php echo $rowR[12]; ?>" name="state" id="state" placeholder="State" require>
              <div class="invalid-feedback">
              State  Should Start With An Uppercase Letter & Only Letters Allowed!
              </div>
            </div>

            <div class="form-group col">
              <label for="class">District</label>
              <input type="text" class="form-control" value="<?php echo $rowR[13]; ?>" name="dist" id="dist" placeholder="District" require>

              <div class="invalid-feedback">
              District Should Start With An Uppercase Letter & Only Letters Allowed!
              </div>
            </div>

            <div class="form-group col">
              <label for="class">Zip Code</label>
              <input type="text" class="form-control" value="<?php echo $rowR[15]; ?>" name="zip" id="zip" placeholder="Zip Code" require>
              <div class="invalid-feedback">
              Zip Should Have Exactly 6 Digits!
              </div>
            </div>
          </div>  

          <div class="form-group" >
            <label for="class">Class</label>
            <input type="text" class="form-control" value="<?php echo $rowR[16]; ?>" name="class" id="class" placeholder="Class" require>
            <div class="invalid-feedback">
              Only Alpha-numerics Allowed!
            </div>
          </div>

          <div class="mb-4" id="disability">
          <label for="hostel">Disability Type</label>
          <select class="custom-select custom-select" value="<?php echo $rowR[17]; ?>" name="disabilityType">
            <option selected>Select Applicant's Disability</option>
            <option value="Orthopedically Handicapped">Orthopedically Handicapped</option>
            <option value="Mentally Handicapped">Mentally Handicapped</option>
            <option value="Visually Handicapped">Visually Handicapped</option>
            <option value="Hearing Handicapped">Hearing Handicapped</option>
            <option value="Multiple Disabilities">Multiple Disabilities</option>
          </select>
          <div class="invalid-feedback">
            
            </div>
          </div>

          <div class="row">
            <div class="form-group col">
              <label for="admissionDate">Admission Date</label>
              <input type="date" class="form-control" value="<?php echo $rowR[19]; ?>" name="admissionDate" id="admissionDate" require>
              <div class="invalid-feedback">
            
              </div>
            </div>

            <div class="form-group col">
              <label for="admissionDate">Phone</label>
              <input type="text" class="form-control" value="<?php echo $rowR[15]; ?>" name="phone" id="phone" placeholder="Phone Number" require>
              <div class="invalid-feedback">
              Phone Number Must Have Exactly 10 Digits!
              </div>
            </div>
          </div>
          

          <div class="row">  
            <div class="mb-4 col">
            <label for="hostel">Respite</label>
            <select class="custom-select custom-select-sm" value="<?php echo $rowR[22]; ?>" name="hostel" id="hostel">
              <option selected>Choose..</option>
              <option value="Yes">Yes</option>
              <option value="No">No</option>
            </select>
            <div class="invalid-feedback">
            
            </div>
            </div>

            <div class="mb-4 col">
            <label for="transpotation">Transpotation</label>
            <select class="custom-select custom-select-sm" value="<?php echo $rowR[23]; ?>" name="transpotation" id="transpotation">
              <option selected>Choose..</option>
              <option value="Yes">Yes</option>
              <option value="No">No</option>
            </select>
            <div class="invalid-feedback">
            
            </div>
            </div>

            <div class="mb-4 col">
              <label for="bpl">Income Group</label>
              <select class="custom-select custom-select-sm" value="<?php echo $rowR[24]; ?>" name="incomeGroup" id="bpl">
                <option selected>Select a group</option>
                <option value="BPL">BPL</option>
                <option value="APL">APL</option>
                <option value="HIG">HIG</option>
              </select>
              <div class="invalid-feedback">
              
              </div>
            </div>
          </div>  

          <div class="form-group" >
            <label for="iCard">I-Card Number</label>
            <input type="text" class="form-control" value="<?php echo $rowR[28]; ?>" name="iCard" id="iCard" placeholder="Provide applicant's school I-Card number">
            <div class="invalid-feedback">
            
            </div>
          </div>

          <div class="form-group" >
            <label for="aadhar">Aadhar Number</label>
            <input type="text" class="form-control" value="<?php echo $rowR[29]; ?>" name="aadhar" id="aadhar" placeholder="Provide aadhar number if any!">
            <div class="invalid-feedback">
              Only Digits Allowed!
            </div>
          </div>

          <div class="row">
            <div class="form-group col" >
              <label for="bankDtls">Bank A/c Number</label>
              <input type="text" class="form-control" value="<?php echo $rowR[25]; ?>" name="bankDtls" id="ac" placeholder="A/c No. ">
              <div class="invalid-feedback">
              Only Digits Allowed!
              </div>
            </div>

            <div class="form-group col" >
              <label for="ifsc">IFSC Code</label>
              <input type="text" class="form-control" value="<?php echo $rowR[26]; ?>" name="ifsc" id="ifsc" placeholder="IFSC Code">
              <div class="invalid-feedback">
              Only Alpha-numerics Allowed!
              </div>
            </div>

            <div class="form-group col" >
              <label for="bankBranch">Branch Name</label>
              <input type="text" class="form-control" value="<?php echo $rowR[27]; ?>" name="bankBranch" id="branch" placeholder="Branch Name">
              <div class="invalid-feedback">
              Branch Name Should Start With An Uppercase Letter & Only Letters Allowed!
              </div>
            </div>
            
          </div>

          <button type="submit" id="sub" name="update" class="btn btn-info btn-block mt-2">Update</button>
          <br>
        </form>
        </div>
      </div>
    </div>
    </footer>
  </div>


   <!-- bootstrap script -->
  <script src="scripts/validateStd_dlts.js"></script>
  <script src="JS/bootstrapJquery.js"></script>
  <script src="JS/popper.min.js"></script>
  <script src="JS/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>

  <script>
    $('.port-item').click(function () {
      $('.collapse').collapse('hide');
    });
    
    $(document).on('click', '[data-toggle="lightbox"]', function (e) {
      e.preventDefault();
      $(this).ekkoLightbox();
    });
  </script>
</body>
</html>