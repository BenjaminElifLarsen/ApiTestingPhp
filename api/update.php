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

    $information = new InformationRepository($db);
    $data = json_decode(file_get_contents("php://input"));
    $name = $data->name;
    $id = $data->id;
    if($information->UpdateInformation($name, $id))
    {
        echo json_encode("Information Updated.");
    }
    else{
        http_response_code(404);
        echo json_encode(array("message" => "Information not updated"));
    }

?>