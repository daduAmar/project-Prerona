<?php
 session_start();
 
if(!isset($_SESSION['username'])){
  header("Location: preronaHome.php");
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
  <title>Admin</title>
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
            <a href="adminHome.php" class="nav-link active">Admin Dashboard</a>
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
          <i class="fas fa-users-cog mr-1"></i> Admin Dashboard</h1>
        </div>
      </div>
    </div>
  </header>

  <!-- ACTIONS -->
  <section id="actions" class="py-4 mb-4 bg-light">
    <div class="container">
      <div class="row">
        <div class="col-md-3">
          <a href="#" class="btn btn-primary btn-block" data-toggle="modal" data-target="#addPostModal">
            <i class="fas fa-plus"></i> Add Hostel
          </a>
        </div>
        <div class="col-md-3">
          <a href="#" class="btn btn-success btn-block" data-toggle="modal" data-target="#addCategoryModal">
            <i class="fas fa-plus"></i> Add Therapy
          </a>
        </div>
        <div class="col-md-3">
          <a href="#" class="btn btn-warning btn-block" data-toggle="modal" data-target="#addUserModal">
            <i class="fas fa-plus"></i> Add User
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- BODY  -->
  <?php
    require_once "includes/connect.php";

    $sql = "SELECT * FROM users WHERE is_active = 1";

    $result = mysqli_query($conn, $sql)
          or die("Error in fetching records");

    $totalRow = mysqli_num_rows($result);

  ?>
  <?php

    $sql = "SELECT * FROM students_Info";

    $result = mysqli_query($conn, $sql)
          or die("Error in fetching records");

    $rowCount = mysqli_num_rows($result);

  ?>

  <br>
  <section id="home_section">
    <div class="container mt-4">
      <div class="row">
        <div class="col-md-4">
          <div class="card text-center bg-info text-white mb-3">
            <div class="card-body">
              <h3>Students</h3>  
              <h4 class="display-4">
              <i class="fas fa-wheelchair mr-3"></i><?php echo $rowCount; ?>
              </h4>
              <a href="studentsView.php" class="btn btn-outline-light btn-sm">View</a>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card text-center bg-success text-white mb-3">
            <div class="card-body">
              <h3>Hostel Capacity</h3>
              <h4 class="display-4">
              <i class="fas fa-hotel"></i> 4
              </h4>
              <a href="#" class="btn btn-outline-light btn-sm">View</a>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card text-center bg-warning text-white mb-3">
            <div class="card-body">
              <h3>Users</h3>
              <h4 class="display-4">
                <i class="fas fa-users mr-3"></i><?php echo $totalRow; ?>
              </h4>
              <a href="users.php" class="btn btn-outline-light btn-sm">View</a>
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

  

 

