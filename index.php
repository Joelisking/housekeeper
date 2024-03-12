<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

if (isset($_SESSION["user"])) {
    header("location:home.php");
    exit; // Ensure to stop further execution after redirection
}

include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $myusername = mysqli_real_escape_string($con, $_POST['user']);
    $mypassword = mysqli_real_escape_string($con, $_POST['pass']);

    $sql = "SELECT id FROM login WHERE usname = '$myusername' AND pass = '$mypassword'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);

    if ($count == 1) {
        $_SESSION['user'] = $myusername;
        header("location: home.php");
        exit; // Add this line to stop further execution
    } else {
        echo '<script>alert("Your Login Name or Password is invalid") </script>';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>FLOA RESIDENCE ADMIN</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div id="clouds">
        <div class="cloud x1"></div>
        <!-- Time for multiple clouds to dance around -->
        <div class="cloud x2"></div>
        <div class="cloud x3"></div>
        <div class="cloud x4"></div>
        <div class="cloud x5"></div>
    </div>

    <div class="container">
        <div id="login">
            <form method="post">
                <fieldset class="clearfix">
                    <p><span class="fontawesome-user"></span><input type="text" name="user" value="Username" onBlur="if(this.value == '') this.value = 'Username'" onFocus="if(this.value == 'Username') this.value = ''" required></p>
                    <!-- JS because of IE support; better: placeholder="Username" -->
                    <p><span class="fontawesome-lock"></span><input type="password" name="pass" value="Password" onBlur="if(this.value == '') this.value = 'Password'" onFocus="if(this.value == 'Password') this.value = ''" required></p>
                    <!-- JS because of IE support; better: placeholder="Password" -->
                    <p><input type="submit" name="sub" value="Login"></p>
                </fieldset>
            </form>
        </div> <!-- end login -->
    </div>
</body>
</html>
