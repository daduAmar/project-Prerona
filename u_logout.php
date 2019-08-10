<?php

require_once 'includes/connect.php';


// Starting session
session_start();

//session_unset(); // remove all session variables

// Destroying session
if(isset($_SESSION['username'])){
    unset($_SESSION['username']);
}


header("Location: index.php?loggedout");
exit;
?>