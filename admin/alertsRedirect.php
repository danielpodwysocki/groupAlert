<?php
if(isset($_GET['location'])){
    $location=$_GET['location'];
    header("Location: /groupAlert/alerts.php?location=$location");
}
?>