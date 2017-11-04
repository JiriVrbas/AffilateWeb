<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once "../scripts/myjquery.php";

include_once '../models/user.php';
include_once '../includes/dbh.inc.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <script src="../scripts/jquery-1.12.0.min.js"></script>
    <script src="../scripts/jquery-migrate-1.2.1.min.js"></script>
</head>
<body>
<?php
if(isset($_GET['link'])){
    $_SESSION['come_link'] = $_GET['link'];
}
?>
<header>
    <nav>
        <div class="main-wrapper">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="affilatePartners.php">Affilate partners</a></li>
                <li><a href="howItWorks.php">How it works</a></li>
                <li><a href="contact.php">Contact</a></li>
                <?php
                if(isset($_SESSION['u_id'])){
                ?>
                <li class="dropdown">
                    <button class="dropbtn">User management</button>
                    <div class="dropdown-content">
                        <a href="myRegisteredUsers.php">My registered users</a><br>
                        <a href="earnings.php">Earnings</a><br>
                        <a href="mySettings.php">My settings</a><br>
                        <form action="../includes/logout.inc.php" method="post">
                            <button type="submit" name="submit">Logout</button>
                        </form>
                    </div>
                </li>
                <?php
                }
                ?>
            </ul>
            <div class="nav-login">
                <?php
                if(!isset($_SESSION['u_id'])){?>
                    <form action="../includes/login.inc.php" method="post">
                        <input type="text" name="uid" placeholder="Username/email">
                        <input type="password" name="pwd" placeholder="Password">
                        <button type="submit" name="submit">Login</button>
                    </form>
                    <a href="signup.php">Sign up</a>
                    <?php
                }
                    ?>
            </div>
        </div>
    </nav>
</header>
