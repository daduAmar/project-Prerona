<?php
    session_start();
    require_once "includes/connect.php";

    if(isset($_POST["submit"])){
      
      $schemeId = $_POST["scheme_Id"];
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

      //echo $stdAge;
      // Prepare an insert statement
      $sql = "INSERT INTO students_Info (scheme_id, stdName, dob, placeOfBirth, fatherName, motherName, gender, age, religion, caste, addres, statee, district, zip, class, disabilityType, dateOfAdmission, hostel, transpotation, incomeGroup, bankAcNo, ifsc, bankBranch, iCard,  aadharNo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
      
      if($stmt = mysqli_prepare($conn, $sql)){
         
          // Bind variables to the prepared statement as parameters
          mysqli_stmt_bind_param($stmt, "issssssissssssssssssisssi", $schemeId, $name, $bDate, $bPlace, $fatherName, $motherName, $gender, $stdAge, $religion, $caste, $address, $state, $district, $zip, $class, $disability, $admissionDate, $hostel, $transpotation, $incomeGroup, $bankAcNo, $bankIFSC, $bankBranch, $iCard, $aadharNo);
        
          mysqli_stmt_execute($stmt);

          $s_Id = mysqli_insert_id($conn);

          $_SESSION['std_id'] = $s_Id;
          
          echo "Records inserted successfully.";

          if($hostel == 'Yes'){
            header("Location: hostelAdmission.php");
          }else {
            header("Location: upload.php");
          }
          
      } else{
          echo "ERROR: Could not prepare query: $sql. " . mysqli_error($conn);
      }
      // Close statement
      mysqli_stmt_close($stmt);

    }
?>