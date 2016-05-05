<?php
	include 'includes/header.php';
		checkSession($conn); //Checks Session Then Compares UserId With Username to confirm they are right.
		checkDetails($conn, $_SESSION['userid']); //Checks Whether User Has Set Extra Details
?>
	<script src='validation/locationJS.js'></script>
		<div id="bigbox">
				<div id="bigboxcontentholder">
				<fieldset>
				<legend>Map</legend>     
				</div>
    <div id='map-canvas'>
      Google Map will go here!.
    </div>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAdGm2QKA8PiqPqWd3lK3RePygw-JNcBKY&sensor=true&libraries=places,weather"
        async defer>
    </script>
				</fieldset>
				</div>
		</div>
<?php
	include 'includes/footer.php';
?>