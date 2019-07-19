<?php
    session_start();
    require_once "includes/connect.php";

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
  <link rel="stylesheet" href="CSS/bootstrap.min.css"> 
  <link rel="stylesheet" href="CSS/admin.page.css" >
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
  <title>Users</title>
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
            <a href="adminHome.php" class="nav-link">Dashboard</a>
          </li>
          <li class="nav-item px-2">
            <a href="std_dtls.php" class="nav-link"> Student Registration </a>
          </li>
          <li class="nav-item px-2">
            <a href="ddrc.php" class="nav-link">DDRC</a>
          </li>
          <li class="nav-item px-2">
          <a href="studentsView.php" class="nav-link">Students Details</a>
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
  <header id="user-header" class="py-2 bg-user text-white">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <h1>
            <i class="fas fa-users"></i> Users</h1>
        </div>
      </div>
    </div>
  </header>

  <!-- SEARCH -->
  <section id="search" class="py-4 mb-4 bg-light">
    <div class="container">
    </div>
  </section>

  <!-- USERS -->
  <section id="users">
    <div class="container">
      <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-header">
              <h4>Registered Users</h4>
            </div>
            <table class="table table-striped">
              <thead class="thead-dark">
                <tr>
                  <th class="text-center">User Name</th>
                  <th class="text-center">Email</th>
                  <th class="text-center">Registered At</th>
                  <th class="text-center" colspan="2">Action</th>
                </tr>
              </thead>
              <tbody>

              <?php 
        
                $sql = "SELECT * FROM users WHERE is_active = 1";

                $result = mysqli_query($conn, $sql)
                      or die("Error in fetching records");
                $rows = mysqli_fetch_all($result);
                
                if ($result === false) {
                      exit("Couldn't execute the query." . mysqli_error($conn));
                } 
              ?>
              <?php  foreach ($rows as $row): ?>

                <tr>
                  <td class="text-center"><?php echo $row[1]; ?></td>
                  <td class="text-center"><?php echo $row[2]; ?></td>
                  <td class="text-center"><?php echo $row[4]; ?></td>
                  <td class="text-center">
                    <a href="delUser.php?s_id=<?php echo $row[0]; ?>" class="btn btn-danger">
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
  </section>
  <br>
  <!-- Footer -->
  <?php require "includes/footer.php"; ?>
  
  <!-- bootstrap script -->
  <script src="scripts/tweaks.js"></script>
  <script src="JS/bootstrapJquery.js"></script>
  <script src="JS/popper.min.js"></script>
  <script src="JS/bootstrap.min.js"></script>
</body>
</html>