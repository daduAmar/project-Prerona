<?php
    session_start();
    require_once "includes/connect.php";

    if(!isset($_SESSION['username'])){
      header("Location: index.php");
    }

    if(isset($_GET['ddrc_id'])){

      $id = $_GET['ddrc_id'];
      
      //ddrc data retrieve
      $sql="SELECT * FROM DDRC WHERE ddrc_Id= $id";
    
      $result = mysqli_query($conn, $sql)
      or die("Error in fetching records");
    
      $DDRCrows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    
      //print_r($DDRCrows);
      foreach($DDRCrows as $DDRCrow){
    
      }
    
    
      if ($result === false) {
    
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
          <a href="<?php echo $DDRCrow['photo']; ?>" data-toggle="lightbox">
          <img src="<?php echo $DDRCrow['photo']; ?>" alt="">
          </a>
        </div>
        <div class="col-lg-9 col-md-7">
          <div class="d-flex flex-column">
            <div class="p-5 bg-dark text-white">
              <h1 class="display-5"><?php echo ucwords($DDRCrow['bName']); ?></h1>
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
        <form method="post" action="stdUpd.php" id="form">
          <div class="form-group">
            <input type="hidden" name="ddrc_id" class="form-control" value="<?php  echo $DDRCrow['ddrc_Id']; ?>">
          </div>

          <div class="form-group" >
            <label>Student Name</label>
            <input type="text" class="form-control form-control" value="<?php echo ucwords($DDRCrow['bName']); ?>" name="bName" id="bName"  require>
            <div class="invalid-feedback">
              Name Should Be In Standard Format e.g. Amarjyoti Gautam
            </div>
          </div>

          <div class="mb-4">
            <label for="hostel">Disability Type</label>
            <select class="custom-select custom-select" value="<?php echo $rowR[17]; ?>" name="disaType" id="disability" onChange="validateDisability(this.id)">
            
            <?php if($DDRCrow["disabilityType"] == 'Orthopedically Handicapped'): ?>
              <option value="Orthopedically Handicapped" selected>Orthopedically Handicapped</option>
            <?php else: ?>
              <option value="Orthopedically Handicapped">Orthopedically Handicapped</option>
            <?php endif; ?>

            <?php if($DDRCrow["disabilityType"] == 'Mentally Handicapped'): ?>
              <option value="Mentally Handicapped" selected>Mentally Handicapped</option>
            <?php else: ?>
              <option value="Mentally Handicapped">Mentally Handicapped</option>
            <?php endif; ?>

            <?php if($DDRCrow["disabilityType"] == 'Visually Handicapped'): ?>
              <option value="Visually Handicapped" selected>Visually Handicapped</option>
            <?php else: ?>
              <option value="Visually Handicapped">Visually Handicapped</option>
            <?php endif; ?>

            <?php if($DDRCrow["disabilityType"] == 'Hearing Handicapped'): ?>
              <option value="Hearing Handicapped" selected>Hearing Handicapped</option>
            <?php else: ?>
              <option value="Hearing Handicapped">Hearing Handicapped</option>
            <?php endif; ?>

            <?php if($DDRCrow["disabilityType"] == 'Multiple Disabilities'): ?>
              <option value="Multiple Disabilities" selected>Multiple Disabilities</option>
            <?php else: ?>
              <option value="Multiple Disabilities">Multiple Disabilities</option>
            <?php endif; ?>
            </select>
          </div>

          <div class="row">  
            <div class="form-group col" >
              <label for="fname">Father Name</label>
              <input type="text" class="form-control" value="<?php echo $DDRCrow['fatherName']; ?>" name="fName" id="fName" require>
              <div class="invalid-feedback">
              Father Name Should Be In Standard Format e.g. Amarjyoti Gautam
              </div>
            </div>

            <div class="form-group col" >
              <label for="mname">Mother Name</label>
              <input type="text" class="form-control" value="<?php echo $DDRCrow['motherName']; ?>" name="mName" id="mName" require>
              <div class="invalid-feedback">
              Mother Name Should Be In Standard Format e.g. Banashree Gautam
              </div>
            </div>
          </div> 
          
          <div class="row">
            <div class="form-group col">
              <label for="admissionDate">Disability %</label>
              <input type="number" class="form-control" value="<?php echo $DDRCrow['disabilityPercent']; ?>" name="disaPer" id="disaPer" require>
              <div class="invalid-feedback">
              Phone Number Must Have Exactly 10 Digits!
              </div>
            </div>
            <div class="form-group col">
              <label for="admissionDate">Phone</label>
              <input type="number" class="form-control" value="<?php echo $DDRCrow['phone']; ?>" name="ph" id="ph" require>
              <div class="invalid-feedback">
              Phone Number Must Have Exactly 10 Digits!
              </div>
            </div>
          </div>

          <div class="row">
            <div class="form-group col">
              <label for="address">Address</label>
              <textarea class="form-control" name="add" id="add" placeholder="Enter applicant's address" require><?php echo $DDRCrow['addres']; ?></textarea>
              <div class="invalid-feedback">
                Should Start With An Uppercase Letter & No Special Characters Are Allowed!
              </div>
            </div>

            <div class="form-group col">
              <label for="admissionDate">Appointment Date</label>
              <input type="date" class="form-control" value="<?php echo $DDRCrow['dateOfAppointment']; ?>" name="aDate" id="aDate" require>
              <div class="invalid-feedback">
              </div>
            </div>
          </div> 

          <div class="row">
            <div class="form-group col">
              <label class="text-center">Age</label>
              <input type="number" class="form-control" value="<?php echo $DDRCrow['age']; ?>" name="age" id="age" require>
            </div>

            <div class="col">
              <label for="gender">Gender</label>
              <select class="custom-select custom-select" name="gender" id="gender" onchange="validateGender(this.id)">
                <?php if($DDRCrow["gender"] == 'male'): ?>
                  <option selected value="male">Male</option>
                <?php else: ?>
                <option value="male">Male</option>
                <?php endif; ?>
                <?php if($DDRCrow["gender"] == 'female'): ?>
                <option selected value="female">Female</option>
                <?php else: ?>
                <option  value="female">Female</option>
                <?php endif; ?>
                <?php if($DDRCrow["gender"] == 'others'): ?>
                <option selected value="others">Others</option>
                <?php else: ?>
                <option value="others">Others</option>
                <?php endif; ?>
              
              </select>
            </div>
            <div class="mb-4 col">
              <label for="religion">Religion</label>
              <select class="custom-select custom-select-sm" name="religion" id="religion" onChange="validateReligion(this.id)">

              <?php if($DDRCrow["religion"] == 'hindu'): ?>
                <option value="hindu" selected>Hindu</option>
              <?php else: ?>
                <option value="hindu">Hindu</option>
              <?php endif; ?>

              <?php if($DDRCrow["religion"] == 'muslim'): ?>
                <option value="muslim" selected>Muslim</option>
              <?php else: ?>
                <option value="muslim">Muslim</option>
              <?php endif; ?>

              <?php if($DDRCrow["religion"] == 'christain'): ?>
                <option value="christain" selected>Christain</option>
              <?php else: ?>
                <option value="christain">Christain</option>
              <?php endif; ?>

              <?php if($DDRCrow["religion"] == 'sikh'): ?>
                <option value="sikh" selected>Sikh</option>
              <?php else: ?>
                <option value="sikh">Sikh</option>
              <?php endif; ?>

              <?php if($DDRCrow["religion"] == 'jain'): ?>
                <option value="jain" selected>Jain</option>
              <?php else: ?>
                <option value="jain">Jain</option>
              <?php endif; ?>

              <?php if($DDRCrow["religion"] == 'buddhist'): ?>
                <option value="buddhist" selected>Buddhist</option>
              <?php else: ?>
                <option value="buddhist">Buddhist</option>
              <?php endif; ?>

              <?php if($DDRCrow["religion"] == 'parsi'): ?>
                <option value="parsi" selected>Parsi</option>
              <?php else: ?>
                <option value="parsi">Parsi</option>
              <?php endif; ?>

              </select>
            </div>
          </div> 
          
          <div class="row">
            <div class="form-group col">
              <label for="admissionDate">Service Offered</label>
              <input type="text" class="form-control" value="<?php echo $DDRCrow['serviceOffered']; ?>" name="service" id="service" require>
            </div>
            <div class="form-group col">
              <label for="admissionDate">Recommended By</label>
              <input type="text" class="form-control" value="<?php  echo $DDRCrow['recommendedBy']; ?>" name="recommend" id="recommend" require>
            </div>
          </div>

        
          <div class="form-group" >
            <label for="aadhar">Aadhar Number</label>
            <input type="text" class="form-control" value="<?php echo $DDRCrow['aadharNo']; ?>" name="aadhar" id="aadhar" placeholder="Provide aadhar number if any!">
          </div>

          <button type="submit" id="sub" name="updateDDRC" class="btn btn-secondary btn-block mt-2">Update</button>
          <br>
        </form>
        </div>
      </div>
    </div>
    </footer>
  </div>


   <!-- bootstrap script -->
   <script src="scripts/ddrcValidate.js"></script>
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