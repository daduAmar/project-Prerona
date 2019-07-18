<?php 
   session_start();
   include_once "includes/connect.php";

  //  if(!isset($_SESSION['username'])){
  //   header("Location: preronaHome.php");
  // }

  $sql = "SELECT * FROM parentCategory";
  $result = mysqli_query($conn, $sql) or die("Error in fetching records");

  $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
  //print_r($rows);
  if ($result === false) {
      exit("Couldn't execute the query." . mysqli_error($conn));
  }

  if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["cat_submit"])) {
    $p_id = $_GET['p_id'];

    if($p_id != -1) {
      // fetch categories
      $sql = "SELECT category.id, category.name from category WHERE category.p_id = $p_id";

      $result = mysqli_query($conn, $sql) or die("Error in fetching records");

      $catRows = mysqli_fetch_all($result, MYSQLI_ASSOC);
      
      if ($result === false) {
          exit("Couldn't execute the query." . mysqli_error($conn));
      }
    }
  }

  if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["save"])) {
    $id = array();
    $cur = array();

    $y_id = $_SESSION['YEAR_ID'];

   foreach ($_POST as $key => $value) {
     if (strstr($key,"id")) {
       array_push($id, $value);
     } 
     elseif (strstr($key,"cur")) {
       if (empty($value)) {
         $value = 0;
       }
      array_push($cur, $value);
     }  
     
   }

 
   /// insert new row in quantity
   for ($i=0; $i < count($id); $i++) { 
     $sql = "SELECT grand_total FROM quantity WHERE c_id = $id[$i] AND y_id = $y_id - 1";

    if ($result = mysqli_query($conn, $sql)) {
      $data = mysqli_fetch_all($result, MYSQLI_ASSOC);

      foreach ($data as $d) {
        $last_year = $d['grand_total'];
      }

      $last_year = empty($last_year) ? 0 : $last_year;

      $sql = "INSERT INTO quantity(last_year, current_year, grand_total, c_id, y_id) 
      VALUES ($last_year, $cur[$i], $last_year + $cur[$i], $id[$i], $y_id)";

      if (mysqli_query($conn, $sql) === false) {
        exit("Couldn't execute the query." . mysqli_error($conn));
      } 
    }
    else {
      exit("Couldn't execute the query." . mysqli_error($conn));
    }

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
            <a href="adminHome.php" class="nav-link font-weight-bolder"><i class="fas fa-users-cog"></i>Dashboard</a>
          </li>

          <li class="nav-item">
            <a href="ddrc.php" class="nav-link font-weight-bolder"><i class="fas fa-list mr-1"></i>DDRC
            </a>
          </li>

          <li class="nav-item">
            <a href="annual_report_start.php" class="nav-link font-weight-bolder active"><i class="fas fa-newspaper mr-1"></i>Annual Report
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
      <div class="home-inner ml-3 mr-3 mb-4">
        <div class="container">
        <div class="card card-body text-dark text-center">

          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
            <div class="row ">
              <div class="text-center col ml-5 ">
                <select class="custom-select text-center bg-secondary text-light" name="p_id">
                  <option value="-1" selected>*** Select Activity ***</option>

                  <?php foreach($rows as $row): ?>
                          
                      <option value="<?php echo $row['id'] ?>"> <?php echo $row['name'] ?> </option>
              
                  <?php endforeach; ?> 
                </select>
              </div>
              <div class="col">
                <input type="submit" class="btn btn-secondary btn-block" name="cat_submit" value="Load">
              </div>  
            </div>    
          </form>

        </div>
        <?php 
        
        // print_r($catRows); 
        
        ?>
        <?php if(isset($catRows)): ?> 
          <div class="card card-body">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
              <div class="table-responsive-sm">
                <table class="table table-dark table-bordered table-hover">
                  <thead>
                    <tr>
                      <td class="text-center">Category</td>
                      <td class="text-center">Current Financial Year</td>
                    </tr>
                  </thead>
                  <tbody>
                    <?php for($i = 0; $i < count($catRows); $i++): ?>

                      <input type="hidden" name="id<?php echo $i; ?>" value="<?php echo $catRows[$i]['id']; ?>">

                      <tr>
                        <td class="text-center"><?php echo ucwords($catRows[$i]["name"]); ?></td>
                      
                        <td class="text-center">
                          <input type="text" class="form-control text-center text-light bg-dark" name="cur<?php echo $i; ?>">
                        </td>
                      </tr>

                    <?php endfor; ?>
                  </tbody>
                </table>
              </div>
            <input type="submit" name="save" class="btn btn-dark" value="Save">
            
            </form>
             
            

          </div>

        <?php endif; ?>

  
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