<?php
	include 'includes/connect.php';
	include 'includes/function.php';

	//Make Sure The Post Came From The Same Website
	if(request_is_same_domain() == true){
		
	//Retrieves The User's UserId
	$givenId = mysqli_real_escape_string($conn, trim($_POST['userId']));
	
	//Creates The Time One Week From Today
	$timeScale = date('Y-m-d', strtotime('-1 week'));
	//Displays Data From Within A Week And Where It is Related To The User. Orders By dayGym(Time)
	$sql = "SELECT timeSpent, dayGym FROM gymtime  where dayGym >= '$timeScale' AND dayGym < NOW() AND userid = '$givenId' ORDER by dayGym";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
    // output data of each row

	//Creates The Array To Pass Back Via Json
	$timeSpent = array();
	$gymDate = array();
    while($row = $result->fetch_assoc()) {
		//Puts The Data Within The Multi-Dimensional Array
		array_push($timeSpent, $row["timeSpent"]);
		$date_entered = date("d-m", strtotime($row["dayGym"])); 
		array_push($gymDate, $date_entered);

    }
	} else {
    echo "0 results";
	}
	//Puts The Data Within The Json Encode And Then Outputs it.
	$arr = array('timeSpent'=>$timeSpent, 'gymDate'=>$gymDate);
	print_r(json_encode($arr));
	}
?>