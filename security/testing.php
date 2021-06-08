<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include '../security/security.php';

    $data = json_decode(file_get_contents("php://input"));
    $data2 = $_SERVER['PHP_AUTH_USER'];

    echo var_dump($data);
    echo var_dump($data2);
    echo json_encode($data2);
?>