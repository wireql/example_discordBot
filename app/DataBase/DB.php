<?php

namespace Application\DataBase;

use Application\Config\Config;

use PDO;
use PDOException;

class DB {
    
    private $db_host = Config::DB_HOST;
    private $db_name = Config::DB_NAME;
    private $db_username = Config::DB_USERNAME;
    private $port = Config::DB_PORT;
    private $db_password = Config::DB_PASSWORD;

    public $db;

    public function __construct() {

        $this->dbConnect();
        
    }

    public function dbConnect()
    {
        try{
            $this->db = new PDO('mysql:host='.$this->db_host.'; port='.$this->port.'; dbname='.$this->db_name,$this->db_username,$this->db_password);
        }catch(PDOException $e){
            echo "Connection error ".$e->getMessage(); 
            exit;
        }
    }

}