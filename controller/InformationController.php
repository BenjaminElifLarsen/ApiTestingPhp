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

        public function __construct($db, $requestMethod, $id){
            $this->db = $db;
            $this->requestMethod = $requestMethod;
            $this->id = $id;

            $this->informationRepository = new \InformationRepository($db);
        }

        public function processRequest(){
            switch($this->requestMethod){
                case 'GET':
                    if($this->id){

                    }else{
                        include_once '../api/read.php';

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
    }


?>