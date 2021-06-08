<?php
    use Controller\InformationController;
    
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if($uri[1] !== 'information')
    {
        header("HTTP/1.1 404 Not Found");
        exit();
    }

    $id = null;
    if(isset($uri[2])){
        $id = (int) $uri[2];
    }
    $controller = new InformationController($db, $requestMethod, $id);
    $controller->processRequest();
?>