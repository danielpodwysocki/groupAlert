<html>
<head>
	<meta charset="utf-8"/>
</head>
<body>




<?php
try{
    session_start();
    if(empty($_SESSION['uid'])){
        session_destroy();
        throw new Exception("notLoggedIn");
    }
    require_once 'dblogin.php';
    $dbh = new PDO("mysql:dbname=$db;host=$sv",$un,$pw);
   
    
    
    ///////////////////////////////////////////////
    $result = $dbh->query("SELECT id,alertContent FROM Alerts");
    
    $alerts= $result->fetchAll();
    
    $result = $dbh->query("SELECT id, name FROM Groups");
        
    $groups = $result->fetchAll();
    
    $result = $dbh -> query("SELECT alertID,groupID FROM AlertToGroup");
    
    $alertToGroup = $result->fetchAll();
   
    
    
    
    ////////////////////////////////////////////////
    
}catch(Exception $e){
    echo $e->getMessage();
}




?>


</body>
</html>