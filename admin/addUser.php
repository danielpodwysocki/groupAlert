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
    if(!isset($_POST['mail'],$_POST['phoneNumber'])) throw new Exception("badInput");
    
    require '../dblogin.php';
    $dbh = new PDO("mysql:dbname=$db;host=$sv",$un,$pw);
    $stmt = $dbh->prepare("INSERT INTO Users(mail,phoneNumber) VALUES(?,?)");
    $stmt->execute(array($_POST['mail'],$_POST['phoneNumber']));
    throw new Exception('done');
    
    
    


}catch(Exception $e){
    session_abort();
    require '../header.php';
    echo <<<END
	<div class='formCont'>
         <form method="post" action="#">
            Email address:
    		<input type="text" name="mail"/>
    		Phone number:
            <input type="text" name="phoneNumber"/>
    		<input type="submit" value="Add a user"/>
    	</form>
    </div>  

END;
    require '../footer.php';
}

?>