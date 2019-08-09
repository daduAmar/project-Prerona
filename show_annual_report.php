<?php
    session_start();
    include_once "includes/connect.php";

    if(!isset($_SESSION['username'])){
        header("Location: preronaHome.php");
    }

    if (isset($_GET['search']) && isset($_SESSION['years'])) {
        $y_id = $_GET['y_id'];

        foreach($_SESSION['years'] as $year) {
            if (array_search($y_id, $year)) {
                $year_data = $year;
                break;
            }
        }

        // fetch activities
        $sql = "SELECT * FROM parentCategory";

        $data = array();
        $colTotal = array();


        if ($result = mysqli_query($conn, $sql)) {
            $activities = mysqli_fetch_all($result, MYSQLI_ASSOC);

            foreach ($activities as $activity) {
                $sql = "SELECT last_year, current_year, grand_total, category.name FROM quantity, category WHERE quantity.c_id IN (SELECT id FROM category WHERE p_id = $activity[id]) AND quantity.c_id = category.id AND quantity.y_id = $y_id";

                //total col query
                $sql1 ="SELECT SUM(last_year) AS last, SUM(current_year) AS current, SUM(grand_total) AS grand FROM quantity WHERE quantity.c_id IN (SELECT id FROM category WHERE p_id = $activity[id]) AND quantity.y_id = $y_id";

                if ($result = mysqli_query($conn, $sql)) {
                    $allActivityrows = mysqli_fetch_all($result, MYSQLI_ASSOC);

                    $data[] = $allActivityrows;
                }
                else {
                    // error
                }

                if ($results = mysqli_query($conn, $sql1)) {
                    $colTotalRows = mysqli_fetch_all($results, MYSQLI_ASSOC);

                    $colTotal[] = $colTotalRows;
                }
                else {
                    // error
                }
            }

        }
        else {
            // error
        }

        
    }
    else {
        $sql = "SELECT * FROM year";

        if ($result = mysqli_query($conn, $sql)) {
            $_SESSION['years'] = mysqli_fetch_all($result, MYSQLI_ASSOC);
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
  <link rel="stylesheet" href="CSS/annual_report1.css">
  <title>Annual Report</title>
</head>
   
<body>
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
            <a href="annual_report_start.php" class="nav-link font-weight-bolder"><i class="fas fa-newspaper mr-1"></i>Annual Report
            </a>
          </li>  

          <li class="nav-item">
            <a href="show_annual_report.php" class="nav-link active font-weight-bolder">
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
            <div class="card card-body card-form text-dark text-center">
                <p class="font-italic text-muted">Please select a year to view annual report...</p>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">

                    <div class="input-group">  
                        <select name="y_id" class="custom-select custom-select-sm text-dark">
                            <option value="-1" selected>*** Select Year ***</option>

                            <?php foreach($_SESSION['years'] as $year): ?>
                                        
                                <option value="<?php echo $year['id'] ?>"> <?php echo $year['year'] ?> </option>
                            
                            <?php endforeach; ?> 
                        </select>
                        <div class="input-group-append">
                            <input type="submit" name="search" class="btn btn-secondary btn-sm" value="View">
                        </div>    
                    </div>
                </form>

            </div>
            <?php

            if(isset($_GET['search'])){
                // fetch from year table
                $sql = "SELECT * FROM year WHERE id = $y_id";

                if ($result = mysqli_query($conn, $sql)) {
                    $yr_Rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

                    foreach($yr_Rows as $yr_Row){

                    }
                    
                }else{
                    //error
                }
            }    

            ?>
            <?php if(isset($allActivityrows) && isset($colTotalRows)): ?>
            <?php 
            
            // print_r($colTotal); 

            // print_r(sizeof($colTotal));
            
            ?>
            <div id="report-print">
                <div class="card card-body card-form text-dark mb-3">
                    <h5 class="card-title text-center mb-4 bg-dark p-2 text-light font-weight-bolder">ANNUAL PERFORMANCE REPORT</h5>
                    <form>
                        <div class="row">
                            <div class="form-group col-sm-6 offset-sm-3 text-center">
                                <label for="agency">Annual Performance Report For The Year</label>
                                <input type="text" class="form-control text-center rounded-pill" id="year" value="<?php echo $yr_Row['year']; ?>">
                            </div>
                        </div>    
                        <div class="row">
                            <div class="form-group col text-center">
                                <label for="agency">Name of the implementing agency</label>
                                <input type="text" class="form-control text-center rounded-pill" value="<?php echo $yr_Row['agency']; ?>">
                            </div>

                            <div class="form-group col text-center">
                                <label for="address">Name of DDRC and address</label>
                                <input type="text" class="form-control text-center rounded-pill" value="<?php echo $yr_Row['address']; ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col text-center">
                                <label for="month">Month of inception</label>
                                <input type="text" class="form-control text-center rounded-pill" value="<?php echo $yr_Row['month']; ?>">
                            </div>

                            <div class="form-group col text-center">
                                <label for="person">Total no of person benifieted up to the...</label>
                                <input type="number" class="form-control text-center rounded-pill" value="<?php echo $yr_Row['total_person_benefit']; ?>">
                            </div>
                        </div>
                    <div class="form-group text-center">
                        <label for="yr_quater">During the current year quater...</label>
                        <input type="text" class="form-control text-center rounded-pill" value="<?php echo $yr_Row['cur_yr_quater']; ?>">
                    </div>
                    </form>
                </div>

                <?php for($i=0; $i < sizeof($data); $i++): ?>
                <div class="card card-form mb-3">
                    <div class="card-header bg-dark text-center text-light">
                        <h5 class="font-weight-bolder"><?php echo ucwords($activities[$i]['name']); ?> </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive-sm">
                            <table class="table table-bordered table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                <td class="text-center font-weight-bold">Category</td>
                                <td class="text-center font-weight-bold">Upto Last Financial Year</td>
                                <td class="text-center font-weight-bold">Current Financial Year</td>
                                <td class="text-center font-weight-bold">Grand Total</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($data[$i] as $dt[$i]): ?>
                                    <tr>
                                        <td class="text-center"><?php echo $dt[$i]['name']; ?></td>
                                        <td class="text-center"><?php echo $dt[$i]['last_year']; ?></td>
                                        <td class="text-center"><?php echo $dt[$i]['current_year']; ?></td>
                                        <td class="text-center"><?php echo $dt[$i]['grand_total']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                <?php foreach($colTotal[$i] as $ct[$i]): ?>
                                <tr>
                                    <td class="text-center">Total</td>
                                    <td class="text-center"><?php echo $ct[$i]['last']; ?></td>
                                    <td class="text-center"><?php echo $ct[$i]['current']; ?></td>
                                    <td class="text-center"><?php echo $ct[$i]['grand']; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            </table>
                        </div>
                    </div>    
                </div>

                <?php endfor; ?>   
            </div>     
            <?php endif; ?>
            <div class="mr-4 mb-2 card-form text-right">
                <button class="btn btn-secondary rounded-pill px-5 mt-2" id="btn">Print</button> 
            </div>
        </div>
      </div>
    </div>
  </header>
  
  <!-- scripts -->
  <script src="JS/bootstrapJquery.js"></script>
  <script src="JS/popper.min.js"></script>
  <script src="JS/bootstrap.min.js"></script>
  <script type="text/javascript">
  $(document).ready(function(){
          
    $("#btn").click(function(){
  
    var data = $("#report-print").html();
    var mywindow = window.open("", "", 'height=500,width=800');
        
    mywindow.document.write("<!doctype html>");
    mywindow.document.write('<html lang="en"><head><title></title>');
    mywindow.document.write("<meta charset='utf-8'>");
    mywindow.document.write("<meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>");
    mywindow.document.write("<link rel='stylesheet' href='CSS/bootstrap.min.css'>");
    mywindow.document.write('</head><body >');
    
    mywindow.document.write("<div class='card card-body card-form text-dark'>");
    mywindow.document.write(data);
    mywindow.document.write("</div>");
    mywindow.document.write('</body></html>');
    mywindow.print();
    mywindow.close();

    });

});    
</script>
</body>

</html>
