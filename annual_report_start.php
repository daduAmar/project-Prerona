<?php 
   session_start();
   include_once "includes/connect.php";

  //  if(!isset($_SESSION['username'])){
  //   header("Location: preronaHome.php");
  // }

  if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["next"])) {
    $agency = trim($_POST['agency']);
    $address = trim($_POST['address']);
    $month = trim($_POST['month']);
    $person = trim($_POST['person']);
    $yr_quater = trim($_POST['yr_quater']);

    /// DO VALIDATIONS
    $sql = "INSERT INTO year(agency, address, month, total_person_benefit, cur_yr_quater, year) 
    VALUES ('$agency', '$address', '$month', $person, '$yr_quater', YEAR(NOW()))";

    if (mysqli_query($conn, $sql)) {
      // get the last inserted id
      $_SESSION['YEAR_ID'] = mysqli_insert_id($conn);

      // redirect to the data insertion page
      header("Location: annual_report.php"); /* Redirect browser */

      /* Make sure that code below does not get executed when we redirect. */
      exit;
    } 
    else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
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
  <link rel="stylesheet" href="CSS/annual_report.css">
  <title>Annual Report</title>
</head>
   
<body >
  <nav class="navbar navbar-expand-md bg-dark navbar-dark fixed-top" id="main-nav">
    <div class="container">
      <p href="#" class="navbar-brand active font-weight-bolder">DISTRICT DISABILITY REHABILATION CENTER</p>
      <button class="navbar-toggler"
      type="button" data-toggle="collapse"
       data-target="#navbarNav" aria-controls="navbarNav"
       aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a href="adminHome.php" class="nav-link font-weight-bolder"><i class="fas fa-users-cog mr-1"></i>Dashboard</a>
          </li>
          
          <li class="nav-item">
            <a href="ddrc.php" class="nav-link font-weight-bolder"><i class="fas fa-list mr-1"></i>DDRC
            </a>
          </li>

          <li class="nav-item">
            <a href="annual_report_start.php" class="nav-link active  font-weight-bolder"><i class="fas fa-newspaper mr-1"></i>Annual Report
            </a>
          </li>

          <li class="nav-item">
            <a href="show_annual_report.php" class="nav-link font-weight-bolder">
            <i class="fas fa-book-open mr-1"></i> View Annual Report
            </a>
          </li>

        </ul>
      </div>
    </div>
  </nav>

  
  <!-- HOME SECTION -->
 
  <header id="home-section">
    <div class="dark-overlay">
      <div class="home-inner">
        <div class="container mt-5">
          <div class="row">
            <div class="col-sm-6 offset-sm-3">
              <div class="card card-body text-dark card-form">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                  
                  <div class="form-group">
                    <label for="agency">Name of the implementing agency</label>
                    <input type="text" name="agency" class="form-control" id="agency" placeholder="Implementing Agency">
                  </div>
                  <div class="form-group">
                    <label for="address">Name of DDRC and address</label>
                    <input type="text" name="address" class="form-control" id="address" placeholder="DDRC and Address">
                  </div>
                  <div class="mb-4">
                    <label for="month">Month of inception</label>
                    <select class="custom-select" name="month" id="month">
                    <option value="-1">*** Select Month ***</option>
                    <option value="jan">January</option>
                    <option value="feb">February</option>
                    <option value="mar">March</option>
                    <option value="apr">April</option>
                    <option value="may">May</option>
                    <option value="jun">June</option>
                    <option value="july">July</option>
                    <option value="aug">August</option>
                    <option value="sept">September</option>
                    <option value="oct">October</option>
                    <option value="nov">November</option>
                    <option value="dec">December</option>
                  </select>
                  </div>
                  <div class="form-group">
                    <label for="person">Total no of person benifieted up to the...</label>
                    <input type="number" name="person" class="form-control" id="person">
                  </div>
                  <div class="form-group">
                    <label for="yr_quater">During the current year quater...</label>
                    <input type="text" name="yr_quater" class="form-control" id="yr_quater">
                  </div>
                  <div class="form-group">
                    <input type="submit" name="next" class="btn btn-dark btn-block" value="Next">
                  </div>
                </form>

              </div>
            </div>
          </div>    
        </div>
      </div>
    </div>
  </header>
  
  


  <!-- scripts -->
  <script src="JS/bootstrapJquery.js"></script>
  <script src="JS/popper.min.js"></script>
  <script src="JS/bootstrap.min.js"></script>
</body>

</html>