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
    if(!isset($_POST['mail'])) throw new Exception("badInput");
    
    require '../dblogin.php';
    $dbh = new PDO("mysql:dbname=$db;host=$sv",$un,$pw);
    $stmt = $dbh->prepare("INSERT INTO Users(mail,phoneNumber,sendSms) VALUES(?,?,?)");

    $sendSms=TRUE;
    $phoneNumber="";
    if(empty($_POST['phoneNumber'])){
        $sendSms=FALSE;
    }
    else{
        $phoneNumber=$_POST['phoneNumber'];
    }
    
 

    $stmt->execute(array($_POST['mail'],$phoneNumber,$sendSms));
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