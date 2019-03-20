<html>
<head>
	<meta charset="utf-8"/>
</head>
<body>
	<form method="post" action="#">
		<input type="text" name="login"/>
		<input type="password" name="pass"/>
		<input type="submit"/>
		
	
	</form>
</body>
</html>


<?php

try{
    session_start();
    if(empty($_SESSION['uid'])){
        throw new Exception("notLoggedIn");
        session_destroy();
    }

    if(!isset($_POST['login'],$_POST['pass'])) throw new Exception("badInput");

    require '../dblogin.php';
    $dbh = new PDO("mysql:dbname=$db;host=$sv",$un,$pw);
    $stmt = $dbh->prepare("INSERT INTO AuthUsers(login,passHash) VALUES(?,?)");
    $stmt->execute(array($_POST['login'],password_hash($_POST['pass'], PASSWORD_BCRYPT)));
    
    
    
    
    
    



}catch(Exception $e){
    echo $e->getMessage();
    
}

?>
