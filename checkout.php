<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("location:index.php");
}
include('db.php');

if (isset($_POST['submit'])) {
    // Sanitize user input
    $roomType = mysqli_real_escape_string($con, $_POST['troom']);
    $status = mysqli_real_escape_string($con, $_POST['status']);

    echo "Room Type: " . $roomType . "<br>";
    echo "Status: " . $status . "<br>";

    // Check if the status is either 'available' or 'reserved'
    if ($status !== 'available' && $status !== 'reserved') {
        echo "<script type='text/javascript'> alert('Invalid status. Status can only be updated to available or reserved.')</script>";
        exit(); // Exit if the status is invalid
    }

    // Check if the room is booked and needs to be checked out
    $checkRoomQuery = "SELECT * FROM room WHERE RoomType = '$roomType' AND Status = 'booked'";
    $checkRoomResult = mysqli_query($con, $checkRoomQuery);

    if (mysqli_num_rows($checkRoomResult) > 0) {
        // Update the room status based on the selected choice
        $updateQuery = "UPDATE room SET Status = '$status' WHERE RoomType = '$roomType'";
        if (mysqli_query($con, $updateQuery)) {
            // Redirect to home page after successful operation
            echo "Room status updated successfully.";
            header("Location: home.php");
            exit(); // Make sure to exit after redirection
        } else {
            echo "<script type='text/javascript'> alert('Error updating room status')</script>";
        }
    } else {
        // Room is not booked, update the status to 'reserved'
        $status = "reserved";
        $updateQuery = "UPDATE room SET Status = '$status' WHERE RoomType = '$roomType'";
        if (mysqli_query($con, $updateQuery)) {
            // Redirect to home page after successful operation
            echo "Room status updated to 'reserved'.";
            header("Location: home.php");
            exit(); // Make sure to exit after redirection
        } else {
            echo "<script type='text/javascript'> alert('Error updating room status')</script>";
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Check Out</title>
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
                        <a class="active-menu" href="checkout.php"><i class="fa fa-qrcode"></i>Check Out</a>
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
                            Check Out
                        </h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-6">


                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                CHECK OUT
                            </div>
                            <div class="panel-body">
                                <form name="form" method="post">
                                    <div class="form-group">
                                        <label>
                                            <h4>Booked Rooms</h4>
                                        </label>
                                        <fieldset>
                                            <div>
                                                <?php
                                                $tsql = "SELECT DISTINCT RoomType, Description FROM room WHERE Status = 'booked'";
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
                                            <h4>Is the room now available?</h4>
                                            <div>
                                                <input type="radio" id="yes" name="status" value="available" />
                                                <label for="yes">Yes</label>
                                                <br>
                                                <input type="radio" id="no" name="status" value="reserved" />
                                                <label for="no">No</label>
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
    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.metisMenu.js"></script>
    <script src="assets/js/custom-scripts.js"></script>
</body>

</html>