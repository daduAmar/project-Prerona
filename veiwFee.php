<?php
    session_start();
    require_once "includes/connect.php";

    if(!isset($_SESSION['username'])){
      header("Location: index.php");
    }

    if(isset($_GET['s_id'])){

      $std_id = $_GET['s_id'];

      $sql="SELECT DISTINCT(feeMonth) FROM stdPaidFees WHERE std_Id= $std_id";

      $results = mysqli_query($conn, $sql)
      or die("Error in fetching records");
  
      $feeMons = mysqli_fetch_all($results, MYSQLI_ASSOC);
  
  
      if ($results === false) {
  
      exit("Couldn't execute the query." . mysqli_error($conn));
  
      }
  
      $sql="SELECT DISTINCT(feeYear) FROM stdPaidFees WHERE std_Id= $std_id";
  
      $results = mysqli_query($conn, $sql)
      or die("Error in fetching records");
  
      $feeYrs = mysqli_fetch_all($results, MYSQLI_ASSOC);
  
      
  
      if ($results === false) {
  
      exit("Couldn't execute the query." . mysqli_error($conn));
  
      }
    }

    if (isset($_GET['search'])) {
      // get s_id
      // get year and month
      $std_id = $_GET['s_id'];
      $month = $_GET['month'];
      $year = $_GET['year'];

      if($month == "***Choose Month***"){
        $month = "";
      }

      if($year == "***Choose Year***"){
        $year= "";
      }

      if(!empty($month) && !empty($year)) {
        // both year and month seleted

        $sql = "SELECT monthlyFee.feeType, paidFee, payDate FROM stdPaidFees, monthlyFee WHERE std_Id = '$std_id' AND stdPaidFees.mFee_Id = monthlyFee.mFee_Id AND feeMonth = '$month' AND feeYear = '$year'";

        $results = mysqli_query($conn, $sql)
        or die("Error in fetching records");

        $feeRows = mysqli_fetch_all($results, MYSQLI_ASSOC);

        
        if ($results === false) {

          exit("Couldn't execute the query." . mysqli_error($conn));
        
        }
      }
      elseif(!empty($month)) {
        // only month selected
        $sql = "SELECT monthlyFee.feeType, paidFee, payDate FROM stdPaidFees, monthlyFee WHERE std_Id = '$std_id' AND stdPaidFees.mFee_Id = monthlyFee.mFee_Id AND feeMonth = '$month'";  
        
        $results = mysqli_query($conn, $sql)
        or die("Error in fetching records");

        $feeRows = mysqli_fetch_all($results, MYSQLI_ASSOC);

        if ($results === false) {

          exit("Couldn't execute the query." . mysqli_error($conn));
        
        }
      }
      elseif(!empty($year)) {
          // only year selected
          $sql = "SELECT monthlyFee.feeType, paidFee, payDate FROM stdPaidFees, monthlyFee WHERE std_Id = $std_id AND stdPaidFees.mFee_Id = monthlyFee.mFee_Id AND feeYear = '$year'";   

          $results = mysqli_query($conn, $sql)
          or die("Error in fetching records");

          $feeRows = mysqli_fetch_all($results, MYSQLI_ASSOC);

          if ($results === false) {

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
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="CSS/bootstrap.min.css" > 
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
  <title>feeView</title>
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
            <a href="adminHome.php" class="nav-link">Dashboard</a>
          </li>
          <li class="nav-item px-2">
            <a href="std_dtls.php" class="nav-link"> Student Registration </a>
          </li>
          <li class="nav-item px-2">
            <a href="ddrc.php" class="nav-link">DDRC</a>
          </li>
          <li class="nav-item px-2">
          <a href="studentsView.php" class="nav-link">Student Details</a>
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

  <!-- SEARCH -->
  <section id="search" class="p-3 bg-light">
    <div class="container">
      
      <div class="row">
      <p class="font-italic text-muted">Please Choose Month/Year Or Both To View Fees </p>
        <div class="col-md-6 ml-auto">
        <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="get">
            <div class="row mb-3">
              <div class="col">
                <select name="month" class="custom-select">
                  <option>***Choose Month***</option>
                  <?php foreach ($feeMons as $feeMon): ?>
               
                  <option value="<?php echo $feeMon['feeMonth']; ?>"> <?php echo $feeMon['feeMonth']; ?> </option>

                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col" >
                <select class="custom-select" name="year">
                    <option>***Choose Year***</option>
                    <?php foreach ($feeYrs as $feeYr): ?>
              
                      <option value="<?php echo $feeYr['feeYear']; ?>"> <?php echo $feeYr['feeYear']; ?> </option>

                    <?php endforeach; ?>
                </select>
              </div>
                
              <input type="hidden" name="s_id" value="<?php echo $std_id; ?>">
              <div class="col">
                <input type="submit" class="btn btn-secondary mb-1" name="search" value="Go">
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <!-- USERS -->
  <section id="fees">
    <div class="container mt-4" id="reciept">
      <div class="card card-body  shadow-lg p-4 rounded" >
        <h5 class="card-title text-center font-weight-bolder">View Monthly Fee</h5>
        <?php 
          if (isset($_GET['search'])):
          $feeDate = $feeRows[0]["payDate"];  
        ?>
        
        <div class="text-right font-weight-bold text-monospace">Date:
        <?php echo $feeDate; ?></div>


        <?php endif; ?>
          <table class="table table-striped">
            <thead class="thead-dark">
              <tr>
                <th class="text-center">Fee Type</th>
                <th class="text-center">Fee Amount</th>
              </tr>  
            </thead>
            <tbody>
            <?php if (isset($_GET['search'])):  ?>
            <?php foreach($feeRows as $feeRow): ?>
              <tr>
                <td class="text-center"><?php echo ucwords($feeRow["feeType"]); ?></td>
                <td class="text-center"><?php echo $feeRow["paidFee"]; ?></td>
              </tr>
            <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
          </table>   
          </div>
          
        </div> 
         <div class="mr-4 text-center">
         <button class="btn btn-dark mt-2">Print Monthly Fee Reciept</button> 
         </div>
      </div> 
    </div>   
  </section>
  
  <br>
  <!-- Footer -->
  <?php require "includes/footer.php"; ?>
  
  <!-- bootstrap script -->
  <script src="JS/bootstrapJquery.js"></script>
  <script src="JS/popper.min.js"></script>
  <script src="JS/bootstrap.min.js"></script>
  <script type="text/javascript">
  $(document).ready(function(){
          
    $("button").click(function(){
  
    var data = $("#reciept").html();
    var mywindow = window.open("", "", 'height=500,width=800');
        
    mywindow.document.write("<!doctype html>");
    mywindow.document.write('<html lang="en"><head><title>feeView</title>');
    mywindow.document.write("<meta charset='utf-8'>");
    mywindow.document.write("<meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>");
    mywindow.document.write("<link rel='stylesheet' href='CSS/bootstrap.min.css' >");
    mywindow.document.write('</head><body >');
    
    mywindow.document.write("<div class='container'>");
    mywindow.document.write("<div class='container'><h2>Monthly Fee Reciept</h2></div>");
    mywindow.document.write("<hr>");
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