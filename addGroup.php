<html>
<head>
	<meta charset="utf-8"/>
</head>
<body>
	<form method="post" action="#">
		<input type="text" name="name"/>
		<input type="submit"/>
		
	
	</form>
</body>
</html>


<?php

try{
    session_start();
    if(empty($_SESSION['uid'])){
        session_destroy();
        throw new Exception("notLoggedIn");
    }
    //tutaj wyjatek na brak zalogowania jako admin
    if(!isset($_POST['name'])) throw new Exception("badInput");
    
    require 'dblogin.php';
    $dbh = new PDO("mysql:dbname=$db;host=$sv",$un,$pw);
    $stmt = $dbh->prepare("INSERT INTO Groups(name) VALUES(?)");
    $stmt->execute(array($_POST['name']));
    
    
    
    
    
    



}catch(Exception $e){
    echo $e->getMessage();
    
}

?>