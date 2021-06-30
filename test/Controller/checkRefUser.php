<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// cnx de la base de données

include_once '../config/Database.php';


// l'instance de la classe client

include_once '../Models/creerRDV.php';


//instantier la base de données 

$database = new Database();
$db = $database->connect();


// instance de la classe client

$client = new Client($db);

// pour obtenir les données

// raw data
$data = json_decode(file_get_contents("php://input"));

$client->id = $data->id;

$num = $client->check_Ref();

if ($num > 0) {
    // Post array
    echo json_encode(array('message' => 'Client already exists'));
    } else{
    // Turn to JSON & output
    echo json_encode(array('message' => 'client doesnt exist'));
    }
