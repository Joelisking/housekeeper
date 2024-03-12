<?php
error_reporting(E_ALL); ini_set('display_errors', 1);
session_start();
if (!isset($_SESSION["user"])) {
    header("location:index.php");
}
include('db.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Escape user inputs for security
    $cname = isset($_POST['cname']) ? mysqli_real_escape_string($con, $_POST['cname']) : '';
    $amount = isset($_POST['amount']) ? mysqli_real_escape_string($con, $_POST['amount']) : '';
    $payment = isset($_POST['payment']) ? mysqli_real_escape_string($con, $_POST['payment']) : '';
    $date = isset($_POST['date']) ? mysqli_real_escape_string($con, $_POST['date']) : '';
    $status = isset($_POST['status']) ? mysqli_real_escape_string($con, $_POST['status']) : '';

    // Prepare an insert statement
    $paymentQuery = "INSERT INTO `income`(`CustomerName`, `AmountPaid`, `PaymentMethod`,`PaymentStatus`, `Date`) VALUES (?, ?, ?, ?, ?)";
    $paymentStatement = mysqli_prepare($con, $paymentQuery);

    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($paymentStatement, "sisss", $cname, $amount, $payment, $status, $date);

    // Execute the statement
    if (mysqli_stmt_execute($paymentStatement)) {
        // Successful insertion
        echo "<script type='text/javascript'> alert('Payment confirmed')</script>";
    } else {
        // Error in financials insertion
        echo "<script type='text/javascript'> alert('Error adding financials record in database')</script>";
    }

    // Close the statement
    mysqli_stmt_close($paymentStatement);
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add Payment</title>
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
            <!-- NAV TOP -->
            <!-- NAV TOP -->
        </nav>
        <!-- /. NAV TOP  -->
        <!-- NAV TOP  -->
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
                        <a class="active-menu" href="payment.php"><i class="fa fa-qrcode"></i>Add Payment</a>
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
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                            ADD PAYMENT
                        </h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                PAYMENT INFORMATION
                            </div>
                            <div class="panel-body">
                                <form name="form" method="post">
                                    <div class="form-group">
                                        <label>Customer Name</label>
                                        <input name="cname" class="form-control" type="text" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Amount Paid</label>
                                        <input name="amount" class="form-control" type="number" required>
                                    </div>
                                    <div class="form-group" required>
                                        <fieldset>
                                            <h5>Payment Method</h5>
                                            <div>
                                                <input type="radio" id="cash" name="payment" value="Momo" />
                                                <label for="inspected1">Mobile Money</label>
                                                <br>
                                                <input type="radio" id="inspected2" name="payment" value="Cash" />
                                                <label for="inspected2">Cash</label>
                                                <br>
                                                <input type="radio" id="inspected2" name="payment" value="Card" />
                                                <label for="inspected2">Card</label>
                                                <br>
                                                <br>
                                            </div>
                                        </fieldset>

                                        <div class="form-group">
                                            <label>Date</label>
                                            <input name="date" type="date" class="form-control" required>
                                        </div>
                                        <div class="form-group" required>
                                            <fieldset>
                                                <h5>Payment Status</h5>
                                                <div>
                                                    <input type="radio" id="cash" name="status" value="Full" />
                                                    <label for="inspected1">Full Payment</label>
                                                    <br>
                                                    <input type="radio" id="inspected2" name="status" value="Part" />
                                                    <label for="inspected2">Part Payment</label>
                                                    <br>

                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="form-group">
                                            <h5>Enter if part payment</h5>
                                            <label>Balance</label>
                                            <input name="balance" class="form-control" type="number">
                                        </div>
                                        <input type="submit" name="submit" class="btn btn-primary">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /. PAGE WRAPPER  -->
    <!-- /. WRAPPER  -->
    <!-- JS Scripts-->
    <!-- jQuery Js -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- Bootstrap Js -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- Metis Menu Js -->
    <script src="assets/js/jquery.metisMenu.js"></script>
    <!-- Custom Js -->
    <script src="assets/js/custom-scripts.js"></script>
</body>

</html>