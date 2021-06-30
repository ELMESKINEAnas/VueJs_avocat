<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../config/Database.php';
include_once '../Models/creerRDV.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog post object
$client = new Client($db);

$data = json_decode(file_get_contents('php://input'));

$client->id = $data->reference;
// $client->id = "test";

// read_client query
$result_client = $client->read_client();;

//read_RDV query
$result_rdv = $client->read_RDV();
// print_r($result_rdv);
// Get row count
$nmbr = $result_client['count'];

// Check if any posts
if ($nmbr > 0) {

    $arr = array();

    for ($i = 0; $i < sizeof($result_rdv); $i++) {
        $arr[$i] = $result_rdv[$i];
    }

    $result_client["Infos"]["RDVS"] = $arr;
    echo json_encode($result_client["Infos"]);
} else {
    // No client exists

    echo json_encode(
        array('message' => 'No Posts Founded')
    );
}


// Get ID
// $client->id = $data->token;

// Get post
// $details = $client->read_RDV();

// Make JSON
// print_r(json_encode($details));
