<?php

class Alert{
    private $id;
    private $groupIDs=array();
    private $alert;
    public function __construct($aID,$aAlert,$dbh){
        $this->id=$aID;
        $this->alert=$aAlert;
        $res=$dbh->query("SELECT groupID FROM AlertToGroup WHERE alertID=$this->id");
        $this->groups=$res;
        foreach($res as $r){
            array_push($this->groupIDs, $r[0]);
        }
    }

    

    public function getID(){
        return $this->id;
    }
    public function getAlert(){
        return $this->alert;
    }
    
    public function isInGroup($g){
        if(in_array($g, $this->groupIDs)) return true;
    }
    
    
    
    
    
};


class sendAlert{
    private $dbh;
    private $alerts;
    private $location;
    public function __construct(){
        try{
                
            if(!isset($_GET['location']))throw new Exception('noLocationGiven');
            $this->location=$_GET['location'];
            require "dblogin.php";
            $this->dbh = new PDO("mysql:dbname=$db;host=$sv",$un,$pw);
            $this->getData();
            
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }
    public function getData(){
        ///////////////////////////////////////////////
        $result = $this->dbh->query("SELECT id,alertContent FROM Alerts");
        
        $alertsRes= $result->fetchAll();
        $this->alerts=array();
        foreach($alertsRes as $a){
            array_push($this->alerts,new Alert($a['id'], $a['alertContent'], $this->dbh));
        }      
    }
    public function printAlerts(){
        echo "<form method='GET' action='sendAlert.php'>
                <div id='checkboxes'>";
             
        echo "<input type='hidden' name='location' value='$this->location'>";
        foreach($this->alerts as $a){
            $aID=$a->getID();
            $alert=$a->getAlert();
            echo "<input type='checkbox' name='alert$aID' id='$aID'>";
            echo "<label class='alertLabel' for='$aID'>$alert</label>";
            
        }
        echo "<input id='alertSubmit' class='button button--winona button--border-thin button--round-s' type='submit' value='Zgłoś'>
        </div></form>";
    }
    
};







?>