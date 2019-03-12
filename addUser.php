<html>
<head>
	<meta charset="utf-8"/>
</head>
<body>
	<form method="post" action="#">
		<input type="text" name="mail"/>
		<input type="text" name="phoneNumber"/>
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
    if(!isset($_POST['mail'],$_POST['phoneNumber'])) throw new Exception("badInput");
    
    require 'dblogin.php';
    $dbh = new PDO("mysql:dbname=$db;host=$sv",$un,$pw);
    $stmt = $dbh->prepare("INSERT INTO Users(mail,phoneNumber) VALUES(?,?)");
    $stmt->execute(array($_POST['mail'],$_POST['phoneNumber']));
    
    
    
    
    
    



}catch(Exception $e){
    echo $e->getMessage();
    
}

?>