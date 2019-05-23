<?php
 session_start();
 require_once "includes/connect.php";

  //monthly fee record
  if(isset($_POST["submit"])){

    $SchFee = $_POST["sFee"];
    $respiteFee = $_POST["hstFee"];
    $transFee = $_POST["transFee"];
    $therapyFee = $_POST["thpyFee"];

    // Prepare an insert statement
    $sql = "INSERT INTO students_Info (scheme_id, stdName, dob, placeOfBirth, fatherName, motherName, gender, age, religion, caste, addres, statee, district, zip, class, disabilityType, dateOfAdmission, hostel, transpotation, incomeGroup, bankAcNo, ifsc, bankBranch, iCard,  aadharNo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
      
    if($stmt = mysqli_prepare($conn, $sql)){
       
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "issssssissssssssssssisssi", $schemeId, $name, $bDate);
      
        mysqli_stmt_execute($stmt);

        $s_Id = mysqli_insert_id($conn);

        $_SESSION['std_id'] = $s_Id;
        
        echo "Records inserted successfully.";
        
    } else{
        echo "ERROR: Could not prepare query: $sql. " . mysqli_error($conn);
    }

    // Close statement
    mysqli_stmt_close($stmt);
 
  }







 
 if(isset($_GET['s_id'])){

   $sid=$_GET['s_id'];
   
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

    // print_r($rowsR);

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
<?php

  $query = "SELECT schemeName FROM scheme WHERE scheme_Id = (SELECT scheme_Id FROM students_Info WHERE std_Id= $sid)";

  $rslt = mysqli_query($conn, $query)
    or die("Error in fetching records");

    $fetchrows = mysqli_fetch_all($rslt);

    foreach ($fetchrows as $fRow){

    }

    if ($rslt === false) {

    exit("Couldn't execute the query." . mysqli_error($conn));

    }

  
?>
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
            <div class="p-5 bg-dark text-white">
              <div class="d-flex flex-row justify-content-start align-items-center">
                <h1 class="display-4"><?php echo ucfirst($rowR[2])." :"; ?>
                </h1>
                
                <div>
                  <small class="font-italic h3 ml-2"><?php echo ucfirst($rowR[7]); ?></small>
                </div>
                <!-- <div>
                  <a href="#" class="text-white">
                  <i class="fab fa-google"></i>
                  </a>
                </div>
                <div>
                  <a href="#" class="text-white">
                </div>
                <div>
                  <a href="" class="text-white">
                  </a>
                </div> -->
              </div>
            </div>

            <div class="p-4 bg-black text-center display-5 font-weight-bolder">
            <?php echo strtoupper($fRow[0]); ?>
            </div>

            <div>
              <div class="d-flex flex-row text-white align-items-stretch text-center">
                <div class="port-item p-4 bg-info" data-toggle="collapse" data-target="#bio">
                <i class="fas fa-book-reader fa-2x"></i>
                  <span class="d-none d-sm-block">Bio</span>
                </div>
                <div class="port-item p-4 bg-success" data-toggle="collapse" data-target="#mfee">
                  <i class="fas fa-money-check-alt fa-2x"></i>
                  <span class="d-none d-sm-block">Monthly Fee</span>
                </div>
                <div class="port-item p-4 bg-warning" data-toggle="collapse" data-target="#docs">
                  <i class="fas fa-folder-open fa-2x d-block"></i>
                  <span class="d-none d-sm-block">Docs</span>
                </div>
                <div class="port-item p-4 bg-danger" data-toggle="collapse" data-target="#contact">
                  <i class="fas fa-envelope fa-2x d-block"></i>
                  <span class="d-none d-sm-block">Contact</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </header>

    <!-- bio -->
    <div id="bio" class="collapse">
      <div class="card card-body bg-info text-white py-5">
        <h2>Bio</h2>
      </div>

      <div class="card card-body py-5">
        <div class="card-columns">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">About</h5>
              <p class="p-1 mb-2 bg-dark text-white">
              Birthday: <?php echo $rowR[3]; ?>
              </p>
              <p class="p-1 mb-2 bg-dark text-white">
                Birth Place : <?php echo ucfirst($rowR[4]); ?>
              </p>
              <p class="p-1 mb-2 bg-dark text-white">
                Father Name : <?php echo ucfirst($rowR[5]); ?>
              </p>
              <p class="p-1 mb-2 bg-dark text-white">
                Mother Name : <?php echo ucfirst($rowR[6]); ?>
              </p>
              <p class="p-1 mb-2 bg-dark text-white">
                Age : <?php echo $rowR[8]; ?>
              </p>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
             <h5 class="card-title">Religion & Caste</h5>
              <p class="p-1 mb-2 bg-dark text-white">
                Religion : <?php echo ucfirst($rowR[9]) ; ?>
              </p>
              <p class="p-1 mb-2 bg-dark text-white">
                Caste : <?php echo ucfirst($rowR[10]) ; ?>
              </p>
              <p class="p-1 mb-2 bg-dark text-white">
                Income Group : <?php echo ucfirst($rowR[23]) ; ?>
              </p>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">I-Card Number & Aadhar Number</h5>
                <p class="p-1 mb-1 bg-dark text-white">
                  Identity Number : <?php echo ucfirst($rowR[27]) ; ?>
                </p>
                <p class="p-1 mb-1 bg-dark text-white">
                  Aadhar Number : <?php echo ucfirst($rowR[28]) ; ?>
                </p>
            </div>
          </div>
          <div class="card bg-info text-white text-center">
            <h5 class="card-title text-dark font-weight-bolder pt-1">Address</h5>
              <blockquote class="blockquote mb-0">
              <p class="text-dark font-weight-bold font-italic">
                <?php echo ucfirst($rowR[11]) ; ?>
              
              </p>
              </blockquote>
          </div>
          <div class="card">
            <div class="card-body">
              <h5 class="card-title"></h5>
                <p class="p-1 mb-1 bg-dark text-white">
                  State : <?php echo ucfirst($rowR[12]) ; ?>
                </p>
                <p class="p-1 mb-1 bg-dark text-white">
                  District : <?php echo ucfirst($rowR[13]) ; ?>
                </p>
                <p class="p-1 mb-1 bg-dark text-white">
                  Zip : <?php echo ucfirst($rowR[14]) ; ?>
                </p>
            </div>
          </div>
          <div class="card">
            <div class="card-body bg-secondary">
              <h5 class="text-center text-white">Class Attended</h5>
                <p class="text-center text-white">
                  <?php echo ucfirst($rowR[15]) ; ?>
                </p>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Misc.</h5>
                <p class="p-1 mb-1 bg-dark text-white">
                  Disability Type : <?php echo ucfirst($rowR[16]) ; ?>
                </p>
                <p class="p-1 mb-1 bg-dark text-white">
                  Respite : <?php echo ucfirst($rowR[21]) ; ?>
                </p>
                <p class="p-1 mb-1 bg-dark text-white">
                  Transpotation : <?php echo ucfirst($rowR[22]) ; ?>
                </p>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Bank Details</h5>
                <p class="p-1 mb-1 bg-dark text-white">
                  A/c Number : <?php echo ucfirst($rowR[24]) ; ?>
                </p>
                <p class="p-1 mb-1 bg-dark text-white">
                  IFSC : <?php echo ucfirst($rowR[25]) ; ?>
                </p>
                <p class="p-1 mb-1 bg-dark text-white">
                  Branch : <?php echo ucfirst($rowR[26]) ; ?>
                </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php

      $query = "SELECT mFee_Id, feeType, totalFeeAmt FROM monthlyFee";

      $output = mysqli_query($conn, $query)
        or die("Error in fetching records");

        $fetchFeetypes = mysqli_fetch_all($output, MYSQLI_ASSOC);

        $fee_Id = array();
        $feeType = array();
        $fee = array();

        foreach ($fetchFeetypes as $fetchFeetype) {
          array_push($fee_Id, $fetchFeetype['mFee_Id']);
          array_push($feeType, $fetchFeetype['feeType']);
          array_push($fee, $fetchFeetype['totalFeeAmt']);
        }
        //print_r($fee_Id);
      
        if ($output === false) {

        exit("Couldn't execute the query." . mysqli_error($conn));

        }    
    ?>
    <!-- Fee -->
      <div id="mfee" class="collapse">
        <div class="card card-body bg-success text-white py-5">
          <h2>Monthly Fee</h2>
        </div>
        <div class="card card-body py-5" id="outer-Card">
          <div class="row">
            <div class="col-md-6 offset-md-3">
              <div class="card card-body  shadow-lg p-4 rounded" id="inner-Card">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                  <div class="form-group">
                    <div class="row">
                      <div class="col">
                        <span id="label">Fee Type</span>               
                          <select class="custom-select shadow rounded">
                            <option selected>Select a fee type</option>
                            <option value="<?php echo ucwords($fee_Id[0]); ?>"><?php echo ucwords($feeType[0]); ?></option>
                          </select>
                      </div>  
                      <div class="col">  
                      <span id="label">Total School Fee</span>            
                        <input type="number" class="form-control shadow rounded" id="sFee" name="sFee" value="" placeholder="Total School Fee" disabled>
                      </div>
                    </div>
                    <div class="mt-3">         
                      <input type="number" class="form-control text-center shadow rounded" id="sFee" name="sFee" placeholder="Payable Amount">
                    </div>       
                  </div>            
                  <div class="form-group">
                    <div class="row">
                      <div class="col">
                        <span id="label">Fee Type</span>               
                          <select class="custom-select shadow rounded">
                            <option selected>Select a fee type</option>
                            <option value="<?php echo ucwords($fee_Id[1]); ?>"><?php echo ucwords($feeType[1]); ?></option>
                          </select>
                      </div>  
                      <div class="col">  
                      <span id="label">Total Respite Fee</span>            
                        <input type="number" class="form-control shadow rounded" id="sFee" name="sFee" value="" placeholder="Total Respite Fee" disabled>
                      </div>
                    </div>
                    <div class="mt-3">         
                      <input type="number" class="form-control text-center shadow rounded" id="sFee" name="sFee" placeholder="Payable Amount">
                    </div>       
                  </div>            
                  <div class="form-group">
                    <div class="row">
                      <div class="col">
                        <span id="label">Fee Type</span>               
                          <select class="custom-select shadow rounded">
                            <option selected>Select a fee type</option>
                            <option value="<?php echo ucwords($fee_Id[2]); ?>"><?php echo ucwords($feeType[2]); ?></option>
                          </select>
                      </div>  
                      <div class="col">  
                      <span id="label">Total Therapeutic Service Fee</span>            
                        <input type="number" class="form-control shadow rounded" id="sFee" name="sFee" value="" placeholder="Total Therapeutic Service Fee" disabled>
                      </div>
                    </div>
                    <div class="mt-3">         
                      <input type="number" class="form-control text-center shadow rounded" id="sFee" name="sFee" placeholder="Payable Amount">
                    </div>       
                  </div>            
                  <div class="form-group">
                    <div class="row">
                      <div class="col">
                        <span id="label">Fee Type</span>               
                          <select class="custom-select shadow rounded">
                            <option selected>Select a fee type</option>
                            <option value="<?php echo ucwords($fee_Id[3]); ?>"><?php echo ucwords($feeType[3]); ?></option>
                          </select>
                      </div>  
                      <div class="col">  
                      <span id="label">Total Conveyance Service fee</span>            
                        <input type="number" class="form-control shadow rounded" id="sFee" name="sFee" value="" placeholder="Total Conveyance Service fee" disabled>
                      </div>
                    </div>
                    <div class="mt-3">         
                      <input type="number" class="form-control text-center shadow rounded" id="sFee" name="sFee" placeholder="Payable Amount">
                    </div>       
                  </div>            
                  <div class="form-group" id="date">  
                    <span class="font-weight-bold text-monospace mb-2 mt-4" >Payable Date</span>
                    <input type="date" class="form-control shadow rounded" id="feeDate" name="feeDate">
                  </div>
                  <div class="row mt-4">
                    <div class="col-md-6 offset-md-3">
                      <input type="submit" class="btn btn-outline-dark btn-block shadow p-2 mb-3 bg-white" value="Submit">  
                    </div>
                  </div>        
                </form>
              </div>
            </div>
          </div>    
        </div>    
      </div>

    <!-- docs -->
    <div id="docs" class="collapse">
      <div class="card card-body bg-warning text-white py-5">
        <h2>Docs</h2>
      </div>
      
      <div class="card card-body py-5">
        <h3></h3>
        <div class="row no-gutters">
          <div class="col-md-3">
            <a href="<?php echo $row[2]; ?>" data-toggle="lightbox">
            <img src="<?php echo $row[2]; ?>" alt="" width="267" height="260">
            </a>
          </div>

          <?php 
            $dpath=$row[3];
            $dpathExt=explode('.', $dpath);
            $dpathActExt= strtolower(end($dpathExt));
          ?>

          <div class="col-md-3">
            <?php if($dpathActExt == 'pdf'): ?>
              <a href="<?php echo $row[3]; ?>">
                <img src="img/pdficon.png" width="267" height="260" alt="<?php pathinfo($row[3], PATHINFO_FILENAME); ?>">
              </a>
            <?php elseif($dpathActExt == 'docx') : ?>
              <a href="<?php echo $row[3]; ?>">
                <img src="img/Word-icon.png" width="267" height="260" alt="<?php pathinfo($row[3], PATHINFO_FILENAME); ?>">
              </a>
            <?php else: ?>
              <a href="<?php echo $row[3]; ?>" data-toggle="lightbox">
                <img src="<?php echo $row[3]; ?>" alt="" width="267" height="260">
              </a>
            <?php endif; ?>
          </div>

          <?php 
            $dpath=$row[4];
            $dpathExt=explode('.', $dpath);
            $dpathActExt= strtolower(end($dpathExt));
          ?>
          
          <div class="col-md-3">
            <?php if($dpathActExt == 'pdf'): ?>
              <a href="<?php echo $row[4]; ?>" data-toggle="lightbox">
                <img src="img/pdficon.png" width="267" height="260" alt="<?php pathinfo($row[4], PATHINFO_FILENAME); ?>">
              </a>
            <?php elseif($dpathActExt == 'docx') : ?>
              <a href="<?php echo $row[4]; ?>" data-toggle="lightbox">
                <img src="img/Word-icon.png" width="267" height="260" alt="<?php pathinfo($row[4], PATHINFO_FILENAME); ?>">
              </a>
            <?php else: ?>
              <a href="<?php echo $row[4]; ?>" data-toggle="lightbox">
                <img src="<?php echo $row[4]; ?>" alt="" width="267" height="260">
              </a>
            <?php endif; ?>
          </div>

          <?php 
            $dpath=$row[5];
            $dpathExt=explode('.', $dpath);
            $dpathActExt= strtolower(end($dpathExt));
          ?>

          <div class="col-md-3">
            <?php if($dpathActExt == 'pdf'): ?>
              <a href="<?php echo $row[5]; ?>">
                <img src="img/pdficon.png" width="267" height="260" alt="<?php pathinfo($row[5], PATHINFO_FILENAME); ?>">
              </a>
            <?php elseif($dpathActExt == 'docx') : ?>
              <a href="<?php echo $row[5]; ?>">
                <img src="img/Word-icon.png" width="267" height="260" alt="<?php pathinfo($row[5], PATHINFO_FILENAME); ?>">
              </a>
            <?php else: ?>
              <a href="<?php echo $row[5]; ?>" data-toggle="lightbox">
                <img src="<?php echo $row[5]; ?>" alt="" width="267" height="260">
              </a>
            <?php endif; ?>
          </div>
        </div>  

        <div class="row no-gutters">

          <?php 
            $dpath=$row[6];
            $dpathExt=explode('.', $dpath);
            $dpathActExt= strtolower(end($dpathExt));
          ?>

          <div class="col-md-3">
            <?php if($dpathActExt == 'pdf'): ?>
              <a href="<?php echo $row[6]; ?>">
                <img src="img/pdficon.png" width="267" height="260" alt="<?php pathinfo($row[6], PATHINFO_FILENAME); ?>">
              </a>
            <?php elseif($dpathActExt == 'docx') : ?>
              <a href="<?php echo $row[6]; ?>">
                <img src="img/Word-icon.png" width="267" height="260" alt="<?php pathinfo($row[6], PATHINFO_FILENAME); ?>">
              </a>
            <?php else: ?>
              <a href="<?php echo $row[6]; ?>" data-toggle="lightbox">
                <img src="<?php echo $row[6]; ?>" alt="" width="267" height="260">
              </a>
            <?php endif; ?>
          </div>

          <?php 
            $dpath=$row[7];
            $dpathExt=explode('.', $dpath);
            $dpathActExt= strtolower(end($dpathExt));
          ?>

          <div class="col-md-3">
            <?php if($dpathActExt == 'pdf'): ?>
              <a href="<?php echo $row[7]; ?>">
                <img src="img/pdficon.png" width="267" height="260" alt="<?php pathinfo($row[7], PATHINFO_FILENAME); ?>">
              </a>
            <?php elseif($dpathActExt == 'docx') : ?>
              <a href="<?php echo $row[7]; ?>">
                <img src="img/Word-icon.png" width="267" height="260" alt="<?php pathinfo($row[7], PATHINFO_FILENAME); ?>">
              </a>
            <?php else: ?>
              <a href="<?php echo $row[7]; ?>" data-toggle="lightbox">
                <img src="<?php echo $row[7]; ?>" alt="" width="267" height="260">
              </a>
            <?php endif; ?>
          </div>

          <div class="col-md-3">
            <!-- <a href="https://unsplash.it/1200/768.jpg?image=258" data-toggle="lightbox">
              <img src="https://unsplash.it/600.jpg?image=258" alt="" class="img-fluid">
            </a> -->
          </div>
          <div class="col-md-3">
            <!-- <a href="https://unsplash.it/1200/768.jpg?image=259" data-toggle="lightbox">
              <img src="https://unsplash.it/600.jpg?image=259" alt="" class="img-fluid">
            </a> -->
          </div>
        </div>
      </div>
    </div>

    <!-- CONTACT -->
    <div id="contact" class="collapse">
      <div class="card card-body bg-danger text-white py-5">
        <h2>Contact</h2>
        <p class="lead"></p>
      </div>

      <div class="card card-body py-5">
        <h3>Get In Touch</h3>

        <form>
          <div class="form-group">
            <div class="input-group input-group-lg">
              <div class="input-group-prepend">
                <span class="input-group-text bg-danger text-white">
                  <i class="fas fa-user"></i>
                </span>
              </div>
              <input type="text" class="form-control bg-dark text-white" placeholder="Name">
            </div>
          </div>

          <div class="form-group">
            <div class="input-group input-group-lg">
              <div class="input-group-prepend">
                <span class="input-group-text bg-danger text-white">
                  <i class="fas fa-envelope"></i>
                </span>
              </div>
              <input type="email" class="form-control bg-dark text-white" placeholder="Email">
            </div>
          </div>

          <div class="form-group">
            <div class="input-group input-group-lg">
              <div class="input-group-prepend">
                <span class="input-group-text bg-danger text-white">
                  <i class="fas fa-pencil-alt"></i>
                </span>
              </div>
              <textarea class="form-control bg-dark text-white" placeholder="Name"></textarea>
            </div>
          </div>

          <input type="submit" value="Submit" class="btn btn-danger btn-block btn-lg">
        </form>
      </div>
    </div>


    <!-- FOOTER -->
    <footer id="main-footer" class="p-5 bg-dark text-white">
      <div class="row">
        <div class="col-md-6">
          <a href="#" class="btn btn-outline-light">
            <i class="fas fa-cloud"></i> Download
          </a>
            <a href="studentsView.php" class="btn btn-outline-light">
            <i class="fas fa-angle-double-left"></i> Back </a>
        </div>
      </div>
    </footer>
  </div>


   <!-- bootstrap script -->
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