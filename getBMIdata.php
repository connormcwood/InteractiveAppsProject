<?php
	include 'includes/connect.php';
	include 'includes/function.php';	
	if(request_is_same_domain() == true){
	$amountOfMonth = mysqli_real_escape_string($conn, trim($_POST['graphTime']));
	$givenId = mysqli_real_escape_string($conn, trim($_POST['userId']));
	$heightsql = "SELECT foot, inch FROM userdetails where userid = '$givenId'";
	$heightresult = $conn->query($heightsql);
	if($heightresult->num_rows > 0){
	while($heightrow = $heightresult->fetch_assoc()){
		$foot = $heightrow["foot"];
		$inch = $heightrow["inch"];
	}
	} else {
	echo "NONE";
	}
	
	$timeScale = "";
	//User Input For Six Or Twelve Months
	if($amountOfMonth == 6){
		$timeScale = date('Y-m-d', strtotime('-6 months'));
	} else if($amountOfMonth == 12){
		$timeScale = date('Y-m-d', strtotime('-12 months'));
	}

	$sql = "SELECT newstone, newpound, dayGym FROM gymtime where dayGym >= '$timeScale' AND dayGym < NOW() AND userid = '$givenId' ORDER by dayGym";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		// output data of each row

	$bmiValue = array();
	$gymDate = array();
    while($row = $result->fetch_assoc()) {
		$stone = $row["newstone"];
		$pound = $row["newpound"];
		
		//Formula to workout BMI
		$newHeight = ($foot * 12) + $inch;
		$newWeight = ($stone * 14) + $pound;
		$sum = $newWeight / ($newHeight * $newHeight);
		$overallsum = $sum * 703;
		array_push($bmiValue, $overallsum);
		$date_entered = date("d-m", strtotime($row["dayGym"])); 
		array_push($gymDate, $date_entered);

    }
	} else {
    echo "0 results";
	}
	$arr = array('bmiValue'=>$bmiValue, 'gymDate'=>$gymDate);
	print_r(json_encode($arr));
	}
?>