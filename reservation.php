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
    <title>Add Reservation</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/custom-styles.css" rel="stylesheet" />
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

                </li>

            </ul>
        </nav>

        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                    <li>
                        <a href="home.php"><i class="fa fa-dashboard"></i>Dashboard</a>
                    </li>
                    <li>
                        <a class="active-menu" href="reservation.php"><i class="fa fa-qrcode"></i>Add Booking</a>
                    </li>
                    <li>
                        <a href="payment.php"><i class="fa fa-qrcode"></i>Add Payment</a>
                    </li>
                    <li>
                        <a href="payment.php"><i class="fa fa-qrcode"></i>Add Expense</a>
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

        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                            ADD BOOKING
                        </h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                BOOKING INFORMATION
                            </div>
                            <div class="panel-body">
                                <form name="form" method="post">
                                    <div class="form-group">
                                        <label>First Name</label>
                                        <input name="firstName" class="form-control" type="text" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <input name="lastName" class="form-control" type="text" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Phone Number</label>
                                        <input name="phone" class="form-control" type="number" required>
                                    </div>
                                    <!--<div class="form-group">-->
                                    <!--    <label>Room Type</label>-->
                                    <!--    <input name="roomType" type="text" class="form-control" required>-->
                                    <!--</div>-->

                                    <div class="form-group">
                                        <label>Type Of Room Available</label>
                                        <fieldset>
                                            <div>
                                                <?php
                                                $tsql = "SELECT DISTINCT RoomType, Description FROM room WHERE Status = 'available'";
                                                $tre = mysqli_query($con, $tsql);
                                                while ($trow = mysqli_fetch_array($tre)) {
                                                    echo "<input type='radio' id='rooms' name='roomType' value=" . $trow['RoomType'] . " />
                                                    <label for='rooms'>" . $trow['Description'] . "</label> <br>";
                                                }
                                                ?>
                                            </div>
                                        </fieldset>
                                    </div>

                                    <div class="form-group">
                                        <label>Check In</label>
                                        <input name="checkIn" type="date" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Check Out</label>
                                        <input name="checkOut" type="date" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Payment Status</label>
                                        <fieldset>
                                            <div>
                                                <input type="radio" id="yes" name="paymentStatus" value="Paid" />
                                                <label for="yes">Paid</label>
                                                <br>
                                                <input type="radio" id="no" name="paymentStatus" value="Not_Paid" />
                                                <label for="no">Not Paid</label>
                                            </div>
                                        </fieldset>
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
        $fName = isset($_POST['firstName']) ? mysqli_real_escape_string($con, $_POST['firstName']) : '';
        $lName = isset($_POST['lastName']) ? mysqli_real_escape_string($con, $_POST['lastName']) : '';
        $phone = isset($_POST['phone']) ? mysqli_real_escape_string($con, $_POST['phone']) : '';
        $roomType = isset($_POST['roomType']) ? mysqli_real_escape_string($con, $_POST['roomType']) : '';
        $checkIn = isset($_POST['checkIn']) ? mysqli_real_escape_string($con, $_POST['checkIn']) : '';
        $checkOut = isset($_POST['checkOut']) ? mysqli_real_escape_string($con, $_POST['checkOut']) : '';
        $payment_status = isset($_POST['paymentStatus']) ? mysqli_real_escape_string($con, $_POST['paymentStatus']) : '';
        $nodays = max((strtotime($checkOut) - strtotime($checkIn)) / (60 * 60 * 24), 0);

        if ($nodays == 0) {
            // Invalid check-in/check-out dates
            echo "<script type='text/javascript'> alert('Invalid check-in/check-out dates')</script>";
        } else {
            $expenditureQuery = "INSERT INTO `bookings`(`firstName`, `lastName`,`phone`, `roomType`,`checkIn`,`checkOut`, `noOfDays`, `paymentStatus`, `bookedBy`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $expenditureStatement = mysqli_prepare($con, $expenditureQuery);

            // Bind variables to the prepared statement as parameters
            $loggedBy = $_SESSION["user"];
            mysqli_stmt_bind_param($expenditureStatement, "ssssssiss", $fName, $lName, $phone, $roomType, $checkIn, $checkOut, $nodays, $payment_status, $_SESSION['user']);

            // Execute the statement
            if (mysqli_stmt_execute($expenditureStatement)) {
                // // Update room status based on payment status
                if ($payment_status == "Paid") {
                    $updateRoomQuery = "UPDATE room SET Status = 'booked' WHERE RoomType = ?";
                } else {
                    $updateRoomQuery = "UPDATE room SET Status = 'reserved' WHERE RoomType = ?";
                }

                $updateRoomStatement = mysqli_prepare($con, $updateRoomQuery);
                mysqli_stmt_bind_param($updateRoomStatement, 's', $roomType);
                mysqli_stmt_execute($updateRoomStatement);
                mysqli_stmt_close($updateRoomStatement);
                // Successful insertion
                echo "<script type='text/javascript'> alert('Room Booking added successfully')</script>";
                header("Location: home.php");
                exit(); // Make sure to exit after redirection
            } else {
                // Error in insertion
                echo "<script type='text/javascript'> alert('Error adding expenditure')</script>";
            }

            // Close the statement
            mysqli_stmt_close($expenditureStatement);
        }
    }
    ?>
    </div>
    </div>
    </div>
    </div>
    </div>
    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.metisMenu.js"></script>
    <script src="assets/js/custom-scripts.js"></script>
</body>

</html>