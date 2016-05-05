<?php
	include 'includes/header.php';
		checkSession($conn); //Checks Session Then Compares UserId With Username to confirm they are right.
		checkDetails($conn, $_SESSION['userid']); //Checks Whether User Has Set Extra Details

	//Stores The Session's As Variables
	$username = $_SESSION['username'];
	$userid = $_SESSION['userid'];
?>
		<div id="bigbox">
				<div id="bigboxcontentholder">
				<fieldset>
				<legend>Homepage</legend>
				<h3>	 Welcome Back <?php echo $username ?> </h3>
				<p> The background is consistent throughout all the webpages on the website and this therefore allows users to get used to navigating with the website as they know the context of the 
					website is going to be in the center underneath the blue header and above the blue footer. The style of this website is blue to allow it to look modern and catch on the eye. </p>
				<h3>	 Usability Consideration:  </h3>
				<p> Content Text</p>
				<h3>	 Legal Consideration:  </h3>
				<p> Text  </p>
				</fieldset>
				</div>
		</div>
<?php
	include 'includes/footer.php';
?>