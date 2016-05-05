<?php
	
	session_start();
	session_destroy();
	
	include 'includes/header.php';
	
?>
		<div id="bigbox">
				<div id="bigboxcontentholder">
				<fieldset>
				<legend>Log Out</legend>
				<h3>You Have Logged Out</h3>
				<p> Logged Out </p>
				</fieldset>
				</div>
		</div>
<?php
	include 'includes/footer.php';
?>