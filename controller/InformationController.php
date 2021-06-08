<?php
    namespace Controller;

    require "../model/information.php";

    class InformationController{
        private $db;
        private $requestMethod;
        private $id;

        private $informationRepository;

        public function __construct($db, $requestMethod, $id){
            $this->db = $db;
            $this->requestMethod = $requestMethod;
            $this->id = $id;
        }

    }


?>