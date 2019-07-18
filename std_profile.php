<?php
 session_start();
 require_once "includes/connect.php";

 if(!isset($_SESSION['username'])){
  header("Location: preronaHome.php");
}

 require_once "MyUtil.php";
 $sid = $_GET['s_id'];

 if(isset($_GET['s_id'])){
    //$sid = $_GET['s_id'];
    
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


  //fetching students_info
  $sql = "SELECT hostel, transpotation FROM students_Info WHERE std_Id = $sid";

    $rslts = mysqli_query($conn, $sql) or die("Error in fetching records");

    $rqdRows = mysqli_fetch_all($rslts);


    if ($rslts === false) {

    exit("Couldn't execute the query." . mysqli_error($conn));

    }       

  //fetching therapy data
  $sql = "SELECT std_Id FROM therapyRecipient WHERE std_Id = $sid";

  $rslt = mysqli_query($conn, $sql) or die("Error in fetching records");

  //$rowCountTh = mysqli_fetch_all($rslts);

  //print_r($rowCountTh);


  if ($rslt === false) {

  exit("Couldn't execute the query." . mysqli_error($conn));

  }   
 }

 if(isset($_POST["send"])){
  $sender = $_POST["sender"];
  $number = $_POST["number"];
  $msg = $_POST["message"];

  if(!empty($sender) && !empty($number) && !empty($msg)){
    // send SMS
  $smsResponse = MyUtil::sendSMS("Hello, $sender\nHere: $msg", $number);
  header("Location: studentsView.php?smsSend");
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

<!-- hiding hostel, transpotation & therapy input tag -->
<?php foreach ($rqdRows as $rRow):  ?>
<?php if ($rRow[0] == 'No'):  ?>
<style>
  #mfee #hostel{ display : none; }
</style>
<?php endif; ?>
<?php endforeach;  ?>

<?php foreach ($rqdRows as $rRow):  ?>
<?php if ($rRow[1] == ''):  ?>
<style>
  #mfee #transport{display : none;}
</style>
<?php endif; ?>
<?php endforeach;  ?>

<?php if (mysqli_num_rows($rslt) == 0):  ?>
<style>
  #mfee #therapy{display : none;}
</style>
<?php endif; ?>

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
                <h1 class="display-5"><?php echo ucfirst($rowR[2])." :"; ?>
                </h1>
                
                <div>
                  <small class="font-italic h3 ml-2"><?php echo ucfirst($rowR[7]); ?></small>
                </div>
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
                <div class="port-item p-4 bg-primary" data-toggle="collapse" data-target="#contact">
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
        <h2>About</h2>
      </div>

      <div class="card card-body py-5">
        <div class="text-right">
        <a href="updateStd.php?s_id=<?php echo $sid; ?>" class="btn btn-dark mb-2"><i class="fas fa-user-edit text-white pr-1"></i>Edit</a>
        </div>
        <div class="card-columns">
          <div class="card">
            <div class="card-body">
              <p class="p-1 mb-2 bg-dark text-white">
              Birthday: <?php echo $rowR[3]; ?>
              </p>
              <p class="p-1 mb-2 bg-dark text-white">
                Birth Place : <?php echo ucwords($rowR[4]); ?>
              </p>
              <p class="p-1 mb-2 bg-dark text-white">
                Father Name : <?php echo ucwords($rowR[5]); ?>
              </p>
              <p class="p-1 mb-2 bg-dark text-white">
                Mother Name : <?php echo ucwords($rowR[6]); ?>
              </p>
              <p class="p-1 mb-2 bg-dark text-white">
                Age : <?php echo $rowR[8]; ?>
              </p>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
              <p class="p-1 mb-2 bg-dark text-white">
                Religion : <?php echo ucwords($rowR[9]) ; ?>
              </p>
              <p class="p-1 mb-2 bg-dark text-white">
                Caste : <?php echo ucwords($rowR[10]) ; ?>
              </p>
              <p class="p-1 mb-2 bg-dark text-white">
                Income Group : <?php echo ucwords($rowR[24]) ; ?>
              </p>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
                <p class="p-1 mb-1 bg-dark text-white">
                  Identity Number : <?php echo ucwords($rowR[27]) ; ?>
                </p>
                <p class="p-1 mb-1 bg-dark text-white">
                  Aadhar Number : <?php echo $rowR[28] ; ?>
                </p>
            </div>
          </div>
          <div class="card bg-info text-white text-center">
            <h5 class="card-title text-dark font-weight-bolder pt-1">Address</h5>
              <blockquote class="blockquote mb-0">
              <p class="text-dark font-weight-bold font-italic">
                <?php echo ucwords($rowR[11]); ?>
              
              </p>
              </blockquote>
          </div>
          <div class="card mb-3">
            <div class="card-body">
                <p class="p-1 mb-1 bg-dark text-white">
                  State : <?php echo ucwords($rowR[12]) ; ?>
                </p>
                <p class="p-1 mb-1 bg-dark text-white">
                  District : <?php echo ucwords($rowR[13]) ; ?>
                </p>
                <p class="p-1 mb-1 bg-dark text-white">
                  Zip : <?php echo $rowR[14] ; ?>
                </p>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
                <p class="p-1 mb-1 bg-dark text-white">
                 Class: <?php echo ucwords($rowR[16]) ; ?>
                </p>
                <p class="bg-dark p-1 mb-1 text-white">
                 Phone: <?php echo $rowR[15] ; ?>
                </p>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
                <p class="p-1 mb-1 bg-dark text-white">
                  Disability Type : <?php echo ucwords($rowR[17]) ; ?>
                </p>
                <p class="p-1 mb-1 bg-dark text-white">
                  Respite: <?php echo ucwords($rowR[22]) ; ?>
                </p>
                <p class="p-1 mb-1 bg-dark text-white">
                  Transpotation : <?php echo ucwords($rowR[23]) ; ?>
                </p>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Bank Details</h5>
                <p class="p-1 mb-1 bg-dark text-white">
                  A/c Number : <?php echo $rowR[25] ; ?>
                </p>
                <p class="p-1 mb-1 bg-dark text-white">
                  IFSC : <?php echo $rowR[26] ; ?>
                </p>
                <p class="p-1 mb-1 bg-dark text-white">
                  Branch : <?php echo ucwords($rowR[27]) ; ?>
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
    <?php 
      $_SESSION['stdId_pro'] = $sid;
    ?>


    <!-- Fee -->
      <div id="mfee" class="collapse">
        <div class="card card-body bg-success text-white py-5">
          <div class="card-header bg-success"> 
            <button class="btn btn-outline-light" type="button" data-toggle="collapse" data-target="#rFee" aria-expanded="false" aria-controls="ssTab">
              Record Monthly Fee
            </button>
            <a href="veiwFee.php?s_id=<?php echo $sid; ?>" class="btn btn-outline-light" >
              View Monthly Fee
            </a>
          </div>  
        </div>
        <!-- recordfee collapse -->
        <div class="collapse" id="rFee">
          <div class="card card-body py-5" id="outer-Card">
            <div class="row">
              <div class="col-md-6 offset-md-3">
                <div class="card card-body  shadow-lg py-5 rounded" id="inner-Card">
                <h5 class="card-title text-center">Monthly Fee</h5>
                  <form action="monthFee.php" method="post">
                    <div class="form-group"> 
                      <div class="row"> 
                        <div class="col">
                          <span class="label">Payment Date</span>
                          <input type="date" class="form-control shadow rounded" id="feeDate" name="feeDate">
                        </div>
                        <div class="col">
                          <span class="label">For The Month</span>
                          <input type="text" class="form-control shadow rounded" id="feeMon" name="feeMon" readonly>
                        </div>
                        <div class="col">
                          <span class="label">For The Year</span>
                          <input type="text" class="form-control shadow rounded" id="feeYear" name="feeYear" readonly>
                        </div>
                      </div>  
                    </div>
                    <div class="form-group py-2">
                      <div class="row">
                        <div class="col">
                          <span class="label">Fee Type</span>               
                            <select class="custom-select shadow rounded" id="sFeeId" name="sFeeId" onchange="loadFee(this.id)">
                              <option selected>Select a fee type</option>
                              <option value="<?php echo ucwords($fee_Id[0]); ?>"><?php echo ucwords($feeType[0]); ?></option>
                            </select>
                        </div>  
                        <div class="col">  
                        <span class="label" id="lblSch"></span>          
                          <input type="number" class="form-control shadow rounded" id="sFee" disabled>
                        </div>
                      </div>
                      <div class="mt-3">         
                        <input type="number" class="form-control  text-center shadow rounded" id="pSFee" name="pSFee" placeholder="Payable Amount">
                      </div>       
                    </div>            
                    <div class="form-group py-2" id="hostel">
                      <div class="row">
                        <div class="col">
                          <span class="label">Fee Type</span>               
                            <select class="custom-select shadow rounded" onchange="loadFee(this.id)" id="hstFeeId" name="hstFeeId">
                              <option selected>Select a fee type</option>
                              <option value="<?php echo ucwords($fee_Id[1]); ?>"><?php echo ucwords($feeType[1]); ?></option>
                            </select>
                        </div>  
                        <div class="col">  
                        <span class="label" id="lblHst"></span>            
                          <input type="number" class="form-control shadow rounded" id="hstFee" disabled>
                        </div>
                      </div>
                      <div class="mt-3">         
                        <input type="number" class="form-control text-center shadow rounded" id="pHstFee" name="pHstFee" placeholder="Payable Amount">
                      </div>       
                    </div>            
                    <div class="form-group py-2" id="therapy">
                      <div class="row">
                        <div class="col">
                          <span class="label">Fee Type</span>               
                            <select class="custom-select shadow rounded" onchange="loadFee(this.id)" id="thyFeeId" name="thyFeeId">
                              <option selected>Select a fee type</option>
                              <option value="<?php echo ucwords($fee_Id[2]); ?>"><?php echo ucwords($feeType[2]); ?></option>
                            </select>
                        </div>  
                        <div class="col">  
                        <span class="label" id="lblThy"></span>            
                          <input type="number" class="form-control shadow rounded" id="thyFee" disabled>
                        </div>
                      </div>
                      <div class="mt-3">         
                        <input type="number" class="form-control text-center shadow rounded" id="pThyFee" name="pThyFee" placeholder="Payable Amount">
                      </div>       
                    </div>            
                    <div class="form-group py-2" id="transport">
                      <div class="row">
                        <div class="col">
                          <span class="label">Fee Type</span>               
                            <select class="custom-select shadow rounded" onchange="loadFee(this.id)" id="conveyFeeId" name="conveyFeeId">
                              <option selected>Select a fee type</option>
                              <option value="<?php echo ucwords($fee_Id[3]); ?>"><?php echo ucwords($feeType[3]); ?></option>
                            </select>
                        </div>  
                        <div class="col">  
                        <span class="label" id="lblCon"></span>            
                          <input type="number" class="form-control shadow rounded" id="conFee" disabled>
                        </div>
                      </div>
                      <div class="mt-3">         
                        <input type="number" class="form-control text-center shadow rounded" id="pConFee" name="pConFee" placeholder="Payable Amount">
                      </div>       
                    </div>            
                    
                    <div class="row mt-4 py-1">
                      <div class="col-md-6 offset-md-3">
                        <input type="submit" id="sb" class="btn btn-outline-dark btn-block shadow p-2 mb-3 bg-white" value="Submit" name="submit">  
                      </div>
                    </div>        
                  </form>
                </div>
              </div>
            </div>    
          </div> 
        </div>
      </div> 
    </div> 



    <!-- docs -->
    <div class="container">
      <div id="docs" class="collapse">
        <div class="card card-body bg-warning text-white py-5">
          <h2>Docs</h2>
        </div>
        
        <div class="card card-body py-5">
          <div class="row">
            <div class="col-md-3">
              <p class="text-center text-info">Photo</p>
              <a href="<?php echo $row[2]; ?>" data-toggle="lightbox">
              <img src="<?php echo $row[2]; ?>" alt="no doc to show" class="mb-1" width="250" height="190">
              </a>
              <a href="download.php?file=<?php echo urlencode($row[2]); ?>" class="btn btn-secondary btn-sm btn-block mx-2">Download</a>
            </div>

            <?php 
              $dpath=$row[3];
              $dpathExt=explode('.', $dpath);
              $dpathActExt= strtolower(end($dpathExt));
            ?>

            <div class="col-md-3">
              <p class="text-center text-info">Birth Certificate</p>
              <?php if($dpathActExt == 'pdf'): ?>
                <a href="<?php echo $row[3]; ?>">
                  <img src="img/pdficon.png" width="250" height="190" alt="<?php pathinfo($row[3], PATHINFO_FILENAME); ?>">
                </a>

              <?php else: ?>
                <a href="<?php echo $row[3]; ?>" data-toggle="lightbox">
                  <img src="<?php echo $row[3]; ?>" alt="no doc to show" width="250" height="190">
                </a>
              <?php endif; ?>
              <a href="download.php?file=<?php echo urlencode($row[3]); ?>" class="btn btn-secondary btn-sm btn-block mx-2">Download</a>
            </div>

            <?php 
              $dpath=$row[4];
              $dpathExt=explode('.', $dpath);
              $dpathActExt= strtolower(end($dpathExt));
            ?>
            
            <div class="col-md-3">
              <p class="text-center text-info">Caste Certificate</p>
              <?php if($dpathActExt == 'pdf'): ?>
                <a href="<?php echo $row[4]; ?>" data-toggle="lightbox">
                  <img src="img/pdficon.png" width="250" height="190" alt="<?php pathinfo($row[4], PATHINFO_FILENAME); ?>">
                </a>
              <?php else: ?>
                <a href="<?php echo $row[4]; ?>" data-toggle="lightbox">
                  <img src="<?php echo $row[4]; ?>" alt="no doc to show" width="250" height="190">
                </a>
              <?php endif; ?>
              <a href="download.php?file=<?php echo urlencode($row[4]); ?>" class="btn btn-secondary btn-sm btn-block mx-2">Download</a>
            </div>

            <?php 
              $dpath=$row[5];
              $dpathExt=explode('.', $dpath);
              $dpathActExt= strtolower(end($dpathExt));
            ?>

            <div class="col-md-3">
              <p class="text-center text-info">Disability Certificate</p>
              <?php if($dpathActExt == 'pdf'): ?>
                <a href="<?php echo $row[5]; ?>">
                  <img src="img/pdficon.png" width="250" height="190" alt="<?php pathinfo($row[5], PATHINFO_FILENAME); ?>">
                </a>
              <?php else: ?>
                <a href="<?php echo $row[5]; ?>" data-toggle="lightbox">
                  <img src="<?php echo $row[5]; ?>" alt="no doc to show" width="250" height="190">
                </a>
              <?php endif; ?>
              <a href="download.php?file=<?php echo urlencode($row[5]); ?>" class="btn btn-secondary btn-sm btn-block mx-2">Download</a>
            </div>
          </div>  

          <div class="row mt-3">

            <?php 
              $dpath=$row[6];
              $dpathExt=explode('.', $dpath);
              $dpathActExt= strtolower(end($dpathExt));
            ?>

            <div class="col-md-3">
            <p class="text-center text-info">Income Certificate</p>
              <?php if($dpathActExt == 'pdf'): ?>
                <a href="<?php echo $row[6]; ?>">
                  <img src="img/pdficon.png" width="250" height="190" alt="<?php pathinfo($row[6], PATHINFO_FILENAME); ?>">
                </a>
              <?php else: ?>
                <a href="<?php echo $row[6]; ?>" data-toggle="lightbox">
                  <img src="<?php echo $row[6]; ?>" alt="no doc to show" width="250" height="190">
                </a>
              <?php endif; ?>
              <a href="download.php?file=<?php echo urlencode($row[6]); ?>" class="btn btn-secondary btn-sm btn-block mx-2">Download</a>
            </div>

            <?php 
              $dpath=$row[7];
              $dpathExt=explode('.', $dpath);
              $dpathActExt= strtolower(end($dpathExt));
            ?>

            <div class="col-md-3">
              <p class="text-center text-info">Guardianship Certificate</p>
              <?php if($dpathActExt == 'pdf'): ?>
                <a href="<?php echo $row[7]; ?>">
                  <img src="img/pdficon.png" width="250" height="190" alt="<?php pathinfo($row[7], PATHINFO_FILENAME); ?>">
                </a>
              <?php else: ?>
                <a href="<?php echo $row[7]; ?>" data-toggle="lightbox">
                  <img src="<?php echo $row[7]; ?>" alt="no doc to show" width="250" height="190">
                </a>
              <?php endif; ?>
              <a href="download.php?file=<?php echo urlencode($row[7]); ?>" class="btn btn-secondary btn-sm btn-block mx-2">Download</a>
            </div>

            <?php 
              $dpath=$row[8];
              $dpathExt=explode('.', $dpath);
              $dpathActExt= strtolower(end($dpathExt));
            ?>

            <div class="col-md-3">
            <p class="text-center text-info">Niramaya Health Card</p>
            <?php if($dpathActExt == 'pdf'): ?>
                <a href="<?php echo $row[8]; ?>">
                  <img src="img/pdficon.png" width="250" height="190" alt="<?php pathinfo($row[8], PATHINFO_FILENAME); ?>">
                </a>
              <?php else: ?>
                <a href="<?php echo $row[8]; ?>" data-toggle="lightbox">
                  <img src="<?php echo $row[8]; ?>" alt="no doc to show" width="250" height="150">
                </a>
              <?php endif; ?>
              <a href="download.php?file=<?php echo urlencode($row[8]); ?>" class="btn btn-secondary btn-sm btn-block mx-2">Download</a>
            </div>
            <div class="col-md-3">
              
            </div>
          </div>
        </div>
      </div>
    </div>  

    <!-- CONTACT -->
    <div class="container">
      <div id="contact" class="collapse">
        <div class="card card-body bg-primary text-white py-5">
          <h2>Contact</h2>
          <p class="lead"></p>
        </div>

        <div class="card card-body py-5">
          <form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
            <div class="form-group">
              <div class="input-group input-group-lg">
                <div class="input-group-prepend">
                  <span class="input-group-text bg-primary text-white">
                    <i class="fas fa-user"></i>
                  </span>
                </div>
                <input type="text" class="form-control bg-light  text-dark" name="sender" placeholder="Sender Name">
              </div>
            </div>

            <div class="form-group">
              <div class="input-group input-group-lg">
                <div class="input-group-prepend">
                  <span class="input-group-text bg-primary text-white">
                    <i class="fas fa-envelope"></i>
                  </span>
                </div>
                <input type="number" class="form-control bg-light text-dark" name="number" placeholder="Phone Number">
              </div>
            </div>

            <div class="form-group">
              <div class="input-group input-group-lg">
                <div class="input-group-prepend">
                  <span class="input-group-text bg-primary text-white">
                    <i class="fas fa-pencil-alt"></i>
                  </span>
                </div>
                <textarea class="form-control bg-light text-dark" name="message" placeholder="Write..."></textarea>
              </div>
            </div>

            <input type="submit" value="Send" name="send" class="btn btn-primary btn-block btn-lg">
          </form>
        </div>
      </div>
    </div>  


    <!-- FOOTER -->
    <div class="container">
      <footer id="main-footer" class="p-5 bg-dark text-white">
        <div class="row">
          <div class="col-md-6">
              <a href="studentsView.php" class="btn btn-outline-light">
              <i class="fas fa-angle-double-left"></i> Back </a>
          </div>
        </div>
      </footer>
    </div>
  </div>


   <!-- bootstrap script -->
  <script src="scripts/monFee.js"></script> 
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