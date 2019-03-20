<html>
<head>
	<meta charset="utf-8"/>
	     <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script> 
	     
</head>
<body>




<?php
    require '../header.php';
    require "userToGroupH.php";
    
    
    $a = new UserToGroup();
    

    echo "<div class='assignCont'>";
        echo "<div class='assignOne'>";
            $a->printGroups();
        echo "</div>";
        
        echo "<div class='assignBorder'></div>";
        
        echo "<div class='assignTwo'>";
            $a->printGroupsCheckbox();
        echo "</div>";
    echo "</div>";
    
    echo "<script src='assignOnClick.js'></script>";
    


?>


</body>
</html>