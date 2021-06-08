<?php

interface IModelRepository{
    public function getInformation();
    public function getSingleInformation($item);
    public function CreateInformation($name, $creation);
    public function UpdateInformation($name, $id);
    public function DeleteInformation($id);
}

class InformationRepository implements IModelRepository{
    private $connection;
    private $table = "Data";

    public function __construct($db){
        $this->connection = $db;
    }

    #if this have been Asp.Net Core these functions below would have been placed in a repository. 
    public function getInformation(){
        $sqlQuery = "Select Id, Name, Creation FROM " . $this->table . ";";
        $statement = $this->connection->prepare($sqlQuery);
        $statement->execute();
        return $statement;
    } 


    public function getSingleInformation($item) { //need to handle ids that does not exist in the database
        $sqlQuery = "Select Id, Name, Creation FROM " . $this->table . " Where Id = :id LIMIT 0,1;"; #most likely weak to sql injection.
        $statement = $this->connection->prepare($sqlQuery); //the call to this function checks if $item is numerical or not.
        $statement->bindParam(':id', $item);
        $statement->execute();
        $name;
        $creation; 
        $id;
        $dataRow = $statement->fetch(PDO::FETCH_ASSOC);
        #echo $statement->rowCount();
        #echo var_dump($dataRow);
        if($statement->rowCount() > 0){
            $name = $dataRow['Name'];
            $id = $dataRow['Id'];
            $creation = $dataRow['Creation'];
            return new Information($name, $creation, $id);
        }
        return null;
    }

    public function CreateInformation($name, $creation){ //can create an information entity with null values
        if($name == null || $creation == null)
            return false;
        $sqlQuery = "INSERT INTO " . $this->table . " SET Name = :name, Creation = :creation";
        $statement = $this->connection->prepare($sqlQuery);
        $clearName = htmlspecialchars(strip_tags($name));
        $clearCreation = htmlspecialchars(strip_tags($creation));
        $statement->bindParam(":name", $clearName);
        $statement->bindParam(":creation", $clearCreation);
        
        if($statement->execute()){
            if($statement->rowCount() > 0)
            return true;
        }
        return false;
    }

    public function UpdateInformation($name, $id){ //need to handle if trying to update non-existing entities, right now it indicates a success
        if($name == null || $id == null)
            return false;
        $sqlQuery = "UPDATE " . $this->table . " SET Name = :name WHERE Id = :id";
        $statement = $this->connection->prepare($sqlQuery);
        $clearName = htmlspecialchars(strip_tags($name));
        $clearId = htmlspecialchars(strip_tags($id));
        $statement->bindParam(":name", $clearName);
        $statement->bindParam(":id", $clearId);
        if($statement->execute()){
            if($statement->rowCount() > 0)
                return true;
        }
        return false;
    }

    public function DeleteInformation($id){ //need to handle if trying to delete non-existing entities, right now it indicates a success
        if($id == null)
            return false;
        $sqlQuery = "DELETE FROM " . $this->table . " WHERE Id = ?";
        $statement = $this->connection->prepare($sqlQuery);
        $clearId = htmlspecialchars(strip_tags($id));
        $statement->bindParam(1, $clearId);
        if($statement->execute())
        {
            if($statement->rowCount() > 0)
                return true;
        }
        return false;
    }
}

class Information{
    public $name;
    public $creation;
    public $id; 

    function __construct($name, $creation, $id){
        $this->name = $name;
        $this->creation = $creation;
        $this->id = $id;
    }
}


?>