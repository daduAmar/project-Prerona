<?php
    session_start();
    require_once "includes/connect.php";
    require_once "MyUtil.php";

    define('ROOT_URL', 'http://localhost/prerona/');
    

    if(isset($_SESSION['username'])){
      header("Location: adminHome.php");
    }

    // sign in
    if(isset($_POST["submit"])){

      $username = $_POST['userName'];
      $password = $_POST['pass'];
      $is_ok = true;
      $not_active = $invalid_pass = $invalid_uName = '';
     
     
     $sql = "SELECT * FROM users WHERE userName = '$username'";
      
     if($result = mysqli_query($conn, $sql)){

      if(mysqli_num_rows($result) == 1){

        $row = mysqli_fetch_assoc($result);
        //print_r($row);
        
        if($row['is_active'] == 0){

          $is_ok = false;
          $not_active = '<strong> Oops!! access denied. </strong> Your account is not active,please check your email.... ';

        }else{

          if(password_verify($password, $row['pswd'])){
              
            $_SESSION['user_id'] = $row['users_Id'];
            $_SESSION['username'] = $row['userName'];

            header("Location: adminHome.php");
            exit;
          }else{

            $is_ok = false;
            $invalid_pass = '<strong>Password you have entered is invalid!</strong>';

          }
        }
      }else{
        $is_ok = false;
        $invalid_uName = '<strong>Invalid Username/Password Combination...</strong>';
      }
        
     }else{
         echo "ERROR: Could not prepare query: $sql. " . mysqli_error($conn);
     }

   }

   //sign up
   if(isset($_POST["signUp"])){

    $userName = $_POST["userName"];
    $u_email = $_POST["email"];
    $password = $_POST["pswd"];
    $cPassword = $_POST["cpswd"];
    $emailSend = false;
    $emailMsg = '';

    //setting time zone
    date_default_timezone_set('Asia/Kolkata');

    //get current time
    $createdAt = date('d-m-Y h:i:sa');


    // Creates a password hash
    $pswd = password_hash($password, PASSWORD_DEFAULT);

    //reset code
    $code = md5(crypt(rand(), 'aa'));

    if(!empty($userName) && !empty($u_email) && !empty($password) && !empty($cPassword)){

      // Prepare an insert statement
      $sql = "INSERT INTO users (userName, email, pswd, createdAt, resetCode) VALUES (?, ?, ?, ?, ?)";
        
      if($stmt = mysqli_prepare($conn, $sql)){
        
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "sssss", $userName, $u_email, $pswd, $createdAt, $code);
      
        mysqli_stmt_execute($stmt);

        $email = $u_email;
        $subject = "Prerona:Account Verfication";
        $body  = "Hi!You have signed up in Prerona's Student Portal,in order to complete the signed up process click <a href='".ROOT_URL."account_verify.php?code=$code'> Verify
        </a>here...";
      
        $emailResponse = MyUtil::sendEmail($email, 'amarjyoti.gautam@gmail.com', $subject, $body);

        $emailSend = true;
        $emailMsg = 'Successfully Resgistered.Go to your email to complete the sign up process...';
    
        //header("Location: preronaHome.php?cEmail");
      } else{

          echo "ERROR: Could not prepare query: $sql. " . mysqli_error($conn);
      }
      // Close statement
      mysqli_stmt_close($stmt);
    }
    else{
      header("Location: preronaHome.php?empty"); 
    }
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
      <a  class="navbar-brand">PRERONA</a>
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
              echo isset($not_active) ? $not_active : "";
              echo isset($invalid_pass) ? $invalid_pass : "";
              echo isset($invalid_uName) ? $invalid_uName : "";
            ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <?php endif; ?>

        <?php if(isset($_POST["signUp"]) && $emailSend === true): ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php
              echo isset($emailMsg) ? $emailMsg : "";
            ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <?php endif; ?>

        <?php if(isset($_GET["ac_verified"])): ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php
              echo "<em>Successfully signned up!You can login now....</em>";
            ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <?php endif; ?>
        <div class="row">
          <div class="col-sm-6 mr-5">
            <h1 class="display-4">Already Registered?
            </h1>
            <div class="p-2 align-self-end display-4">
               Log In...
              <span class="align-self-start">
              <i class="fas fa-arrow-alt-circle-down"></i>
              </span>
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
                      <input type="text" class="form-control" name="userName" id="uName" placeholder="Username" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text bg-primary text-white">
                        <i class="fas fa-key"></i>
                        </span>
                      </div>
                      <input type="password" class="form-control" name="pass" id="password1" placeholder="Password" required>
                    </div>
                  </div>
                  <input type="submit" value="Sign In" name="submit" id="signIn" class="btn btn-outline-light btn-block">
                </form>
              </div>
            </div>
          </div>
         
          <div class="col-sm-4 ml-5">
            <div class="card bg-success text-center card-form">
              <div class="card-body">
                <h3>Sign Up Here...</h3>
                <p>Please fill out this form to register</p>
                <form class="mt-5" id="form"  method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text bg-success text-white">
                          <i class="fas fa-user-plus"></i>
                        </span>
                      </div>  
                      <input type="text" class="form-control" name="userName" id="userName" placeholder="Username" maxlength="15" required>
                      <div class="input-group-append py-1" id="errorIcon">
                        <span class="input-group-text px-1" id="iTag"></span>
                      </div>
                    </div>
                    <span class="text-danger" id="errMsgUN"></span>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text bg-success text-white">
                          <i class="fas fa-at"></i>
                        </span>
                      </div>
                      <input type="email" class="form-control" name="email" id="uEmail" placeholder="Email" required>
                      <div class="input-group-append py-1" id="errorIconEm">
                        <span class="input-group-text px-1" id="iTag1">
                        </span>
                      </div>
                    </div>
                    <span class="text-danger" id="errMsgEm"></span>
                  </div>
                  <div class="form-group">
                    <div class="input-group mb-1">
                      <div class="input-group-prepend">
                        <span class="input-group-text bg-success text-white">
                        <i class="fas fa-key"></i>
                        </span>
                      </div>
                      <input type="password" class="form-control" name="pswd" id="password" placeholder="Enter Password" maxlength="8" required>
                    </div>  
                    <span class="text-danger" id="errMsgPwd"></span>
                  </div>
                  <div class="form-group">
                    <div class="input-group mb-1">
                      <div class="input-group-prepend">
                        <span class="input-group-text bg-success text-white">
                          <i class="fas fa-lock"></i>
                        </span>
                      </div>
                      <input type="password" class="form-control" name="cpswd" id="cpassword" placeholder="Re-Enter Password" maxlength="8" required>
                      <div class="input-group-append py-1" id="matchIcon">
                        <span class="input-group-text px-1" id="passIcon">
                        </span>
                      </div>
                    </div>
                    <span class="text-danger" id="errMsgCpwd"></span>
                  </div>
                  <input type="submit" id="signUp" name="signUp" value="Sign Up" class="btn btn-outline-light btn-block">
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>
  
  <!-- FOOTER -->
  <?php require "includes/footer.php"; ?>


  <!-- bootstrap script -->
  <script src="scripts/validation.js"></script>
  <script src="JS/bootstrapJquery.js"></script>
  <script src="JS/popper.min.js"></script>
  <script src="JS/bootstrap.min.js"></script>
 
</body>

</html>