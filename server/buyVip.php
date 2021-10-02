<?php
require("../require/config.php");
require("../require/sql.php");
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("location: /login");
    die();
}

if (!is_numeric($_GET["server"])) {
    $_SESSION['error'] = "Server ID is invalid.";
    header("location: /");
    die();
}

$user = $_SESSION['user'];
$userdb = mysqli_query($cpconn, "SELECT * FROM users WHERE discord_id = '" . mysqli_real_escape_string($cpconn, $user->id) . "'")->fetch_object();
$curcoins = $userdb->coins;
if ($curcoins < $_CONFIG["vipqueue"]) {
    $cneeded = $_CONFIG["vipqueue"] - $userdb->coins;
    if ($userdb->coins == 0) {
        $cneeded = $_CONFIG["vipqueue"];
    }
    $_SESSION['error'] = "You do not have enough coins to buy the VIP queue. You need <strong>$cneeded</strong> more coins!";
    header("location: /");
    die();
}


$server = mysqli_query($cpconn, "SELECT * FROM servers_queue WHERE id = '" . mysqli_real_escape_string($cpconn, $_GET["server"]) . "'")->fetch_object();

if ($server->type > 1) {
    $_SESSION['error'] = "You already have VIP or staff queue!";
    header("location: /");
    die();
}

// Remove the coins

$newcoins = $curcoins - $_CONFIG["vipqueue"];

mysqli_query($cpconn, "START TRANSACTION");
if (!mysqli_query($cpconn, "UPDATE users SET coins = '$newcoins' WHERE discord_id = '$user->id'")) {
    $_SESSION['error'] = "There was an exception while communicating with the database. Please contact support.";
    mysqli_query($cpconn, "ROLLBACK");
    header("location: /");
    die();
}


if (!mysqli_query($cpconn, "UPDATE servers_queue SET type = '1' WHERE id = '" . mysqli_real_escape_string($cpconn, $_GET["server"]) . "'")) {
    mysqli_query($cpconn, "ROLLBACK");
    header("location: /");
    $_SESSION['error'] = "There was an exception while communicating with the database. Pleast contact support.";
    die();
}

mysqli_query($cpconn, "COMMIT");
header("location: /");
$_SESSION['success'] = "Your server got is now in VIP queue. Enjoy faster queue times!";
die();