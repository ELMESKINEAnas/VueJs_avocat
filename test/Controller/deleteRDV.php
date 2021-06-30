<?php

// required headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

// cnx de la base de données

include_once '../config/Database.php';


// l'instance de la classe client

include_once '../Models/creerRDV.php';



// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate client object
$client = new client($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

// Set ID to update
$client->id_rdv = $data->id_rdv;

// Delete post
if ($client->delete()) {
    echo json_encode(
        array('message' => 'Supression est passée avec succées !')
    );
} else {
    echo json_encode(
        array('message' => 'Vous navez pas suprimmé votre RDV, Ressayez svp')
    );
}