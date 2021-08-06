<?php
require("../../require/sql.php");

if (!isset($_GET['userid'])) {
    die(json_encode(array(
        'error' => "No user id present in GET request."
    )));
}
$userinfo = mysqli_query($cpconn, "SELECT * FROM users WHERE discord_id = '" . mysqli_real_escape_string($cpconn, $_GET['userid']) . "'");
if ($userinfo->num_rows == 0) {
    die(json_encode(array(
        'error' => "The user with this id does not exist."
    )));
}
$userid = $_GET['userid'];
$user = $userinfo->fetch_object();
$diskLimit = $user->disk_space;
$usedDisk = 0;
$servers = mysqli_query($cpconn, "SELECT * FROM servers WHERE uid = '$userid'");
$servers_queue = mysqli_query($cpconn, "SELECT * FROM servers_queue WHERE ownerid = '$userid'");
foreach ($servers as $serv) {
    $ptid = $serv["pid"];
    $ch = curl_init($_CONFIG["ptero_url"] . "/api/application/servers/" . $ptid);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Authorization: Bearer " . $_CONFIG["ptero_apikey"],
        "Content-Type: application/json",
        "Accept: Application/vnd.pterodactyl.v1+json"
    ));
    $result1 = curl_exec($ch);
    curl_close($ch);
    $result = json_decode($result1, true);

    $disk = $result['attributes']['limits']['disk'];
    $usedDisk = $usedDisk + $disk;
}
foreach ($servers_queue as $server) {
    $usedDisk = $usedDisk + $server['disk'];


}
die(json_encode(array(
    'freeDisk' => $diskLimit - $usedDisk,
    'usedDisk' => $usedDisk
)));