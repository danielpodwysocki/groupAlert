<html>
<head>
	<meta charset="utf-8"/>
</head>
<body>
<form method="POST" action="#">
	<input type="text" name="login"/>
	<input type="password" name="pass"/>
	<input type="submit"/>
</form>

</body>
</html>
<?php
try{
    
    
    ///
    if(!isset($_POST['login'],$_POST['pass'])) throw new Exception("badInput");
    require 'dblogin.php';
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
        
        echo "luks, zalogowany";
    }
    else throw new Exception("wrongPass");
    
    
    
}catch(Exception $e){
    echo $e->getMessage();
}

?>