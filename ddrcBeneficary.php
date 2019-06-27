<?php 
   session_start();
   include_once "includes/connect.php";

   if(!isset($_SESSION['username'])){
    header("Location: preronaHome.php");
  }

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="CSS/bootstrap.min.css" > 
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
  <link rel="stylesheet" href="CSS/benef.css">
  <title>DDRC</title>
</head>
   
<body >
  <nav class="navbar navbar-expand-md bg-dark navbar-dark fixed-top" id="main-nav">
    <div class="container">
      <p href="#" class="navbar-brand active font-weight-bolder">DISTRICT DISABILITY REHABILATION CENTER</p>
      <button class="navbar-toggler"
      type="button" data-toggle="collapse"
       data-target="#navbarNav" aria-controls="navbarNav"
       aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a href="ddrc.php" class="nav-link font-weight-bolder active"><i class="fas fa-list mr-1"></i>DDRC
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
      <div class="home-inner ml-3 mr-3 mb-4">
        <?php if(isset($_POST["submit"]) && $check_In === true): ?>
          <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
            <?php
              echo isset($sizeError) ? $sizeError : "";
              
            ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <?php endif; ?>
        <div class="container">
          <div class="row">
            <div class="col">
              <div class="table-responsive-sm">
                <table class="table table-striped table-bordered table-hover bg-white">
                  <thead class="thead-dark">
                    <tr>
                      <th class="text-center">Beneficary Id</th>
                      <th class="text-center">Name</th>
                      <th class="text-center">Gender</th>
                      <th class="text-center">Phone</th>
                      <th class="text-center" colspan="2">Action</th>
                    </tr>  
                  </thead>
                  <tbody>
                    <?php 
          
                      //hostellers info
                      $sql = "SELECT * FROM DDRC";

                      $result = mysqli_query($conn, $sql)
                            or die("Error in fetching records");

                      $ddrcRows = mysqli_fetch_all($result, MYSQLI_ASSOC);
                      //print_r($ddrcRows);
                        
                      if ($result === false) {
                          exit("Couldn't execute the query." . mysqli_error($conn));
                      } 
                    ?>
                    <?php foreach($ddrcRows as $ddrcRow): ?>
                      <tr>
                        <td class="text-center"><?php echo $ddrcRow['beneficiary_Id']; ?></td>
                        <td class="text-center"><?php echo $ddrcRow['bName']; ?></td>
                        <td class="text-center"><?php echo $ddrcRow['gender']; ?></td>
                        <td class="text-center"><?php echo $ddrcRow['phone']; ?></td>
                        <td class="text-center">
                          <a href="beneficaryPro.php?ddrc_id=<?php echo $ddrcRow['ddrc_Id']; ?>" class="btn btn-success btn-sm">
                          <i class="fas fa-angle-double-down"></i> View More
                          </a>
                        </td>
                        <td class="text-center">
                          <a href="respiteView.php?ddrc_id=<?php echo $ddrcRow['ddrc_Id']; ?>" class="btn btn-danger btn-sm">
                          <i class="fas fa-minus-circle"></i> Remove
                          </a>
                        </td>
                      </tr>
                    <?php endforeach; ?> 
                  </tbody>
                </table>  
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