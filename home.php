<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
if (!isset($_SESSION["user"])) {
    header("location:index.php");
}
include('db.php')
    ?>
<!DOCTYPE html>


<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Floa Residence</title>
    <!-- Bootstrap Styles-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FontAwesome Styles-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
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
                        <a class="active-menu" href="home.php"><i class="fa fa-dashboard"></i>Dashboard</a>
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
                        <a href="finances.php"><i class="fa fa-qrcode"></i>Financial Information</a>
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
                            Floa Residence Management System
                        </h1>
                    </div>
                </div>
                <!-- /. ROW  -->
                <?php
                include('db.php');
                $sql = "select * from bookings";
                $re = mysqli_query($con, $sql);
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                            </div>
                            <div class="panel-body">

                                <div class="panel-group" id="accordion">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                <a href="reservation.php">
                                                    <button class="btn btn-success" type="button">Add Booking</button>
                                                </a>
                                            </div>
                                        </div>
                                        <div style="height: auto;">
                                            <div class="panel-body">
                                                <div class="panel panel-default">
                                                    <div class="panel-body">
                                                        <div class="table-responsive">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>BookingID</th>
                                                                        <th>Name</th>
                                                                        <th>Phone Number</th>
                                                                        <th>Room Type</th>
                                                                        <th>Check In</th>
                                                                        <th>Check Out</th>
                                                                        <th>Number of Days</th>
                                                                        <th>Payment Status</th>
                                                                        <th>Booked By</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    $tsql = "SELECT * FROM bookings";
                                                                    $tre = mysqli_query($con, $tsql);

                                                                    while ($trow = mysqli_fetch_array($tre)) {
                                                                        echo "<tr>
                                                                        <th>" . $trow['ID'] . "</th>
                                                                        <th>" . $trow['firstName'] . " " . $trow['lastName'] . "</th>
                                                                        <th>" . $trow['phone'] . "</th>
                                                                        <th>" . $trow['roomType'] . "</th>
                                                                        <th>" . $trow['checkIn'] . "</th>
                                                                        <th>" . $trow['checkOut'] . "</th>
                                                                        <th>" . $trow['noOfDays'] . "</th>
                                                                        <th>" . $trow['paymentStatus'] . "</th>
                                                                        <th>" . $trow['bookedBy'] . "</th>
                                                                    </tr>";
                                                                    }
                                                                    ?>
                                                                </tbody>
                                                            </table>

                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End  Basic Table  -->
                                            </div>
                                        </div>

                                        <div class="panel panel-info">
                                            <div class="panel-heading">
                                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                    <h4 class="panel-heading">Booked Rooms</h4>
                                                </div>
                                            </div>
                                            <div id="collapseOne" class="" style="height: 0px;">
                                                <div class="panel-body">
                                                    <?php
                                                    $msql = "SELECT * FROM `room` ";
                                                    $booking = "SELECT * FROM `bookings`";
                                                    $mre = mysqli_query($con, $msql);
                                                    $tre = mysqli_query($con, $booking);

                                                    $hasBookings = false;
                                                    while ($mrow = mysqli_fetch_array($mre)) {

                                                        $br = $mrow['Status'];

                                                        if ($br == "booked") {
                                                            $hasBookings = true;


                                                            echo "<div class='col-md-3 col-sm-12 col-xs-12'>
                                                            <div class='panel panel-primary text-center no-boder bg-color-blue'>
                                                                <div class='panel-body'>
                                                                    <i class='fa fa-users fa-5x'></i>
                                                                    <h3>" . $mrow['Description'] . "</h3>
                                                                </div>
                                                                <div class='panel-footer back-footer-blue'>
                                                                    <a href='checkout.php' >
                                                                    <button class='btn btn-danger'>Check Out</button>
                                                                    </a>
                                                                </div>
                                                            </div>	
                                                        </div>";
                                                        }
                                                    }
                                                    // Display "No Bookings" message if no bookings are found
                                                    if (!$hasBookings) {
                                                        echo "<h3>No Bookings Available</h3>";
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-danger">
                                            <div class="panel-heading">
                                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                    <h4 class="panel-heading">Available Rooms</h4>
                                                </div>
                                            </div>
                                            <div id="collapseThree" class="">

                                                <div class="panel-body">
                                                    <?php
                                                    $msql = "SELECT * FROM `room`";
                                                    $mre = mysqli_query($con, $msql);

                                                    while ($mrow = mysqli_fetch_array($mre)) {
                                                        $br = $mrow['Status'];
                                                        if ($br == "available") {
                                                            echo "<div class='col-md-3 col-sm-12 col-xs-12'>
													<div class='panel panel-primary text-center no-boder bg-color-blue'>
														<div class='panel-body'>
															<i class='fa fa-users fa-5x'></i>
															<h3>" . $mrow['Description'] . "</h3>
														</div>
													</div>	
											</div>";
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="panel panel-primary">
                                            <div class="panel-heading">
                                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                    <h4 class="panel-heading">Reserved Rooms</h4>
                                                </div>
                                            </div>
                                            <div id="collapseThree" class="">

                                                <div class="panel-body">
                                                    <?php
                                                    $msql = "SELECT * FROM `room`";
                                                    $mre = mysqli_query($con, $msql);

                                                    while ($mrow = mysqli_fetch_array($mre)) {
                                                        $br = $mrow['Status'];
                                                        if ($br == "reserved") {
                                                            echo "<div class='col-md-3 col-sm-12 col-xs-12'>
													<div class='panel panel-primary text-center no-boder bg-color-blue'>
														<div class='panel-body'>
															<i class='fa fa-users fa-5x'></i>
															<h3>" . $mrow['Description'] . "</h3>
														</div>
													</div>	
											</div>";
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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