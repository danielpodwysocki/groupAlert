<?php

class Alert{
    private $id;
    private $alert;
    public function __construct(){
        
    }
    
}

class sendAlert{
    private $dbh;    
    public function __construct(){
        require_once "dblogin.php";
        $this->dbh = new PDO("mysql:dbname=$db;host=$sv",$un,$pw);
    }
}






?>