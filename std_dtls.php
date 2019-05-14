<?php 
    session_start();
    include_once "includes/connect.php";
    $sql="SELECT * FROM scheme";
    $result = mysqli_query($conn,$sql) or die(mysqli_error($conn));
   
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="CSS/bootstrap.min.css" > 
  <link rel="stylesheet" href="CSS/admin.page.css" > 
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
  <title>sDetails</title>
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
            <a href="std_dtls.php" class="nav-link active">Student Registration</a>
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
          <i class="fas fa-user-plus"></i> Student Registration</h1>
        </div>
      </div>
    </div>
  </header>


    <!-- body SECTION -->
    <section id="body-section">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 offset-lg-3 border border-dark rounded shadow-lg p-3 mb-5 bg-white rounded pt-3 mt-5 bg-light">
            <form method="post" action="Std_details_submit.php" id="form">
              <div class="mb-4">
                <label for="scheme">Select Scheme</label>
                <select class="custom-select custom-select-lg" name="scheme_Id" id="scheme" onchange="showInputFields(this.id)">
                    <option selected>Select a scheme</option>
                  <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    
                    <option value="<?php echo $row['scheme_Id'] ?>"> <?php echo $row['schemeName'] ?> </option>

                  <?php endwhile; ?>
                </select>
              </div>

              <div class="form-group" >
                <label>Student Name</label>
                <input type="text" class="form-control form-control-lg" id="stdName" name="name" placeholder="Enter name">
              </div>

              <div class="row">  
                <div class="form-group col" >
                  <label for="dob">Date Of Birth</label>
                  <input type="date" class="form-control" name="birthDate" id="dob">
                </div>

                <div class="form-group col">
                  <label class="text-center">Age</label>
                  <input type="number" readonly class="form-control-plaintext" name="stdAge" id="age" >
                  <small class="text-muted">Enter Date Of Birth to calculate age!</small>
                </div>
              </div>  

              <div class="form-group" id="bPlace" >
                <label for="pob">Place Of Birth</label>
                <input type="text" class="form-control" name="birthPlace" id="pob" placeholder="Enter place of birth">
              </div>

              <div class="row">  
                <div class="form-group col" >
                  <label for="fname">Father Name</label>
                  <input type="text" class="form-control" name="fatherName" id="fname" placeholder="Father Name">
                </div>

                <div class="form-group col" >
                  <label for="mname">Mother Name</label>
                  <input type="text" class="form-control" name="motherName" id="mname" placeholder="Mother Name">
                </div>
              </div>  

              <div class="mb-4">
              <label for="gender">Gender</label>
              <select class="custom-select custom-select" name="gender" id="gender">
                <option selected>Select applicant's gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="others">Others</option>
              </select>
              </div>

              <div class="row">
                <div class="mb-4 col">
                <label for="religion">Religion</label>
                <select class="custom-select custom-select-sm" name="religion" id="religion">
                  <option selected>Select religion</option>
                  <option value="hindu">Hindu</option>
                  <option value="muslim">Muslim</option>
                  <option value="christain">Christain</option>
                  <option value="sikh">Sikh</option>
                  <option value="jain">Jain</option>
                  <option value="buddhist">Buddhist</option>
                  <option value="parsi">Parsi</option>
                  <option value="others">Others</option>
                </select>
                </div>

                <div class="mb-4 col">
                <label for="hostel">Caste</label>
                <select class="custom-select custom-select-sm" name="caste" id="caste">
                  <option selected>Select Caste</option>
                  <option value="GEN">GEN</option>
                  <option value="OBC">OBC</option>
                  <option value="MOBC">MOBC</option>
                  <option value="SC">SC</option>
                  <option value="ST">ST</option>
                </select>
                </div>
              </div>  

              <div class="form-group">
                <label for="address">Address</label>
                <textarea class="form-control" name="address" id="address" placeholder="Enter applicant's address"></textarea>
              </div>

              <div class="row">
                <div class="form-group col">
                  <label for="class">State</label>
                  <input type="text" class="form-control" name="state" id="state" placeholder="State">
                </div>

                <div class="form-group col">
                  <label for="class">District</label>
                  <input type="text" class="form-control" name="dist" id="dist" placeholder="District">
                </div>

                <div class="form-group col">
                  <label for="class">Zip Code</label>
                  <input type="text" class="form-control" name="zip" id="zip" placeholder="Zip Code">
                </div>
              </div>  

              <div class="form-group" >
                <label for="class">Class</label>
                <input type="text" class="form-control" name="class" id="class" placeholder="Enter class">
              </div>

              <div class="mb-4" id="disability">
              <label for="hostel">Disability Type</label>
              <select class="custom-select custom-select" name="disabilityType">
                <option selected>Select Applicant's Disability</option>
                <option value="Mental Retardation">Mental Retardation</option>
                <option value="Cerebral Palsy">Cerebral Palsy</option>
              </select>
              </div>

              <div class="form-group" >
                <label for="admissionDate">Admission Date</label>
                <input type="date" class="form-control" name="admissionDate" id="admissionDate">
              </div>

              

              <div class="row">  
                <div class="mb-4 col">
                <label for="hostel">Respite</label>
                <select class="custom-select custom-select-sm" name="hostel" id="hostel">
                  <option selected>Choose..</option>
                  <option value="Yes">Yes</option>
                  <option value="No">No</option>
                </select>
                </div>

                <div class="mb-4 col">
                <label for="transpotation">Transpotation</label>
                <select class="custom-select custom-select-sm" name="transpotation" id="transpotation">
                  <option selected>Choose..</option>
                  <option value="Yes">Yes</option>
                  <option value="No">No</option>
                </select>
                </div>

                <div class="mb-4 col">
                <label for="bpl">Income Group</label>
                <select class="custom-select custom-select-sm" name="incomeGroup" id="bpl">
                  <option selected>Select a group</option>
                  <option value="BPL">BPL</option>
                  <option value="LIG">LIG</option>
                  <option value="Non-LIG">Non-LIG</option>
                </select>
                </div>
              </div>  

              <div class="form-group" >
                <label for="iCard">I-Card Number</label>
                <input type="text" class="form-control" name="iCard" id="iCard" placeholder="Provide applicant's school I-Card number">
              </div>

              <div class="form-group" >
                <label for="aadhar">Aadhar Number</label>
                <input type="number" class="form-control" name="aadhar" id="aadhar" placeholder="Provide aadhar number if any!">
              </div>

              <div class="row">
                <div class="form-group col" >
                  <label for="bankDtls">Bank A/c Number</label>
                  <input type="number" class="form-control" name="bankDtls" id="bankDtls" placeholder="A/c No. ">
                </div>

                <div class="form-group col" >
                  <label for="ifsc">IFSC Code</label>
                  <input type="text" class="form-control" name="ifsc" id="ifsc" placeholder="IFSC Code">
                </div>

                <div class="form-group col" >
                  <label for="bankBranch">Branch Name</label>
                  <input type="text" class="form-control" name="bankBranch" id="bankBranch" placeholder="Branch Name">
                </div>
              </div>

              <button type="submit" id="sub" name="submit" class="btn btn-info btn-block mt-2">Submit</button>
              <br>
            </form>
          </div>  
        </div>   
      </div>
    </section>
 
  
  <!-- FOOTER -->
  <?php require "includes/footer.php"; ?>
  
  <!-- bootstrap script -->
  <script src="scripts/age.js"></script>
  <script src="scripts/tweaks.js"></script>
  <script src="JS/bootstrapJquery.js"></script>
<script src="JS/popper.min.js"></script>
<script src="JS/bootstrap.min.js"></script>
</body>
</html>