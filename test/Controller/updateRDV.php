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



// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate client object
$client = new client($db);

// echo($client->random_ref());
// die();
// raw data
$data = json_decode(file_get_contents("php://input"));

// Set ID to update

$client->id = $data->id_client;
$client->ladate = $data->ladate;
$client->sujet = $data->sujet;

// pour Creneau
if ($data->id_creneau === "10:00 AM - 10:30 AM") {

    $client->id_creneau = 1;
} else if ($data->id_creneau === "11:00 AM - 11:30 AM") {

    $client->id_creneau = 2;
} else if ($data->id_creneau === "14:00 AM - 14:30 AM") {

    $client->id_creneau = 3;
} else if ($data->id_creneau === "15:00 AM - 15:30 AM") {

    $client->id_creneau = 4;
} else {

    $client->id_creneau = 5;
}
// $client->profession = $data->prfession;


// Update post
if ($client->update_RDV()) {
    echo json_encode(
        array('message' => 'Vous avez mis à jour votre profil')
    );
} else {
    echo json_encode(
        array('message' => 'Vous navez pas mis à jour votre profil, Ressayez svp')
    );
}
