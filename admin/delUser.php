<?php
require '../dblogin.php';
$dbh = new PDO("mysql:host=$sv;dbname=$db",$un,$pw);

if(isset($_POST['toDelete'])){
    $stmt=$dbh->prepare("DELETE FROM Users WHERE mail=?");
    foreach($_POST['toDelete'] as $u){
        $stmt->execute(array($u));
    }
}

require '../header.php';
require 'printUsersCheckboxF.php';
?>
<div class='checkboxCont'>
	<form method="post" action="#">
		<?php printUsersCheckbox($dbh); ?>
		<input type='submit' value='Delete users'>
	</form>
</div>