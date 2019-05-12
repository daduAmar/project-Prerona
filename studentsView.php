<?php
       session_start();
              
            include_once "includes/connect.php";
  
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>studentsView</title>
  <link rel="stylesheet" href="CSS/bootstrap.min.css" >
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
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
            <a href="adminHome.php" class="nav-link">Admin Dashboard</a>
          </li>
          <li class="nav-item px-2">
            <a href="std_dtls.php" class="nav-link"> Student Registration </a>
          </li>
          <li class="nav-item px-2">
            <a href="#" class="nav-link">DDRC</a>
          </li>
          <li class="nav-item px-2">
            <a href="#" class="nav-link">Users</a>
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
  <header id="main-header" class="py-2 bg-primary text-white">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <h1>
          <i class="fas fa-wheelchair"></i> Students Details</h1>
        </div>
      </div>
    </div>
  </header>
  <!-- SEARCH -->
  <section id="search" class="py-4 mb-4 bg-light">
    <div class="container">
      <div class="row">
        <div class="col-md-6 ml-auto">
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Search Student...">
            <div class="input-group-append">
              <button class="btn btn-primary">Search</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <?php
    //require_once "includes/connect.php";

    $sql = "SELECT * FROM students_Info WHERE scheme_id = 2";

    $result = mysqli_query($conn, $sql)
          or die("Error in fetching records");

    $totalRow = mysqli_num_rows($result);



    $query = "SELECT * FROM students_Info WHERE scheme_id = 1";

    $rslt = mysqli_query($conn, $query)
          or die("Error in fetching records");

    $totRow = mysqli_num_rows($rslt);

  ?>
  <!-- students -->
  <section id="students">
    <div class="container">
      <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-header">
                  <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#ssTab" aria-expanded="false" aria-controls="ssTab">
                  Special School <span class="badge badge-light"><?php echo $totalRow; ?></span>
                  </button>
                  <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#dTab" aria-expanded="false" aria-controls="dTab">
                   Disha <span class="badge badge-light"><?php echo $totRow; ?></span>
                  </button>
            </div>
            <div class="collapse" id="ssTab">
              <div class="card card-body">
                <table class="table table-striped">
                  <thead class="thead-dark">
                    <tr>
                      <th class="text-center">Name</th>
                      <th class="text-center">Admission Date</th>
                      <th class="text-center" colspan="2">Action</th>
                    </tr>  
                  </thead>
                  <tbody>
                  <?php 
        
                    $sql = "SELECT * FROM students_Info WHERE scheme_id = 2";

                    $result = mysqli_query($conn, $sql)
                          or die("Error in fetching records");
                    $rows = mysqli_fetch_all($result);
                      
                    if ($result === false) {
                         exit("Couldn't execute the query." . mysqli_error($conn));
                    } 
                  ?>
                  <?php  foreach ($rows as $row): ?>
                    <tr>
                      <td class="text-center"><?php echo $row[2]; ?></td>
                      <td class="text-center"><?php echo $row[18]; ?></td>
                      <td class="text-center">
                      <a href="std_profile.php?s_id=<?php echo $row[0]; ?>" class="btn btn-primary">
                      <i class="fas fa-angle-double-right"></i> View More
                      </a>
                      </td>
                    </tr>
                  <?php endforeach; ?> 
                  </tbody>
                </table>   
              </div>
            </div>
            <div class="collapse" id="dTab">
              <div class="card card-body">
                <table class="table table-striped">
                  <thead class="thead-dark">
                    <tr>
                    <th class="text-center">Name</th>
                      <th class="text-center">Admission Date</th>
                      <th class="text-center" colspan="2">Action</th>
                    </tr>  
                  </thead>
                  <tbody>
                  <?php 
                      $sql = "SELECT * FROM students_Info WHERE scheme_id = 1";

                      $result = mysqli_query($conn, $sql)
                            or die("Error in fetching records");
                      $rows = mysqli_fetch_all($result);
                        
                      if ($result === false) {
                          exit("Couldn't execute the query." . mysqli_error($conn));
                      } 
                  ?>
                   <?php  foreach ($rows as $row): ?>
                    <tr>
                      <td class="text-center"><?php echo $row[2]; ?></td>
                      <td class="text-center"><?php echo $row[18]; ?></td>
                      <td class="text-center">
                      <a href="std_profile.php?s_id=<?php echo $row[0]; ?>" class="btn btn-primary">
                      <i class="fas fa-angle-double-right"></i> View More
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
  </section>
  <br>
  <!-- Footer -->
  <?php require "includes/footer.php"; ?>
  
<!-- bootstrap script -->
<script src="JS/bootstrapJquery.js"></script>
<script src="JS/popper.min.js"></script>
<script src="JS/bootstrap.min.js"></script>
</body>
</html>