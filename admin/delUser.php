<?php
require '../dblogin.php';
$dbh = new PDO("mysql:host=$sv;dbname=$db",$un,$pw);

if(isset($_POST['toDelete'])){
    $stmt=$dbh->prepare("DELETE FROM Users WHERE mail=?");
    $stmt2 = $dbh->prepare("SELECT id FROM Users WHERE name=?");
    $stmt3=$dbh->prepare("DELETE FROM UserToGroup WHERE userID=?");
    
    foreach($_POST['toDelete'] as $u){
        
            $stmt2->execute(array($u));
            $id=$stmt2->fetch();
            $stmt3->execute(array($id[0]));
            
            $stmt->execute(array($u));
        }
    }
require '../header.php';
function printUsersCheckbox($dbh){
    
    $q = $dbh->query('SELECT mail FROM Users');
    $res = $q->fetchAll();
    
    foreach($res as $u){
        echo "<div class='groupCheck'><input type='checkbox' name='toDelete[]' value='$u[0]'>".$u[0]."</div>";
        
    }
    
}
?>
<div class='checkboxCont'>
	<form method="post" action="#">
		<?php printUsersCheckbox($dbh); ?>
		<input type='submit' value='Delete users'>
	</form>
</div>