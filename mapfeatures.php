<?php
	include 'includes/header.php';
	
		checkSession($conn); //Checks Session Then Compares UserId With Username to confirm they are right.
		checkDetails($conn, $_SESSION['userid']); //Checks Whether User Has Set Extra Details

?>
	<script src='validation/mapJS.js'></script>
		<div id="bigbox">
				<div id="bigboxcontentholder">
				<fieldset>
				<legend>Map</legend>     
	<?php
	//Detects Whether A Message Needs To Be Displayed From The Delete Item Page.
	if(isset($_SESSION['message'])){
		//Displays The Message
		$success = $_SESSION['message'];
		
		//Unsets It Since It Isn't Needed
		unset($_SESSION['message']);
	}
				if(!(empty($success))){
				?>
				<div class="success"><?php echo $success ?></div>
				<?php
				}
				?>	
    <div id='map-canvas'>
      Google Map will go here!.
    </div>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAdGm2QKA8PiqPqWd3lK3RePygw-JNcBKY&sensor=true&libraries=places,weather"
        async defer>
    </script>
				</fieldset>
				</div>
				</div>
		</div>
<?php
	include 'includes/footer.php';
?>