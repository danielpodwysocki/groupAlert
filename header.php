<!DOCTYPE html>
<html>
    <head>
    	<meta charset='utf-8'/>
    	
		<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=ZCOOL+XiaoWei" rel="stylesheet">
    	<link rel='stylesheet' href='/groupAlert/style.css'/>
		<script src='//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
    	
    	
    	<title>groupAlert</title>
    </head>
    <body>
		<header>

				<?php 
				$location='';
				if(isset($_GET['location'])) $location='?location='.$_GET['location'];
				echo "<h1><a href='/groupAlert/admin/alertsRedirect.php$location'>groupAlert</a></h1>";
				session_start();
				    if(isset($_SESSION['uid'])){
				        
				echo <<<END
                <ul>
					<li><a href='/groupAlert/admin/addAlert.php$location'>Add an alert</a></li>
					<li><a href='/groupAlert/admin/delAlert.php$location'>Del an alert</a></li>
                    <li><a href='/groupAlert/admin/addUser.php$location'>Add a user</a></li>
					<li><a href='/groupAlert/admin/delUser.php$location'>Del a user</a></li>
					<li><a href='/groupAlert/admin/addGroup.php$location'>Add a group</a></li>
					<li><a href='/groupAlert/admin/delGroup.php$location'>Del a group</a></li>
					<li><a href='/groupAlert/admin/alertToGroup.php$location'>Add an alert to a group</a></li>
					<li><a href='/groupAlert/admin/userToGroup.php$location'>Add a user to a group</a></li>
                    <li><a href='/groupAlert/admin/alertsRedirect.php$location'>Alerts</a></li>
                    <li><a href='/groupAlert/admin/logout.php$location'>Logout</a></li>
                </ul>
			
END;
				    }else{
				        session_destroy();
				        echo <<<END
				        <ul>
                            <li><a href='/groupAlert/admin/login.php$location'>Manage</a></li>
                            <li><a href='/groupAlert/admin/alertsRedirect.php$location'>Alerts</a></li>

                        </ul>
END;
				    }
				        session_abort();
				?>

		</header>
	