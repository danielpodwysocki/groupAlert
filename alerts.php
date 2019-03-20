
	<?php
	   require "header.php";
	
	   require "alertsH.php";
    

	?>
	<div class="alertCont">
		<?php 
		$a = new sendAlert;
		$a->printAlerts();
		
		?>	
		
	</div>
	<?php 
	   require "footer.php";
	?>	

