<!DOCTYPE html>
<html>
<head>
	<meta charset='utf-8'/>
	<link rel='stylesheet' href='alerts.css'/>
</head>
<body>
	<?php
	require "alertsH.php";
    $a = new sendAlert;
    $a->printAlerts();
	
	?>
</body>
</html>
