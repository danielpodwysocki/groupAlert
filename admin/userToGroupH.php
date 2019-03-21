<?php



class Group{
    private $id;
    private $users;
    private $userIDs=array();
    private $name;
    public function __construct($inID,$name,$dbh){
        $this->name=$name;
        $this->id=$inID;
        $res=$dbh->query("SELECT userID FROM UserToGroup WHERE groupID=$inID");
        $this->users=$res;
        foreach($res as $r){
            array_push($this->userIDs, $r[0]);

        }
    }

    
    public function listCheckboxes($users){
        
        //print_r ($this->userIDs);
        //print_r($users);
        foreach($users as $u){
            
            if(in_array($u[0],$this->userIDs)) echo("
                                                        <div class='groupCheck groupCheck$this->id'>
                                                            <input type='checkbox' name='addGroup[$this->id][$u[0]]' value='xd' checked>$u[1]
                                                        </div>");
            else echo("
                        <div class='groupCheck groupCheck$this->id'>
                            <input type='checkbox' value='xd' name='addGroup[$this->id][$u[0]]'>$u[1]
                        </div>");
            
        }
        
        
    }
    public function getID(){
        return $this->id;
    }
    public function getName(){
        return $this->name;
    }
      
    public function isInGroup($g){
        if(in_array($g, $this->userIDs)) return true;
    }
    
    
};

class UserToGroup{
    private $dbh;
    private $groups=array();
    private $groupIDs=array();
    private $users;
    
    
    public function getData(){
        ///////////////////////////////////////////////
        $result = $this->dbh->query("SELECT id,name FROM Groups");

        $groupsRes= $result->fetchAll();
        $this->groups=array();
        foreach($groupsRes as $a){
            array_push($this->groups,new Group($a['id'], $a['name'], $this->dbh));
        }
        
    
    }
    
    public function __construct(){
        try{
            session_start();
            if(empty($_SESSION['uid'])){
                session_destroy();
                throw new Exception("notLoggedIn");
            }
            session_regenerate_id();
            require_once '../dblogin.php';
            $this->dbh = new PDO("mysql:dbname=$db;host=$sv",$un,$pw);
            $q = $this->dbh->query("SELECT * from Users");
            
            $this->users = $q->fetchAll();
            
            
            $this->getData();
            $this->proccessInput();
            $this->getData();
            
            ////////////////////////////////////////////////
            
        }catch(Exception $e){
            echo $e->getMessage();
        }
        
        
    }
    public function printGroupsCheckbox() {
        echo "<form method='POST' action=#>";
        //print_r($this->users);
        foreach($this->groups as $a){

            $a->listCheckboxes($this->users);
        }
        echo "<input id='assignSubmit' type='submit' value='Assign'/>";
        echo "</form>";
        print <<<END
        <script>
            $(".groupCheck").hide();
        </script>
END;
        
    }
    
    public function printGroups(){
        echo "<ol>";
        foreach($this->groups as $a){

            $id=$a->getID();
            $gname=$a->getName();
            echo "<li class='group$id liToggle'>$gname</li>";
            echo <<<END
                <script>
                    $(".group$id").click(function(){
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
            
            foreach($this->groups as $g){
                foreach($this->users as $u)
                {
                    if(!empty($_POST)){
                        $arr=$_POST['addGroup'];
                        if(isset($arr[$g->getID()][$u[0]])){ // sprawdzamy czy id danej grupy jest zaznaczone
                            if(!$g->isInGroup($u[0])){
                                $gID=$g->getID();
                                $uID=$u[0];
                                $this->dbh->query("INSERT INTO UserToGroup(userID,groupID) VALUES($uID,$gID)");
                            }
                        }
                        elseif ($g->isInGroup($u[0])){
                            $gID=$g->getID();
                            $uID=$u[0];
                            $this->dbh->query("DELETE FROM UserToGroup WHERE userID=$uID AND groupID=$gID");
                        }
                        
                    }
                    
                    
                }
            }
            
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }
    
    
    
}

//$a->proccessInput();



?>