<html>
<head>
<title>JustGYM | View Location</title>
<link rel="stylesheet" type="text/css" href="includes/normalizer.css" />
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css" />
<script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.1.3.min.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/jquery.validate.min.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/additional-methods.min.js"></script>
<script src="validation/validation.js"></script>
<link rel="shortcut icon" href="includes/favicon.ico" type="image/x-icon">
<link rel="icon" href="includes/favicon.ico" type="image/x-icon">
<script>
function goBack() {
    window.history.back();
}
</script>	
<?php
include 'connect.php';
include 'function.php';
?>
</head>
<body>
	<header>
	<img src="includes/logo.png" alt="Logo" title="Logo">
	</header>
	<div id="navigation">
		<ul>
		<?php if(returnCheckSession() == true) //checks to see if user has session set
		{
		?>
		<li><a href="login.php" title="#">Login</a></li>
		<li><a href="register.php" title="#">Register</a></li>
		<?php
		} else {
		?>
		<li><a href="loggedin.php" title="Homepage">Home</a></li>
		<li><a href="register2.php" title="My Details">My Details</a></li>		
		<!-- <li><a href="viewlocation.php" title="#">Location</a></li> -->
		<li><a href="viewdirections.php" title="Directions">Directions</a></li>
		<li><a href="mapfeatures.php" title="Gyms Around Me">View GYMs</a></li>
		<li><a href="entergymdata.php" title="My BMI">My Bmi</a></li>
		<li><a href="enterprogress.php" title="#">Add Progress</a></li>
		<li><a href="graphtime.php" title="#">My Graphs</a></li>
		<li><a href="logout.php" title="#">Logout</a></li>
		<?php
		}
		?>
		</ul>
	</div>
