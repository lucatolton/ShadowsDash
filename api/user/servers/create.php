<?php
require("../../../require/sql.php");
session_start();
$queue = 0;
if (!isset($_SESSION['loggedin'])) {
    if (getBearerToken() == null) {
        die(json_encode(array(
            'errors' => [
                'code' => 'UnauthorizedException',
                'status' => 403,
                'detail' => "No bearer authorization key was included in the request."
            ]
        )));
    }
    $apikeys = mysqli_query($cpconn, "SELECT * FROM apikeys ");
    die("External connections aren't finished at the moment, come back later.");

}
$user = $_SESSION['user'];
$userdb = mysqli_query($cpconn, "SELECT * FROM users WHERE discord_id = '" . mysqli_real_escape_string($cpconn, $user->id) . "'")->fetch_object();
if ($userdb->staff == 1)
{
    $queue = 2;
}
$ramLimit = $userdb->memory;
$cpuLimit = $userdb->cpu;
$diskLimit = $userdb->disk_space;
$serverLimit = $userdb->server_limit;
$usedRam = 0;
$usedDatabase = 0;
$usedPorts = 0;
$usedDisk = 0;
$servers = mysqli_query($cpconn, "SELECT * FROM servers WHERE uid = '$user->id'");
$servers_in_queue = mysqli_query($cpconn, "SELECT * FROM servers_queue WHERE ownerid = '" . mysqli_real_escape_string($cpconn, $user->id) . "'");
foreach($servers as $serv) {
    $ptid = $serv["pid"];
    $ch = curl_init($_CONFIG["ptero_url"] . "/api/application/servers/" . $ptid);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Authorization: Bearer " . $_CONFIG["ptero_apikey"],
        "Content-Type: application/json",
        "Accept: application/json"
    ));
    $result1 = curl_exec($ch);
    curl_close($ch);
    $result = json_decode($result1, true);
    $ram = $result['attributes']['limits']['memory'];
    $disk = $result['attributes']['limits']['disk'];
    $ports = $result['attributes']['feature_limits']['allocations'] - 1;
    $databases = $result['attributes']['feature_limits']['databases'];
    $usedDatabase = $usedDatabase + $databases;
    $usedPorts = $usedPorts + $ports;
    $usedRam = $usedRam + $ram;
    $usedDisk = $usedDisk + $disk;
}
foreach($servers_in_queue as $server) {
    $usedRam = $usedRam + $server['ram'];
    $usedDisk = $usedDisk + $server['disk'];
    $usedPorts = $usedPorts + $server['xtra_ports'];
    $usedDatabase = $usedDatabase + $server['databases'];

}
$freeRam = $ramLimit - $usedRam;
$freeDisk = $diskLimit - $usedDisk;
$freePorts = $userdb->ports - $usedPorts;
$freeDatabases = $userdb->databases - $usedDatabase;

if (!isset($_POST['name']) || !isset($_POST['memory']) || !isset($_POST['cores']) || !isset($_POST['disk']) || !isset($_POST['ports']) || !isset($_POST['databases']) || !isset($_POST['location']) || !isset($_POST['egg'])) {
    print_r($_POST);
    die(json_encode(array(
        'errors' => [
            'code' => "ValidationException",
            'status' => "400",
            'detail' => "Some post fields are empty or invalid."
        ]
    )));
}
if (!is_numeric($_POST['memory']) || !is_numeric($_POST['disk']) || !is_numeric($_POST['ports']) || !is_numeric($_POST['databases']) || !is_numeric($_POST['cores']) || !is_numeric($_POST['location']) || !is_numeric($_POST['egg'])) {
    die(json_encode(array(
        'errors' => [
            'code' => "ValidationException",
            'status' => 400,
            'detail' => "Some post fields are empty or invalid."
        ]
    )));
}
$usedServers = $servers->num_rows + $servers_in_queue->num_rows;
if ($usedServers >= $serverLimit) {
    die(json_encode(array(
        'errors' => [
            'code' => "ValidationException",
            'status', 400,
            'detail' => "You have no servers left"
        ]
    )));
}
if ($_POST['memory'] == 0 || $_POST['memory'] != round($_POST['memory'], 0)) {
    die(json_encode(array(
        'errors' => [
            'code' => "ValidationException",
            'status' => 400,
            'detail' => "Memory is invalid"
        ]
    )));
}
if ($_POST['cores'] < 0.15) {
    die(json_encode(array(
        'errors' => [
            'code' => 'ValidationException',
            'status' => 400,
            'detail' => "Minimum CPU is 0.15"
        ]
    )));
}
if ($_POST['memory'] < 256) {
    die(json_encode(array(
        'errors' => [
            'code' => 'ValidationException',
            'status' => 400,
            'detail' => "Minimum memory is 256MB"
        ]
    )));
}
if ($_POST['disk'] < 256) {
    die(json_encode(array(
        'errors' => [
            'code' => 'ValidationException',
            'status' => 400,
            'detail' => "Minimum disk is 256MB"
        ]
    )));
}
if ($_POST['ports'] < 0 || $_POST['ports'] != round($_POST['ports'], 0)) {
    die(json_encode(array(
        'errors' => [
            'code' => 'ValidationException',
            'status' => 400,
            'detail' => "Minimum ports is 0"
        ]
    )));
}
if ($_POST['databases'] < 0 || $_POST['databases'] != round($_POST['databases'], 0)) {
    die(json_encode(array(
        'errors' => [
            'code' => 'ValidationException',
            'status' => 400,
            'detail' => "Minimum databases is 0"
        ]
    )));
}
if ($_POST['cores'] > $cpuLimit) {
    die(json_encode(array(
        'errors' => [
            'code' => 'NotEnoughResourcesException',
            'status' => 400,
            'detail' => "You don't have enough CPU"
        ]
    )));
}
if ($_POST['memory'] > $freeRam) {
    die(json_encode(array(
        'errors' => [
            'code' => 'NotEnoughResourcesException',
            'status' => 400,
            'detail' => "You don't have enough memory"
        ]
    )));
}
if ($_POST['disk'] > $freeDisk) {
    die(json_encode(array(
        'errors' => [
            'code' => 'NotEnoughResourcesException',
            'status' => 400,
            'detail' => "You don't have enough disk space"
        ]
    )));
}
if ($_POST['ports'] > $freePorts) {
    die(json_encode(array(
        'errors' => [
            'code' => 'NotEnoughResourcesException',
            'status' => 400,
            'detail' => "You don't have enough ports"
        ]
    )));
}
if ($_POST['databases'] > $freeDatabases) {
    die(json_encode(array(
        'errors' => [
            'code' => 'NotEnoughResourcesException',
            'status' => 400,
            'detail' => "You don't have enough databases"
        ]
    )));
}
$locid = $_POST['location'];
if ($locid == 3) {
    $donator = $cpconn->query("SELECT * FROM donators WHERE uid = '$user->id'")->num_rows;
    if ($donator == 0) {
        die(json_encode(array(
            'errors' => [
                'code' => 'NotDonatorException',
                'status' => 400,
                'detail' => "You don't have donator node access."
            ],
            'success' => false
        )));
    }
}
$doeslocationexist = mysqli_query($cpconn, "SELECT * FROM locations WHERE id = '" . mysqli_real_escape_string($cpconn, $locid) . "'");
if ($doeslocationexist->num_rows == 0) {
    die(json_encode(array(
        'errors' => [
            'code' => 'NoLocationException',
            'status' => 400,
            'detail' => "That location doesn't exist"
        ],
        "success" => false
    )));
}
$eggid = $_POST['egg'];
$doeseggexist = mysqli_query($cpconn, "SELECT * FROM eggs where id = '" . mysqli_real_escape_string($cpconn, $eggid) . "'");
if ($doeseggexist->num_rows == 0) {
    die(json_encode(array(
        'errors' => [
            'code' => 'NoEggException',
            'status' => 400,
            'detail' => "That egg doesn't exist"
        ],
        'success' => false
    )));
}
// add to db
$egg = $doeseggexist->fetch_object();
$name = $_POST['name'];
$ram = $_POST['memory'];
$disk = $_POST['disk'];
$cpu = $_POST['cores'];
$xtraports = $_POST['ports'];
$location = $_POST['location'];
$databases = $_POST['databases'];
$created = date("d-m-y", time());
if (mysqli_query($cpconn, "INSERT INTO servers_queue (`name`, `ram`, `disk`, `cpu`, `xtra_ports`, `databases`, `location`, `ownerid`, `type`, `egg`, `puid`, `created`) VALUES ('" . mysqli_real_escape_string($cpconn, $name) . "', '" . mysqli_real_escape_string($cpconn, $ram) . "', '" . mysqli_real_escape_string($cpconn, $disk) . "', '" . mysqli_real_escape_string($cpconn, $cpu) . "', '" . mysqli_real_escape_string($cpconn, $xtraports) . "', '" . mysqli_real_escape_string($cpconn, $databases) . "', '" . mysqli_real_escape_string($cpconn, $location) . "', '" . mysqli_real_escape_string($cpconn, $user->id) . "', '$queue', '" . mysqli_real_escape_string($cpconn, $eggid) . "', '$userdb->panel_id', '$created')")) {
    die(json_encode(array(
        'success' => true
    )));
}
