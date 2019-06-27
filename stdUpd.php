<?php
session_start();
require_once "includes/connect.php";

if(isset($_POST['update'])){ 
	
  $schemeId = $_POST["scheme_Id"];
  $sid = $_POST["sid"];
  $name = $_POST["name"];
  $bDate = $_POST["birthDate"];
  $stdAge = $_POST["stdAge"];
  $bPlace = $_POST["birthPlace"];
  $fatherName = $_POST["fatherName"];
  $motherName = $_POST["motherName"];
  $gender = $_POST["gender"];
  $religion = $_POST["religion"];
  $caste = $_POST["caste"];
  $address = $_POST["address"];
  $state = $_POST["state"];
  $district = $_POST["dist"];
  $zip = $_POST["zip"];
  $phone = $_POST["phone"];
  $class = $_POST["class"];
  $disability = $_POST["disabilityType"];
  $admissionDate = $_POST["admissionDate"];
  $hostel = $_POST["hostel"];
  $transpotation = $_POST["transpotation"];
  $incomeGroup = $_POST["incomeGroup"];
  $iCard = $_POST["iCard"];
  $aadharNo = $_POST["aadhar"];
  $bankAcNo = $_POST["bankDtls"];
  $bankIFSC = $_POST["ifsc"];
  $bankBranch = $_POST["bankBranch"];

 

  $sql="UPDATE students_Info SET scheme_id = '$schemeId', stdName = '$name', dob = '$bDate', placeOfBirth = '$bPlace', fatherName = '$fatherName', motherName = '$motherName', gender = '$gender', age = '$stdAge', religion = '$religion', caste = '$caste', addres = '$address', statee = '$state', district = '$district', zip = '$zip', phone = '$phone', class = '$class', disabilityType = '$disability', dateOfAdmission = '$admissionDate', hostel = '$hostel', transpotation = '$transpotation', incomeGroup = '$incomeGroup', bankAcNo = '$bankAcNo', ifsc = '$bankIFSC', bankBranch = '$bankBranch', iCard = '$iCard',  aadharNo = '$aadharNo'  WHERE std_Id = '$sid'";


if (mysqli_query($conn,$sql))
{
  header("Location: studentsView.php?sucs");
}
else
{
  header("Location: studentsView.php?fail");
}

}


?>