<?php
 session_start();
 require_once "includes/connect.php";
 
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
            <?php echo $fRow[0]; ?>
            </div>

            <div>
              <div class="d-flex flex-row text-white align-items-stretch text-center">
                <div class="port-item p-4 bg-primary" data-toggle="collapse" data-target="#bio">
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
      <div class="card card-body bg-primary text-white py-5">
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
          <div class="card bg-primary text-white text-center">
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
                  Respite : <?php echo ucfirst($rowR[20]) ; ?>
                </p>
                <p class="p-1 mb-1 bg-dark text-white">
                  Transpotation : <?php echo ucfirst($rowR[21]) ; ?>
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

    <!-- Fee -->
    <div id="mfee" class="collapse">
      <div class="card card-body bg-success text-white py-5">
        <h2>Bank Details</h2>
        <p class="lead">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nihil, ut!</p>
      </div>

      <div class="card card-body py-5">
        <div class="card-deck">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">123 Designs</h4>
              <p class="p-2 mb-3 bg-dark text-white">
                A/c No.
              </p>
              <p class="p-2 mb-3 bg-dark text-white">
                IFSC
              </p>
            </div>
            <div class="card-footer">
              <h6 class="text-muted">Branch: </h6>
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
          <div class="col-md-3">
            <a href="<?php echo $row[3]; ?>">
            <img src="img/pdficon.png" width="267" height="220" alt="<?php pathinfo($row[3], PATHINFO_FILENAME); ?>">
            </a>
            <button type="button" class="btn btn-outline-dark btn-sm btn-block">Download</button>
          </div>
          
          <div class="col-md-3">
            <a href="<?php echo $row[2]; ?>" data-toggle="lightbox">
            <img src="<?php echo $row[2]; ?>" alt="" width="267" height="260">
            </a>
          </div>

          <div class="col-md-3">
            <a href="<?php echo $row[2]; ?>" data-toggle="lightbox">
            <img src="<?php echo $row[2]; ?>" alt="" width="267" height="260">
            </a>
          </div>
        </div>

        <div class="row no-gutters">
          <div class="col-md-3">
            <a href="https://unsplash.it/1200/768.jpg?image=256" data-toggle="lightbox">
              <img src="https://unsplash.it/600.jpg?image=256" alt="" class="img-fluid">
            </a>
          </div>
          <div class="col-md-3">
            <a href="https://unsplash.it/1200/768.jpg?image=257" data-toggle="lightbox">
              <img src="https://unsplash.it/600.jpg?image=257" alt="" class="img-fluid">
            </a>
          </div>
          <div class="col-md-3">
            <a href="https://unsplash.it/1200/768.jpg?image=258" data-toggle="lightbox">
              <img src="https://unsplash.it/600.jpg?image=258" alt="" class="img-fluid">
            </a>
          </div>
          <div class="col-md-3">
            <a href="https://unsplash.it/1200/768.jpg?image=259" data-toggle="lightbox">
              <img src="https://unsplash.it/600.jpg?image=259" alt="" class="img-fluid">
            </a>
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