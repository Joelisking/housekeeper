<?php
error_reporting(E_ALL); ini_set('display_errors', 1);
session_start();
if (!isset($_SESSION["user"])) {
    header("location:index.php");
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Finances </title>
    <!-- Bootstrap Styles-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FontAwesome Styles-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- Morris Chart Styles-->
    <link href="assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
    <!-- Custom Styles-->
    <link href="assets/css/custom-styles.css" rel="stylesheet" />
    <!-- Google Fonts-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>

<body>
    <div id="wrapper">
        <nav class="navbar navbar-default top-navbar" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="home.php">
                    <?php echo $_SESSION["user"]; ?>
                </a>
            </div>
            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="usersetting.php"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="settings.php"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
        </nav>
        <!-- /. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                    <li>
                        <a href="home.php"><i class="fa fa-dashboard"></i>Dashboard</a>
                    </li>
                    <li>
                        <a href="reservation.php"><i class="fa fa-qrcode"></i>Add Booking</a>
                    </li>
                    <li>
                        <a href="payment.php"><i class="fa fa-qrcode"></i>Add Payment</a>
                    </li>
                    <li>
                        <a href="expenditure.php"><i class="fa fa-qrcode"></i>Add Expense</a>
                    </li>
                    <li>
                        <a href="update.php"><i class="fa fa-qrcode"></i>Update Room Status</a>
                    </li>
                    <li>
                        <a href="checkout.php"><i class="fa fa-qrcode"></i>Check Out</a>
                    </li>
                    <li>
                        <a class="active-menu" href="finances.php"><i class="fa fa-qrcode"></i>Financial Information</a>
                    </li>
                    <li>
                        <a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                            Financial Information
                        </h1>
                    </div>
                </div>
                <!-- /. ROW  -->
                <?php
                include('db.php');
                $sql = "select * from roombook";
                $re = mysqli_query($con, $sql);
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div style="height: auto;">
                                <div class="panel-heading">
                                    <h3 class="panel-heading">Income</h3>
                                </div>
                                <div class="panel-body">
                                    <div class="panel panel-default">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Customer Name</th>
                                                        <th>Amount Paid</th>
                                                        <th>Payment Method</th>
                                                        <th>Payment Status</th>
                                                        <th>Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $tsql = "SELECT * FROM income ORDER BY Date DESC"; // Order by Date to show the latest records first
                                                    $tre = mysqli_query($con, $tsql);
                                                    
                                                    

                                                    $currentMonth = ''; // Variable to track the current month
                                                    
                                                    while ($trow = mysqli_fetch_array($tre)) {
                                                        $date = $trow['Date'];
                                                        $month = date('F Y', strtotime($date));

                                                        // Check if the month has changed
                                                        if ($currentMonth != $month) {
                                                            echo "<tr class='info'>
                                                                                <th colspan='5'>$month</th>
                                                                            </tr>";
                                                            $currentMonth = $month;
                                                        }
                                                        echo "<tr>
                                                                <th>" . $trow['CustomerName'] . "</th>
                                                                <th>" . $trow['AmountPaid'] . "</th>
                                                                <th>" . $trow['PaymentMethod'] . "</th>
                                                                <th>" . $trow['PaymentStatus'] . "</th>
                                                                <th>" . $trow['Date'] . "</th>
                                                            </tr>";
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>


                                <div class="panel-heading">
                                    <h3 class="panel-heading"> Expenditure</h3>
                                </div>
                                <div class="panel-body">
                                    <div class="panel panel-default">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Amount</th>
                                                        <th>Description</th>
                                                        <th>Logged By</th>
                                                        <th>Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $tsql = "SELECT * FROM expenses ORDER BY Date DESC"; // Order by Date to show the latest records first
                                                    $tre = mysqli_query($con, $tsql);

                                                    $currentMonth = ''; // Variable to track the current month
                                                    
                                                    while ($trow = mysqli_fetch_array($tre)) {
                                                        $date = $trow['Date'];
                                                        $month = date('F Y', strtotime($date));

                                                        // Check if the month has changed
                                                        if ($currentMonth != $month) {
                                                            echo "<tr class='info'>
                                                                                <th colspan='5'>$month</th>
                                                                            </tr>";
                                                            $currentMonth = $month;
                                                        }
                                                        echo "<tr>
                                                                            <th>" . $trow['Amount'] . " </th>
                                                                            <th>" . $trow['Description'] . "</th>
                                                                            <th>" . $trow['LoggedBy'] . "</th>
                                                                            <th>" . $trow['Date'] . "</th>
                                                                        </tr>";
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- End  Basic Table  -->
                                <div class="panel-heading">
                                    <h3 class="panel-heading">Monthly Summary</h3>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Year</th>
                                                        <th>Month</th>
                                                        <th>Monthly Income</th>
                                                        <th>Monthly Expenditure</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $monthlyTotalQuery = "SELECT YEAR(f.Date) AS Year, DATE_FORMAT(f.Date, '%M') AS Month, 
                                                    SUM(f.AmountPaid) AS TotalAmount,
                                                    COALESCE(SUM(e.Amount), 0) AS TotalExpenditure
                                                    FROM income f
                                                    LEFT JOIN expenses e ON YEAR(f.Date) = YEAR(e.Date) AND MONTH(f.Date) = MONTH(e.Date)
                                                    GROUP BY Year, Month
                                                    ORDER BY f.Date DESC";

                                                    $monthlyTotalResult = mysqli_query($con, $monthlyTotalQuery);

                                                    while ($monthlyTotalRow = mysqli_fetch_array($monthlyTotalResult)) {
                                                        echo "<tr>
            <th>" . $monthlyTotalRow['Year'] . "</th>
            <th>" . $monthlyTotalRow['Month'] . "</th>
            <th>" . $monthlyTotalRow['TotalAmount'] . "</th>
            <th>" . $monthlyTotalRow['TotalExpenditure'] . "</th>
          </tr>";
                                                    }
                                                    ?>


                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                        <!-- /. ROW  -->
                    </div>
                    <!-- /. PAGE INNER  -->
                </div>
                <!-- /. PAGE WRAPPER  -->
            </div>
            <!-- /. WRAPPER  -->
            <!-- JS Scripts-->
            <!-- jQuery Js -->
            <script src="assets/js/jquery-1.10.2.js"></script>
            <!-- Bootstrap Js -->
            <script src="assets/js/bootstrap.min.js"></script>
            <!-- Metis Menu Js -->
            <script src="assets/js/jquery.metisMenu.js"></script>
            <!-- Morris Chart Js -->
            <script src="assets/js/morris/raphael-2.1.0.min.js"></script>
            <script src="assets/js/morris/morris.js"></script>
            <!-- Custom Js -->
            <script src="assets/js/custom-scripts.js"></script>
</body>

</html>