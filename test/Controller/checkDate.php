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

$client->ladate = $data->ladate;
// $client->ladate = '2021-06-06';
// $client->id_creneau = $data->id_creneau;

$Available = $client->Check_RDV_if_Exists();
$num = $Available->rowCount();

if ($num > 0) {
    // Post array
    $posts_arr = array();

    while ($row = $Available->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $post_item['creneaux'] = $creneaux;

        // Push to "posts_arr"
        array_push($posts_arr, $post_item['creneaux']);
    }
    // print_r($posts_arr);

    // Turn to JSON & output
    echo json_encode($posts_arr);
}
