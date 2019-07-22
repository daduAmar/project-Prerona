<?php
 session_start();
 require_once "includes/connect.php";

 if(!isset($_SESSION['username'])){
  header("Location: preronaHome.php");
}


 if(isset($_GET['ddrc_id'])){

  $id = $_GET['ddrc_id'];
  
  //ddrc data retrieve
  $sql="SELECT * FROM DDRC WHERE ddrc_Id= $id";

  $result = mysqli_query($conn, $sql)
  or die("Error in fetching records");

  $DDRCrows = mysqli_fetch_all($result, MYSQLI_ASSOC);

  ///print_r($DDRCrows);
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
  <link rel="stylesheet" href="CSS/bootstrap.min.css" >

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css" />
  <link rel="stylesheet" href="CSS/ddrcPro.css">
    <title>Beneficary Dels</title>
</head>

<body>
  <div class="container">
    <header id="main-header">
      <div class="row no-gutters">
        <div class="col-lg-3 col-sm-5">
          <a href="<?php echo $DDRCrow['photo']; ?>" data-toggle="lightbox">
          <img src="<?php echo $DDRCrow['photo']; ?>" alt="">
          </a>
        </div>
        <div class="col-lg-9 col-md-7">
          <div class="d-flex flex-column">
            <div  class="p-5 bg text-white">
            <h1 class="display-5"><?php echo ucwords($DDRCrow['bName']); ?></h1>
            </div>


            <div class="text-white text-center p-5 collaps">
              <div class="d-flex flex-row text-white">
                <div class="port-item">
                  <h4>
                  <span  class="badge badge-secondary"><?php echo ucwords($DDRCrow['gender']); ?></span>
                  </h4>
                </div>

                <div class="port-item">
                  <h4> Age
                  <span class="badge badge-secondary"><?php echo ucwords($DDRCrow['age']); ?></span>
                  </h4>
                </div>

                <div class="port-item">
                  <a href="#" class="btn btn-outline-secondary text-light" data-toggle="collapse" data-target="#home">
                  <i class="fas fa-angle-double-down text-light pr-1"></i>More
                  </a>
                </div>

                <div class="port-item">
                  <a href="updateBeneficary.php?ddrc_id=<?php echo $id; ?>" class="btn btn-outline-secondary text-light">
                  <i class="fas fa-user-edit text-light pr-1"></i> Edit
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </header>
  
    <!-- HOME -->
    <div id="home" class="collapse">
      <div id="outerCard" class="card card-body py-5">
      <div class="card-columns">
          <div class="card my-4 shadow  mb-3 bg-white rounded">
            <div class="card-body">
              <h5 class="card-title"></h5>
              <p class="p-2 mb-2 bg-secondary text-white">
                Father Name : <?php echo ucwords($DDRCrow['fatherName']); ?>
              </p>
              <p class="p-2 mb-2 bg-secondary text-white">
                Mother Name : <?php echo ucwords($DDRCrow['motherName']); ?>
              </p>
              <p class="p-2 mb-2 bg-secondary text-white">
                Age : <?php echo ucwords($DDRCrow['age']); ?>
              </p>
             
            </div>
          </div>
          <div class="card shadow mb-3 bg-white rounded">
            <div class="card-body">
             <p class="p-2 mb-2 bg-secondary text-white">
                Gender : <?php echo ucwords($DDRCrow['gender']); ?>
              </p>
              <p class="p-2 mb-2 bg-secondary text-white">
                Religion : <?php echo ucwords($DDRCrow['religion']); ?>
              </p>
              <p class="p-2 mb-2 bg-secondary text-white">
                Appointment Date : <?php echo ucwords($DDRCrow['dateOfAppointment']); ?>
              </p>
            </div>
          </div>
          <div class="card shadow  bg-white rounded">
            <div class="card-body">
              <h5 class="card-title"></h5>
                <div class="p-2 mb-2 bg-secondary text-white text-wrap">
                  Disability Type : <?php echo ucwords($DDRCrow['disabilityType']); ?>
                </div>
                <p class="p-2 mb-1 bg-secondary text-white">
                  Disability % : <?php echo ucwords($DDRCrow['disabilityPercent']); ?>
                </p>
                </p>
            </div>
          </div>
          <div class="card bg-light text-white text-center p-3 shadow mb-3 bg-white rounded">
            <h5 class="card-title text-dark font-weight-bolder">Address</h5>
              <blockquote class="blockquote">
              <p class="font-weight-bold font-italic p-3 bg-secondary">
              <?php echo ucwords($DDRCrow['addres']); ?>
              </p>
              </blockquote>
          </div>
          <div class="card shadow bg-white rounded">
            <div class="card-body ">
              <h5 class="card-title"></h5>
                <p class="p-3 mb-1 bg-secondary text-white">
                 Reffered By: <?php echo ucwords($DDRCrow['recommendedBy']); ?>
                </p>
            </div>
          </div>



          <div class="card mt-4 shadow bg-white rounded">
            <div class="card-body bg-secondary">
              <h5 class="card-title">Contact Details</h5>
                <p class="p-2 mb-2 text-white">
                <?php echo ucwords($DDRCrow['phone']); ?>
                </p>
            </div>
          </div>
          <div class="card shadow bg-white rounded">
            <div class="card-body bg-secondary">
              <h5 class="card-title">Services Offered</h5>
                <p class="p-1 mb-1 text-white">
                  <?php echo ucwords($DDRCrow['serviceOffered']); ?>
                </p>
            </div>
          </div>
          <div class="card shadow bg-white rounded">
            <div class="card-body bg-secondary">
              <h5 class="card-title">Aadhar Number</h5>
                <p class="p-1 mb-1  text-white">
                  <?php echo ucwords($DDRCrow['aadharNo']); ?>
                </p>
            </div>
          </div>
        </div>
      </div>
    </div>



    <!-- FOOTER -->
    <footer id="main-footer" class="p-5 text-white">
      <div class="row">
        <div class="col-md-6">
            <a href="ddrcBeneficary.php" class="btn btn-outline-secondary text-dark">
            <i class="fas fa-angle-double-left"></i> Back
            </a>
          
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