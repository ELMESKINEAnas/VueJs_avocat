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


$client->sujet = $data->sujet;
$client->ladate = $data->ladate;
$client->id = $data->id_client;



// pour Creneau
if($data->id_creneau === "10:00 AM - 10:30 AM"){

    $client->id_creneau = 1;

} else if ($data->id_creneau === "11:00 AM - 11:30 AM"){

    $client->id_creneau = 2;

} else if ($data->id_creneau === "14:00 AM - 14:30 AM"){

    $client->id_creneau = 3;

}else if ($data->id_creneau === "15:00 AM - 15:30 AM"){

    $client->id_creneau = 4;

} else if($data->id_creneau === "16:00 AM - 16:30 AM"){

    $client->id_creneau = 5;
}



// creer RDV

if ($client->creer_RDV()) {
    echo json_encode(
        array('message' => 'Vous avez mis un RDV')
    );
} else {
    echo json_encode(
        array('message' => 'Vous navez pas crée votre RDV. Svp ressayez une autre fois')
    );
}
