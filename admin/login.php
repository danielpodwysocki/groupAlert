
<?php
try{
    
    
    ///
    if(!isset($_POST['login'],$_POST['pass'])) throw new Exception("badInput");
    require '../dblogin.php';
    $dbh = new PDO("mysql:dbname=$db;host=$sv",$un,$pw);
    $login=$_POST['login'];
    
    $stmt = $dbh->prepare("SELECT passHash FROM AuthUsers WHERE login=?");
    $stmt->execute(array($login));
    $passHash=$stmt->fetch();
    if(empty($passHash[0])) throw new Exception("wrongLogin");
    
    if(password_verify($_POST['pass'], $passHash[0])){
        session_start();
        $stmt = $dbh->prepare("SELECT id FROM AuthUsers WHERE login=?");
        $stmt->execute(array($login));
        $res=$stmt->fetch();
        $_SESSION['uid']=$res[0];
        require 'alertsRedirect.php';
        
        
    }
    else throw new Exception("wrongPass");
    
    
    
    
}catch(Exception $e){
    require '../header.php';
    echo <<<END

        <div class='formCont'>
            <form method="POST" action="#">
            Login
            <input type="text" name="login"/>
            Password
            <input type="password" name="pass"/> 
            <input type="submit" value='Log in'/>
            </form>
        </div>
END;
    require '../footer.php';
}

?>