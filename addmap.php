<?php
include 'includes/connect.php';
//Not Secure. However If This Was To Be Developed
//Further I would Use Ajax To Secure The Data And Make Sure User's Can't Put Fake Data Within

//Retrieves Information From Get
$name = mysqli_real_escape_string($conn, trim($_GET['name']));
$address = mysqli_real_escape_string($conn, trim($_GET['address']));

$sql = "SELECT * FROM gyms WHERE gymname = '$name' AND gymaddress = '$address'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
// There Is An Instance Of This Gym And Address. Doesn't Need To Be Added!
} else {
// Not Already In Database
$addgym = "INSERT INTO gyms (gymname, gymaddress) VALUES ('$name', '$address')";
if($conn->query($addgym) == TRUE) {
// Gym Added To Database	
} else {
// Gym Hasn't Been Added	
}
}

//Retrieves The Id From The Created Gym
$retrieveGymId = "SELECT gymid FROM gyms WHERE gymname = '$name' AND gymaddress = '$address'";
$gymresult = $conn->query($retrieveGymId);
if($gymresult->num_rows > 0) {
//Retrieved Data
	while($row = $gymresult->fetch_assoc()) {
		$gymid = $row['gymid'];
	}
}
$userid = $_SESSION['userid'];
//Update New Gym Id To User
$updateDetails = "UPDATE userdetails SET gymid='$gymid' WHERE userid='$userid'";
$updateResult = mysqli_query($conn, $updateDetails);
$_SESSION['message'] = "The Gym Has Been Added And It Has Been Set As Your Preferred Gym.";
header("Location: ../InteractiveAppsProject/mapfeatures.php");	
?>