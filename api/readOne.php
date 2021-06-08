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
    if(isset($_GET['id']))
    {
        $id = $_GET['id'];
        if(is_numeric($id)){
            $info = $informations->getSingleInformation($id);
            if($info == null)
            {
                http_response_code(404);
                echo json_encode(array("message" => "invalid id"));
            }
            else{    
                $dataArray = array();
                $dataArray["body"] = array(
                    "id" => $info->id,
                    "name" => $info->name,
                    "creation" => $info->creation,
                );
                echo json_encode($dataArray);
            }

        }
        else{
            http_response_code(404);
            echo json_encode(array("message" => "Invalid id"));
        }
    }
    else{
        http_response_code(404);
        echo json_encode(array("message" => "no id"));
    }

?>