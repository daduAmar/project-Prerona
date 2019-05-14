<?php
    session_start();
    require_once "includes/connect.php";
    

    if(isset($_SESSION['username'])){
      header("Location: adminHome.php");
    }

    if(isset($_POST["submit"])){
    $username = $_POST['userName'];
    $password = $_POST['pass'];
    $is_ok = true;
     
     
     $sql = "SELECT * FROM users WHERE userName =?";
      
     if($stmt = mysqli_prepare($conn, $sql)){
        
       // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $username);
       
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_assoc($result);
         
        if($row['is_active'] == 0){

          $is_ok = false;
          //header("Location: preronaHome.php");

        }else{
          if(password_verify($password, $row['pswd'])){
              
            $_SESSION['user_id'] = $row['users_Id'];
            $_SESSION['username'] = $row['userName'];

            header("Location: adminHome.php");
          }  
        }
     }else{
         echo "ERROR: Could not prepare query: $sql. " . mysqli_error($conn);
     }
     // Close statement
     mysqli_stmt_close($stmt);

   }

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="CSS/bootstrap.min.css" > 
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
  <link rel="stylesheet" href="CSS/style.css">
  <title>Home</title>
</head>

<body >
  <nav class="navbar navbar-expand-md bg-dark navbar-dark fixed-top" id="main-nav">
    <div class="container">
      <a href="#" class="navbar-brand">PRERONA</a>
      <button class="navbar-toggler"
      type="button" data-toggle="collapse"
       data-target="#navbarNav" aria-controls="navbarNav"
       aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a href="#home" class="nav-link"></a>
          </li>
          <li class="nav-item">
            <a href="#explore-head-section" class="nav-link"></a>
          </li>
          <li class="nav-item">
            <a href="#share-head-section" class="nav-link"></a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- HOME SECTION -->
 
  <header id="home-section">
    <div class="dark-overlay">
      <div class="home-inner container">
          <?php if(isset($_POST["submit"]) && $is_ok === false): ?>
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php
                echo "<strong> Oops access denied! </strong> Your account is not active. Check your email";
                ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
          <?php endif; ?>
          <div id="notify">

          </div>
        <div class="row">
          <div class="col-lg-6 mr-5 d-none d-lg-block">
            <h1 class="display-4">Already Registered?
            </h1>
            <div class="d-flex ">
            <div class="p-2 align-self-end display-4">
               Log In...
              <span class="align-self-start">
              <i class="fas fa-arrow-alt-circle-down"></i>
              </span>
              </div>
            </div>
            
            <!-- signin_form -->
              <div class="card bg-primary text-center card-form">
                <div class="card-body">
                  <p>Enter your credentials to sign in...</p>
                  <form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
                    <div class="form-group">
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-primary text-white">
                          <i class="fas fa-user"></i>
                          </span>
                        </div>
                      <input type="text" class="form-control" name="userName" id="uName" placeholder="Username/Email">
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-primary text-white">
                          <i class="fas fa-key"></i>
                          </span>
                        </div>
                      <input type="password" class="form-control" name="pass" id="password1" placeholder="Password">
                      </div>
                    </div>
                    <input type="submit" value="Sign In" name="submit" class="btn btn-outline-light btn-block">
                  </form>
                </div>
              </div>

            <div class="d-flex">
            </div>

            <div class="d-flex">
            </div>
          </div>
         
          <div class="col-lg-4 ml-5">
            <div class="card bg-success text-center card-form">
              <div class="card-body">
                <h3>Sign Up Here...</h3>
                <p>Please fill out this form to register</p>
                <form class="mt-5" id="form"  method="post" action="userSignUp.php">
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text bg-success text-white">
                        <i class="fas fa-user-plus"></i>
                        </span>
                      </div>  
                    <input type="text" class="form-control input" name="userName" id="userName" placeholder="Username">
                      <div class="input-group-append " id="errorIcon">
                        <span class="input-group-text" id="iTag">
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text bg-success text-white">
                        <i class="fas fa-at"></i>
                        </span>
                      </div>
                    <input type="email" class="form-control input" name="email" id="uEmail" placeholder="Email">
                      <div class="input-group-append" id="errorIconEm">
                        <span class="input-group-text" id="iTag1">
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text bg-success text-white">
                        <i class="fas fa-key"></i>
                        </span>
                    </div>
                  <input type="password" class="form-control" name="pswd" id="password" placeholder="Enter Password">
                  </div>
                  <div class="form-group">
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text bg-success text-white">
                          <i class="fas fa-lock"></i>
                        </span>
                      </div>
                    <input type="password" class="form-control" name="cpswd" id="cpassword" placeholder="Re-Enter Password">
                    </div>
                  </div>
                  <input type="submit" id="signUp" name="submit" value="Sign Up" class="btn btn-outline-light btn-block">
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>
  
  <!-- FOOTER -->
  <footer id="main-footer" class="bg-dark">
    <div class="container">
      <div class="row">
        <div class="col text-center py-3">
          <h3>PRERONA</h3>
          <p> Designed by | Amarjyoti Gautam | &copy;<span id="year"></span> -----All right reserved.
            
          </p>
        </div>
      </div>
    </div>  
  </footer>


  <!-- bootstrap script -->
  <script src="scripts/validation.js"></script>
  <script src="scripts/tweaks.js"></script>
  <script src="JS/bootstrapJquery.js"></script>
  <script src="JS/popper.min.js"></script>
  <script src="JS/bootstrap.min.js"></script>
 
</body>

</html>