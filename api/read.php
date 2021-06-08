<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once '../config/database.php';
    include_once '../model/information.php';

    $database = new Database();
    $db = $database->getConnection();
    $informations = new InformationRepository($db);

        $statement = $informations->getInformation();
        $itemCount = $statement->rowCount();

        if($itemCount > 0){
            $dataArray = array();
            $dataArray["body"] = array();
            $dataArray["itemCount"] = $itemCount;

            while($row = $statement->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                $e = array(
                    "id" => $Id,
                    "name" => $Name,
                    "creation" => $Creation,
                );
                array_push($dataArray["body"], $e);
            }
            echo json_encode($dataArray);
        }
        else{
            http_response_code(404);
            echo json_encode(array("message" => "No record found"));
        }

?>