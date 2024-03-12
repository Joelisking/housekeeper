<?php
error_reporting(E_ALL); ini_set('display_errors', 1);
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
    <title>Add Expense</title>
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
                        <a href="home.php"><i class="fa fa-dashboard"></i>Dashboard</a>
                    </li>
                    <li>
                        <a href="reservation.php"><i class="fa fa-qrcode"></i>Add Booking</a>
                    </li>
                    <li>
                        <a href="payment.php"><i class="fa fa-qrcode"></i>Add Payment</a>
                    </li>
                    <li>
                        <a class="active-menu" href="payment.php"><i class="fa fa-qrcode"></i>Add Expense</a>
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
                            ADD EXPENDITURE
                        </h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                EXPENDITURE
                            </div>
                            <div class="panel-body">
                                <form name="form" method="post">
                                    <div class="form-group">
                                        <label>Amount Spent</label>
                                        <input name="amount" class="form-control" type="number" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <input name="description" class="form-control" type="text" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Date</label>
                                        <input name="date" type="date" class="form-control" required>
                                    </div>
                            </div>
                        </div>
                        <input type="submit" name="submit" class="btn btn-primary">
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $amount = isset($_POST['amount']) ? mysqli_real_escape_string($con, $_POST['amount']) : '';
        $description = isset($_POST['description']) ? mysqli_real_escape_string($con, $_POST['description']) : '';
        $date = isset($_POST['date']) ? mysqli_real_escape_string($con, $_POST['date']) : '';

        $expenditureQuery = "INSERT INTO `expenses`(`Amount`, `Description`, `LoggedBy`, `Date`) VALUES (?, ?, ?, ?)";
        $expenditureStatement = mysqli_prepare($con, $expenditureQuery);

        // Bind variables to the prepared statement as parameters
        $loggedBy = $_SESSION["user"];
        mysqli_stmt_bind_param($expenditureStatement, "dsss", $amount, $description, $loggedBy, $date);

        // Execute the statement
        if (mysqli_stmt_execute($expenditureStatement)) {
            // Successful insertion
            echo "<script type='text/javascript'> alert('Expenditure added successfully')</script>";
        } else {
            // Error in insertion
            echo "<script type='text/javascript'> alert('Error adding expenditure')</script>";
        }

        // Close the statement
        mysqli_stmt_close($expenditureStatement);
    }
    ?>
    </div>
    </div>
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
    <!-- Custom Js -->
    <script src="assets/js/custom-scripts.js"></script>
</body>

</html>