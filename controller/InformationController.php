<?php
    namespace Controller;

    require_once "../model/information.php";

    class InformationController{
        private $db;
        private $requestMethod;
        private $id;
        private $informationRepository;

        public function __construct($db, $requestMethod)
        {
            $this->db = $db;
            $this->requestMethod = $requestMethod;

            $this->informationRepository = new \InformationRepository($db);
        }

        public function setId($id)
        {
            $this->id = $id;
        }

        public function processRequest()
        {
            switch($this->requestMethod){
                case 'GET':
                    if($this->id){
                        $this->one($this->id);
                    }else{
                        $this->all();
                    }
                    break;
                case 'POST':
                    $this->add();
                    break;

                case 'PUT':
                    $this->update($this->id);
                    break;

                case 'DELETE':
                    $this->delete($this->id);
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
                http_response_code(200);
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
                $info = $this->informationRepository->getSingleInformation($id);
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
                    http_response_code(200);
                    echo json_encode($dataArray);
                }
    
            }
            else{
                http_response_code(404);
                echo json_encode(array("message" => "Invalid id"));
            }
        }

        private function add()
        {
            if(!isset($_POST["name"]) or !isset($_POST["creationTime"]))
            {
                http_response_code(404);
                echo json_encode(array("message" => "post variables not set."));
                exit;
            }
            if(empty($_POST["name"]) || empty($_POST["creationTime"]))
            {
                http_response_code(404);
                echo json_encode(array("message" => "one or more variables are empty."));
                exit;
            }
            $name = htmlspecialchars($_POST["name"]);
            $creationTime = htmlspecialchars($_POST["creationTime"]);
            $result = $this->informationRepository->CreateInformation($name, $creationTime);
            if($result)
            {
                http_response_code(200);
                echo json_encode(array("message" => "successed"));
            }
            else
            {
                http_response_code(404);
                echo json_encode(array("message" => "failed"));
            }
        }

        private function update($id)
        {
            $input = file_get_contents("php://input");
            $input = (array) json_decode($input);
            if($this->validdateData($input)){
                $name = $input["name"];
                $creationTime = $input["creationTime"];
                $result = $this->informationRepository->UpdateInformation($name, $id, $creationTime);
                if($result){
                    http_response_code(404);
                    echo json_encode(array("message" => "successed"));
                }
                else{
                    http_response_code(404);
                    echo json_encode(array("message" => "failed"));
                }
            }else{
                echo "invalid data format";
            }
        }

        private function delete($id)
        {
            $result = $this->informationRepository->DeleteInformation($id);
            if($result){
                http_response_code(404);
                echo json_encode(array("message" => "successed"));
            }
            else{
                http_response_code(404);
                echo json_encode(array("message" => "failed"));
            }
        }

        private function validdateData($data)
        {
            if(!isset($data["name"])){
                return false;
            }
            if(!isset($data["creationTime"])){
                return false;
            }
            return true;
        }

    }


?>