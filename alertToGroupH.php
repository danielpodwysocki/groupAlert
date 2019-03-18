<?php



class Alert{
    private $id;
    private $groupIDs=array();
    private $groupNames=array();
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
    public function listAlertGroups(){
            foreach($this->groups as $g){
                echo $g[0];
                
            }
        }
        
    public function listCheckboxes($groups){
            foreach($groups as $g){

                if(in_array($g[0],$this->groupIDs)) echo("
                                                        <div class='groupCheck groupCheck$this->id'>
                                                            <input type='checkbox' name='addGroup[$this->id][$g[0]]' value='xd' checked>$g[1]
                                                        </div>");
                else echo("
                        <div class='groupCheck groupCheck$this->id'>
                            <input type='checkbox' value='xd' name='addGroup[$this->id][$g[0]]'>$g[1]
                        </div>");
                
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

class AlertToGroup{
    private $dbh;
    private $alerts=array();
    private $groups;
    private $groupIDs=array();
    
    
    public function getData(){
        ///////////////////////////////////////////////
        $result = $this->dbh->query("SELECT id,alertContent FROM Alerts");
        
        $alertsRes= $result->fetchAll();
        $this->alerts=array();
        foreach($alertsRes as $a){
            array_push($this->alerts,new Alert($a['id'], $a['alertContent'], $this->dbh));
        }
        
        $result = $this->dbh->query("SELECT id, name FROM Groups");
        
        $this->groups = $result->fetchAll();
    }
    
    public function __construct(){
        try{
            session_start();
            if(empty($_SESSION['uid'])){
                session_destroy();
                throw new Exception("notLoggedIn");
            }
            session_regenerate_id();
            require_once 'dblogin.php';
            $this->dbh = new PDO("mysql:dbname=$db;host=$sv",$un,$pw);
            $this->getData();
            $this->proccessInput();
            $this->getData();
            
            
            
     

            
            
            
            
            
            
            ////////////////////////////////////////////////
            
        }catch(Exception $e){
            echo $e->getMessage();
        }
        
        
    }
    public function printGroupsCheckbox() {
        echo "<form method='get' action=#>";
        foreach($this->alerts as $a){
            $x=$a->getID();
            $a->listCheckboxes($this->groups);
        }
        echo "<input type='submit'/>";
        echo "</form>";
        print <<<END
        <script>
            $(".groupCheck").hide();
        </script>
END;
        
    }
   
    public function printAlerts(){
        echo "<ol>";
        foreach($this->alerts as $a){
            $id=$a->getID();
            $alert=$a->getAlert();
            echo "<li class='alert$id'>$alert</li>";
            echo <<<END
                <script>
                    $(".alert$id").click(function(){
                        $(".groupCheck").hide();
                        $(".groupCheck$id").show();
                    });
                </script>
END;
        }
        echo "</ol>";
        
    }
    public function proccessInput(){
        
        try{
                
            
            //if(!isset($_GET['addGroup'])) throw new Exception("nothingSent");
            
            foreach($this->alerts as $a){
                foreach($this->groups as $g)
                {
                    if(!empty($_GET)){
                        $arr=$_GET['addGroup'];
                        if(isset($arr[$a->getID()][$g[0]])){ // sprawdzamy czy id danej grupy jest zaznaczone
                            if(!$a->isInGroup($g[0])){
                                $aID=$a->getID();
                                $gID=$g[0];
                                $this->dbh->query("INSERT INTO AlertToGroup(alertID,groupID) VALUES($aID,$gID)");
                            }  
                        }
                        elseif ($a->isInGroup($g[0])){
                            $aID=$a->getID();
                            $gID=$g[0];
                            $this->dbh->query("DELETE FROM AlertToGroup WHERE alertID=$aID AND groupID=$gID");
                        }
                   
                    }
                   
                    
                    }
                }
            
        }catch(Exception $e){
            echo 'xd';
        }
    }

    
    
}



?>