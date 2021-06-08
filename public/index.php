<?php    
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    #use Controller\InformationController;
    include_once '../controller/informationController.php';
    include_once '../config/database.php';

    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri = explode('/',$uri);

    if($uri[1] !== 'TestApi')
    {
        #echo json_encode($uri);
        header("HTTP/1.1 404 Not Found");
        exit();
    }

    $id = null;
    if(isset($uri[2])){
        $id = (int) $uri[2];
    }
    
    $requestMethod = $_SERVER["REQUEST_METHOD"];
    $db = new Database();
    $db = $db->getConnection();

    $controller = new Controller\InformationController($db, $requestMethod, $id);
    $controller->processRequest();
?>