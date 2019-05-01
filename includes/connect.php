<?php

$hostName = "localhost";
$username = "root";
$password = "";
$database = "preronaDB";

$conn = mysqli_connect($hostName, $username, $password, $database);

// Check connection
if($conn === false){
  die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Print host information
//echo "Connect Successfully. Host info: " . mysqli_get_host_info($conn);