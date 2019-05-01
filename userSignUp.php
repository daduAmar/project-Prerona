<?php
  require "includes/connect.php";

  require_once "MyUtil.php";

  define('ROOT_URL', 'http://localhost/prerona/');

  if(isset($_POST["submit"])){
    $userName = $_POST["userName"];
    $u_email = $_POST["email"];
    $password = $_POST["pswd"];
    $cPassword = $_POST["cpswd"];

    //setting time zone
    date_default_timezone_set('Asia/Kolkata');

    //get current time
    $createdAt = date('d-m-Y h:i:sa');


    // Creates a password hash
    $pswd = password_hash($password, PASSWORD_DEFAULT);

    //reset code
    $code = md5(crypt(rand(), 'aa'));



    // Prepare an insert statement
    $sql = "INSERT INTO users (userName, email, pswd, createdAt, resetCode) VALUES (?, ?, ?, ?, ?)";
      
    if($stmt = mysqli_prepare($conn, $sql)){
       
      // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "sssss", $userName, $u_email, $pswd, $createdAt, $code);
      
        mysqli_stmt_execute($stmt);

        $email = "bharatidadu47@gmail.com";
        $subject = "Prerona:Account Verfication";
        $body  = "Hi!You have signed up in Prerona's Student Portal,in order to complete the signed up process click <a href='".ROOT_URL."account_verify.php?code=$code'> Verify
        </a>here...";
      
        $emailResponse = MyUtil::sendEmail($email, 'amarjyoti.gautam@gmail.com', $subject, $body);
    
        header("Location: preronaHome.php?cEmail");
    } else{
        echo "ERROR: Could not prepare query: $sql. " . mysqli_error($conn);
    }
    // Close statement
    mysqli_stmt_close($stmt);

  }
  
?>