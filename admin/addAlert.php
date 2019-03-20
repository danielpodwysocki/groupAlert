



<?php
try{
    session_start();
    if(empty($_SESSION["uid"])){
        throw new Exception("notLoggedIn");
        session_destroy();
    }
    if(!isset($_POST["alertContent"])) throw new Exception("badInput");
    require "../dblogin.php";
    $dbh = new PDO("mysql:dbname=$db;host=$sv",$un,$pw);
    $stmt = $dbh->prepare("INSERT INTO Alerts(alertContent) VALUES(?)");
    $stmt->execute(array($_POST["alertContent"]));
    throw new Exception('done');
    
    
    
}catch(Exception $e){
    session_abort();
    require '../header.php';
    echo <<<END
            <div class='formCont'>
                <form method="post" action="#">
                    Alert content:
                    <input type="text" name="alertContent"/>
                    <input type="submit" value='Add alert'/>
                </form>
            </div>

END;
    require '../footer.php';
    
}

?>