<?php
echo "====== ShadowsDash queue ======\n\n";
echo "[INFO/loader] Loading files...\n";
require("../require/config.php");
require("../require/sql.php");
$timeAtStart = time();
echo "[INFO/loader] Fetching the servers in queue...\n";
$queue = mysqli_query($cpconn, "SELECT * FROM servers_queue ORDER BY type DESC");
echo "[INFO/loader] " . $queue->num_rows . " servers in queue!\n";
echo "\033[32m[INFO/loader] Processing started!\n";
foreach($queue as $server) {
    echo "\033[39m"; // RESET COLOR
    $time = time();
    $date = date("d:m:y h:i:s");
    echo "[INFO] Processing server " . $server['name'] . PHP_EOL;
    $location = $server['location'];
    $locationd = mysqli_query($cpconn, "SELECT * FROM locations WHERE id = '" . mysqli_real_escape_string($cpconn, $location) . "'");
    if ($locationd->num_rows == 0) {
        echo "\033[31m[WARNING] Location does not exist." . PHP_EOL;
        continue;
    }
    $locationd = $locationd->fetch_assoc();
    // check node slots
    $slots_used = $cpconn->query("SELECT * FROM servers WHERE location = '$location'")->num_rows;
    $slots_all = $locationd['slots'];
    if ($slots_used >= $slots_all) {
        if ($server['type'] != "2") {
            echo "\033[31m[INFO] No slots available to create server " . $server['name'] . PHP_EOL;
            continue;
        }

    }
    $egg = $server['egg'];
    $eggd = mysqli_query($cpconn, "SELECT * FROM eggs WHERE id = '" . mysqli_real_escape_string($cpconn, $egg) . "'");
    if ($eggd->num_rows == 0) {
        echo "\033[33m[WARNING $date] Egg does not exist." . PHP_EOL;
        continue;
    }
    $egg = $eggd->fetch_object();
    // get egg information
    $egginfocurl = curl_init($_CONFIG["ptero_url"] . "/api/application/nests/" . $egg->nest . "/eggs/" . $egg->egg);
    $httpheader = array(
        'Accept: application/json',
        'Content-Type: application/json',
        'Authorization: Bearer ' . $_CONFIG["ptero_apikey"]
    );
    curl_setopt($egginfocurl, CURLOPT_HTTPHEADER, $httpheader);
    curl_setopt($egginfocurl, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($egginfocurl);
    curl_close($egginfocurl);
    $response = json_decode($response, true);
    $docker_image = $response['attributes']['docker_image'];
    $startup = $response['attributes']['startup'];
    $ports = $server['xtra_ports'] + 1;
    // create server
    $panelcurl = curl_init($_CONFIG["ptero_url"] . "/api/application/servers");
    $postfields = array(
        'name' => $server['name'],
        'user' => $server['puid'],
        'egg' => $egg->egg,
        'nest' => $egg->nest,
        'docker_image' => $docker_image,
        'startup' => $startup,
        'environment' => array(
            'BUNGEE_VERSION' => "latest",
            'SERVER_JARFILE' => "server.jar",
            'BUILD_NUMBER' => "latest",
            // FORGE
            'MC_VERSION' => 'latest',
            'BUILD_TYPE' => 'recommended',
            // SPONGE
            'SPONGE_VERSION' => '1.12.2-7.3.0',
            // VANILLA
            'VANILLA_VERSION' => 'latest',
            // PURPUR
            'MINECRAFT_VERSION' => 'latest',
            // BEDROCK
            'BEDROCK_VERSION' => 'latest',
            'LD_LIBRARY_PATH' => '.',
            'GAMEMODE' => 'survival',
            'CHEATS' => 'false',
            'DIFFICULTY' => 'easy',
            'SERVERNAME' => 'My Bedrock Server',
            //nukkit
            'NUKKIT_VERSION' => 'latest',
            'PMMP_VERSION' => 'latest',
            'USER_UPLOAD' => 0,
            'AUTO_UPDATE' => 0,
            'BOT_JS_FILE' => 'index.js',
            'BOT_PY_FILE' => 'index.py',
            'TS_VERSION' => 'latest',
            'FILE_TRANSFER' => '30033',
            'MAX_USERS' => 100,
            'MUMBLE_VERSION' => 'latest',
            // PYTHON
            'REQUIREMENTS_FILE' => 'requirements.txt',
        ),
        'limits' => array(
            'memory' => $server['ram'],
            'swap' => $server['ram'],
            'disk' => $server['disk'],
            'io' => 500,
            'cpu' => $server['cpu']*100
        ),
        'feature_limits' => array(
            "databases" => $server['databases'],
            "backups" => 0,
            "allocations" => $ports
        ),
        "deploy" => array(
            "locations" => [$locationd['locationid']],
            "dedicated_ip" => false,
            "port_range" => []
        ));
    $postfields = json_encode($postfields, true);
    curl_setopt($panelcurl, CURLOPT_POST, 1);
    curl_setopt($panelcurl, CURLOPT_POSTFIELDS, $postfields);
    curl_setopt($panelcurl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($panelcurl, CURLOPT_HTTPHEADER, array(
        'Accept: application/json',
        'Content-Type: application/json',
        'Authorization: Bearer ' . $_CONFIG["ptero_apikey"]
    ));
    $result = curl_exec($panelcurl);
    curl_close($panelcurl);
    $ee = json_decode($result, true);
    if (!isset($ee['object'])) {
        echo "\033[31m[ERROR $date] Server failed to create, error details are as follows.\nCode: " . $ee['errors'][0]['code'] . "\nDetail: " . $ee['errors'][0]['detail'] . PHP_EOL;
        continue;
    }
    $identifier = $ee['attributes']['identifier'];
    $pid = $ee['attributes']['id'];
    $uid = $server['ownerid'];
    $location = $locationd['id'];
    mysqli_query($cpconn, "DELETE FROM servers_queue WHERE id=" . $server['id']);
    $created = date("d-m-y", time());
    if (mysqli_query($cpconn, "INSERT INTO servers (`pid`, `uid`, `location`, `timestamp`, `created`) VALUES ($pid, $uid, $location, $time, '$created')")) {
        echo "\033[32m[SUCCESS] The server called " . $server['name'] . " got created.";
    }
    else {
        echo "\033[31m[INFO] Error inserting server into db." . PHP_EOL;
    }
    
}
$timeExecuted = time() - $timeAtStart;
echo "\n\n\033[32m[END] Queue handler ran in $timeExecuted seconds.\033[39m" . PHP_EOL;