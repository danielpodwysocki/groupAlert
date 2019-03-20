


<?php
    require '../header.php';
    require "alertToGroupH.php";
    $a = new AlertToGroup();
    echo "<div class='assignCont'>";
        echo "<div class='assignOne'>";    
            $a->printAlerts();
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