<?php
    session_start();
    require_once "includes/connect.php";

    if(!isset($_SESSION['username'])){
      header("Location: index.php");
    }

    if(isset($_GET["s_id"])){

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

      foreach ($rowsR as $rowR){

      }
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
<link rel="stylesheet" href="CSS/updateStd.css">
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

            <div class="text-white bg-secondary py-5">
              <div class="d-flex flex-row-reverse text-white">
                <div class="port-item bg-info ">
                <h1 class="text-center display-5 font-italic">Update Details</h1>
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
            <select class="custom-select custom-select-lg" id="scheme" name="scheme_Id"  onchange="validate(this.id)">
              <?php if($rowR[1] == 1): ?>
                <option selected="selected" value="1"> Disha </option>
              <?php else: ?>
                <option value="1"> Disha </option>
              <?php endif; ?>
              <?php if($rowR[1] == 2): ?>
                <option selected="selected" value="2"> Special School </option>
              <?php else: ?>
                <option value="2"> Special School </option>
              <?php endif; ?>
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
              <input type="number" class="form-control" value="<?php echo $rowR[8]; ?>" name="stdAge" id="age" require>
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
          <select class="custom-select custom-select" value="<?php echo $rowR[7]; ?>" name="gender" id="gender" onChange="validateGender(this.id)">
            <?php if($rowR[7] == 'male'): ?>
              <option selected value="male">Male</option>
            <?php else: ?>
            <option value="male">Male</option>
            <?php endif; ?>
            <?php if($rowR[7] == 'female'): ?>
            <option selected value="female">Female</option>
            <?php else: ?>
            <option  value="female">Female</option>
            <?php endif; ?>
            <?php if($rowR[7] == 'others'): ?>
            <option selected value="others">Others</option>
            <?php else: ?>
            <option value="others">Others</option>
            <?php endif; ?>
           
          </select>
          </div>

          <div class="row">
            <div class="mb-4 col">
              <label for="religion">Religion</label>
              <select class="custom-select custom-select-sm" value="<?php echo $rowR[9]; ?>" name="religion" id="religion" onChange="validateReligion(this.id)">

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
            
            </div>

            <div class="mb-4 col">
              <label for="hostel">Caste</label>
              <select class="custom-select custom-select-sm" value="<?php echo $rowR[10]; ?>" name="caste" id="caste" onChange="validateCaste(this.id)">

                <?php if($rowR[10] == 'GEN'): ?>
                  <option value="GEN" selected>GEN</option>
                <?php else: ?>
                  <option value="GEN">GEN</option>
                <?php endif; ?>

                <?php if($rowR[10] == 'OBC'): ?>
                  <option value="OBC" selected>OBC</option>
                <?php else: ?>
                  <option value="OBC">OBC</option>
                <?php endif; ?>

                <?php if($rowR[10] == 'MOBC'): ?>
                  <option value="MOBC" selected>MOBC</option>
                <?php else: ?>
                  <option value="MOBC">MOBC</option>
                <?php endif; ?>

                <?php if($rowR[10] == 'SC'): ?>
                  <option value="SC" selected>SC</option>
                <?php else: ?>
                  <option value="SC">SC</option>
                <?php endif; ?>

              </select>
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
              <input type="text" class="form-control" value="<?php echo $rowR[14]; ?>" name="zip" id="zip" placeholder="Zip Code" require>
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

          <div class="mb-4">
          <label for="hostel">Disability Type</label>
          <select class="custom-select custom-select" value="<?php echo $rowR[17]; ?>" name="disabilityType" id="disability" onChange="validateDisability(this.id)">
            
            <?php if($rowR[17] == 'Orthopedically Handicapped'): ?>
              <option value="Orthopedically Handicapped" selected>Orthopedically Handicapped</option>
            <?php else: ?>
              <option value="Orthopedically Handicapped">Orthopedically Handicapped</option>
            <?php endif; ?>

            <?php if($rowR[17] == 'Mentally Handicapped'): ?>
              <option value="Mentally Handicapped" selected>Mentally Handicapped</option>
            <?php else: ?>
              <option value="Mentally Handicapped">Mentally Handicapped</option>
            <?php endif; ?>

            <?php if($rowR[17] == 'Visually Handicapped'): ?>
              <option value="Visually Handicapped" selected>Visually Handicapped</option>
            <?php else: ?>
              <option value="Visually Handicapped">Visually Handicapped</option>
            <?php endif; ?>

            <?php if($rowR[17] == 'Hearing Handicapped'): ?>
              <option value="Hearing Handicapped" selected>Hearing Handicapped</option>
            <?php else: ?>
              <option value="Hearing Handicapped">Hearing Handicapped</option>
            <?php endif; ?>

            <?php if($rowR[17] == 'Multiple Disabilities'): ?>
              <option value="Multiple Disabilities" selected>Multiple Disabilities</option>
            <?php else: ?>
              <option value="Multiple Disabilities">Multiple Disabilities</option>
            <?php endif; ?>

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
            <select class="custom-select custom-select-sm" value="<?php echo $rowR[22]; ?>" name="hostel" id="hostel" onChange="validateRespite(this.id)">
              
            <?php if($rowR[22] == 'Yes'): ?>
              <option value="Yes" selected>Yes</option>
            <?php else: ?>
              <option value="Yes">Yes</option>
            <?php endif; ?>

            <?php if($rowR[22] == 'No'): ?>
              <option value="No" selected>No</option>
            <?php else: ?>
              <option value="No">No</option>
            <?php endif; ?>

            </select>
            <div class="invalid-feedback">
            
            </div>
            </div>

            <div class="mb-4 col">
            <label for="transpotation">Transpotation</label>
            <select class="custom-select custom-select-sm" value="<?php echo $rowR[23]; ?>" name="transpotation" id="transpotation" onChange="validateTranspotation(this.id)">

              <?php if($rowR[23] == ''): ?>
                <option value="" selected>--</option>
              <?php else: ?>
                <option value="">--</option>
              <?php endif; ?>

              <?php if($rowR[23] == 'Yes'): ?>
                <option value="Yes" selected>Yes</option>
              <?php else: ?>
                <option value="Yes">Yes</option>
              <?php endif; ?>

              <?php if($rowR[23] == 'No'): ?>
                <option value="No" selected>No</option>
              <?php else: ?>
                <option value="No">No</option>
              <?php endif; ?>

            </select>
            <div class="invalid-feedback">
            
            </div>
            </div>

            <div class="mb-4 col">
              <label for="bpl">Income Group</label>
              <select class="custom-select custom-select-sm" value="<?php echo $rowR[24]; ?>" name="incomeGroup" id="incomeGroup" onChange="validateIncome(this.id)">
                
                <?php if($rowR[24] == 'BPL'): ?>
                  <option value="BPL" selected>BPL</option>
                <?php else: ?>
                  <option value="BPL">BPL</option>
                <?php endif; ?>

                <?php if($rowR[24] == 'APL'): ?>
                  <option value="APL" selected>APL</option>
                <?php else: ?>
                  <option value="APL">APL</option>
                <?php endif; ?>

                <?php if($rowR[24] == 'HIG'): ?>
                  <option value="HIG" selected>HIG</option>
                <?php else: ?>
                  <option value="HIG">HIG</option>
                <?php endif; ?>

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

          <button type="submit" id="sub" name="update" class="btn btn-secondary btn-block mt-2">Update</button>
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