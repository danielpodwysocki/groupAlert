


<?php

try{
    session_start();
    if(empty($_SESSION['uid'])){
        session_destroy();
        throw new Exception("notLoggedIn");
    }
    //tutaj wyjatek na brak zalogowania jako admin
    if(!isset($_POST['name'])) throw new Exception("badInput");
    
    require '../dblogin.php';
    $dbh = new PDO("mysql:dbname=$db;host=$sv",$un,$pw);
    $stmt = $dbh->prepare("INSERT INTO Groups(name) VALUES(?)");
    $stmt->execute(array($_POST['name']));
    throw new Exception('done');
    
    
    
    
    



}catch(Exception $e){
    session_abort();
    require '../header.php';
    echo <<<END
    <div class='formCont'>
    	<form method="post" action="#">
            Group name:
    		<input type="text" name="name"/>
    		<input type="submit" value='Add a group'/>
    		
    	
    	</form>
    </div>




END;
    require '../footer.php';
}

?>