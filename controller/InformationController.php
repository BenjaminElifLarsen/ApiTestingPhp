<?php
    namespace Controller;

    require_once "../model/information.php";
    #require '../config/database.php';

    #https://developer.okta.com/blog/2019/03/08/simple-rest-api-php
    class InformationController{
        private $db;
        private $requestMethod;
        private $id;

        private $informationRepository;

        public function __construct($db, $requestMethod, $id)
        {
            $this->db = $db;
            $this->requestMethod = $requestMethod;
            $this->id = $id;

            $this->informationRepository = new \InformationRepository($db);
        }

        public function processRequest()
        {
            echo json_encode($this->requestMethod);
            switch($this->requestMethod){
                case 'GET':
                    if($this->id){
                        $this->one($this->id);
                    }else{
                        $this->all();
                    }
                    break;
                case 'POST':
                    
                    break;

                case 'PUT':
                    
                    break;

                case 'DELETE':
                    
                    break;
            }
        }

        private function all()
        {
            $statement = $this->informationRepository->getInformation();
            $itemCount = $statement->rowCount();

            if($itemCount > 0){
                $dataArray = array();
                $dataArray["body"] = array();
                $dataArray["itemCount"] = $itemCount;

                while($row = $statement->fetch(\PDO::FETCH_ASSOC)){
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
        }

        private function one($id)
        {
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
    }


?>