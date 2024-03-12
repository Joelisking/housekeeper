<?php
// error_reporting(E_ALL); ini_set('display_errors', 1);
session_start();
if (!isset($_SESSION["user"])) {
    header("location:index.php");
}
include('db.php');

if (isset($_POST['submit'])) {
    // Sanitize user input
    $roomType = mysqli_real_escape_string($con, $_POST['troom']);
    $status = mysqli_real_escape_string($con, $_POST['status']);

    // Check if the room is booked and needs to be checked out
    $checkRoomQuery = "SELECT * FROM room WHERE RoomType = '$roomType' AND Status = 'reserved'";
    $checkRoomResult = mysqli_query($con, $checkRoomQuery);

    if (mysqli_num_rows($checkRoomResult) > 0) {
        // Update the room status to 'available'
        $updateQuery = "UPDATE room SET Status = '$status' WHERE RoomType = '$roomType'";
        if (mysqli_query($con, $updateQuery)) {
            // Redirect to home page after successful checkout
        } else {
            echo "<script type='text/javascript'> alert('Error updating status')</script>";
        }
    } else {
        echo "<script type='text/javascript'> alert('Selected room is not booked')</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Update Room</title>
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
                        <a class="active-menu" href="update.php"><i class="fa fa-qrcode"></i>Update Room Status</a>
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

        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                            Update Room
                        </h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-6">


                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                RESERVATION INFORMATION
                            </div>
                            <div class="panel-body">
                                <form name="form" method="post">
                                    <div class="form-group">
                                        <label>
                                            <h4>Reserved Rooms</h4>
                                        </label>
                                        <fieldset>
                                            <div>
                                                <?php
                                                $tsql = "SELECT DISTINCT RoomType, Description FROM room WHERE Status = 'reserved'";
                                                $tre = mysqli_query($con, $tsql);
                                                while ($trow = mysqli_fetch_array($tre)) {
                                                    echo "<input type='radio' id='contactChoice1' name='troom' value=" . $trow['RoomType'] . " />
                                                    <label for='contactChoice1'>" . $trow['Description'] . "</label> <br>";
                                                }
                                                ?>
                                            </div>
                                        </fieldset>
                                    </div>

                                    <div class="form-group">
                                        <fieldset>
                                            <h4>Confirm Booking</h4>
                                            <div>
                                                <input type="radio" id="yes" name="status" value="booked" />
                                                <label for="yes">Confirm Booking</label>
<br>
                                                <input type="radio" id="no" name="status" value="available" />
                                                <label for="no">Cancel Booking</label>
                                            </div>
                                        </fieldset>
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
    <!-- JS Scripts -->
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