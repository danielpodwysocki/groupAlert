<html>
<head>
	<meta charset="utf-8"/>
	     <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script> 
</head>
<body>




<?php
    require "alertToGroupH.php";
    $a = new AlertToGroup();
    
   
    $a->printAlerts();
    $a->printGroupsCheckbox();

    

?>


</body>
</html>