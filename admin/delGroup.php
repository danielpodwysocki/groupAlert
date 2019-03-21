<?php
require '../dblogin.php';
$dbh = new PDO("mysql:host=$sv;dbname=$db",$un,$pw);

if(isset($_POST['toDelete'])){
    $stmt=$dbh->prepare("DELETE FROM Groups WHERE name=?");
    $stmt2 = $dbh->prepare("SELECT id FROM Groups WHERE name=?");
    $stmt3=$dbh->prepare("DELETE FROM AlertToGroup WHERE groupID=?");
    $stmt4 = $dbh->prepare("DELETE FROM UserToGroup WHERE groupID=?");
    
    foreach($_POST['toDelete'] as $u){
        
        $stmt2->execute(array($u));
        $id=$stmt2->fetch();
        $stmt3->execute(array($id[0]));
        $stmt4->execute(array($id[0]));
        
        $stmt->execute(array($u));
    }
}

require '../header.php';
function printGroupsCheckbox($dbh){
    
    $q = $dbh->query('SELECT name FROM Groups');
    $res = $q->fetchAll();
    
    foreach($res as $u){
        echo "<div class='groupCheck'><input type='checkbox' name='toDelete[]' value='$u[0]'>".$u[0]."</div>";
        
    }
    
}
?>
<div class='checkboxCont'>
	<form method="post" action="#">
		<?php printGroupsCheckbox($dbh); ?>
		<input type='submit' value='Delete groups'>
	</form>
</div>