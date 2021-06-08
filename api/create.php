<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once '../config/database.php';
    include_once '../model/information.php';

    $database = new Database();
    $db = $database->getConnection();
    $informations = new InformationRepository($db);
    $data = json_decode(file_get_contents("php://input"));
    $name = $data->name;
    $creation = date('Y-m-d H:i:s');
    if($informations->CreateInformation($name, $creation)){
        echo json_encode("Information created.");
    }
    else{
        echo json_encode("Information could not be created.");
    }
?>