<?php
function printUsersCheckbox($dbh){

    $q = $dbh->query('SELECT mail FROM Users');
    $res = $q->fetchAll();
    
    foreach($res as $u){
        echo "<div class='groupCheck'><input type='checkbox' name='toDelete[]' value='$u[0]'>".$u[0]."</div>";
    
    }

}


?>