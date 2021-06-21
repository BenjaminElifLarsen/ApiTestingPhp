<?php 
class Database{
    private $host = "127.0.0.1";
    private $database = "PHPTesting";
    private $username = "Me";
    private $password = "Test123.";

    public function getConnection(){
        try{
            $connection = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->database, $this->username, $this->password);
            $connection->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
            $connection->exec("set names utf8");
            return $connection;
        }
        catch(PDOException $e){
            echo "Database connection failed: " - $e->getMessage();
            return null;
        }
    }
}

?>