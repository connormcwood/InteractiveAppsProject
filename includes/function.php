<?php
	//Returns Whether Value Is Between Given Variables
	function isBetween($givenValue, $lowValue, $highValue){
		if($givenValue >= $lowValue && $givenValue <= $highValue){
			return true; //Is Between These Values
		} else {
			return false; //Isn't Between These Values
		}
	}
	//Used To Determine Whether The Field Is Empty, Returns True If It Is Empty & False If It Contain Something
	function isEmpty($variableBeingChecked){
		if(empty($variableBeingChecked) || $variableBeingChecked == '')
		{
			return true; //True because they are empty or equal to nothing
		} else {
			return false;	//False because they are not.
		}
	}
	//Check To See If It Contains Number
	function containNumber($inputField){
		$number = preg_match('@[0-9]@', $inputField);
		if($number) {
			return true;
		}
	}
	
	//Retrieves Whether DetailsId is equal to 1 or 0. 1 Represents Details Being Added.
	function retrieveDetailsId($conn, $userid){
		    if($stmt = mysqli_prepare($conn, "SELECT detailsAdded FROM users WHERE userid =?")){
				mysqli_stmt_bind_param($stmt, 'i', $userid);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_bind_result($stmt, $detailsValue);
				mysqli_stmt_fetch($stmt);
				mysqli_stmt_close($stmt);				
				return $detailsValue;
			}	
	}
	//Used To Select All The Available Gyms From The Database And Output Them In The Form Of A Select Options.
	//SelectId Parameters Allows For A More Dynamic Function. Could Use End for Google Maps or Start For Google Maps.
	function gymSelectBox($conn, $selectId){
	$sql = "SELECT * FROM gyms";
	$result = $conn->query($sql);
	echo "<select id='$selectId' name='$selectId' class='makefullsize'>";
	if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		  echo "<option value=\"".$row["gymaddress"]."\">".$row["gymname"]."</option>"; 
	}
	} else {
    echo "0 results";
	}
	echo "</select>";
	mysqli_free_result($result); //Frees The Resourses Used. (Discards Information)
	}
	//If User Has Not Set Details Header Them To Register 2 Page.
	function checkDetails($conn, $userid){
		if(retrieveDetailsId($conn, $userid) == 0){
			//Hasn't Set Details
			header ("Location: register2.php");
		} else {
			//Has Set Details
		}
	}
	
	//Checks Whether Request Came From Same Site.
	function request_is_same_domain() {
	if(!isset($_SERVER['HTTP_REFERER'])) {
		// No refererer sent, so can't be same domain
		return false;
	} else {
		$referer_host = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
		$server_host = $_SERVER['HTTP_HOST'];
		return ($referer_host == $server_host) ? true : false;
		}
	}
	//Outputs Information To User
	function outputError($outputVariableName, $fieldName){
	$problem = "Your {$fieldName} field appears to be empty.";
		return $problem;
	}
	
	//Outputs Information To User
	function outputErrorBetween($fieldName, $lowValue, $highValue){
	$problem = "Your {$fieldName} field is not between {$lowValue} And {$highValue}.";
		return $problem;
	}
	
	function encrypt($password){
	// use blowfish algorithm 10 times
	$hash_format="$2a$10$";
	$salt_length=22;
	$salt = generate_salt($salt_length);
	// store this in DB
	$format_and_salt = $hash_format . $salt ;
	$hash = crypt($password, $format_and_salt);
	return $hash;
	}
	
	function generate_salt($length){
	// return 32 character random string
	$unique_string = md5(uniqid(mt_rand(), true));
	// provides valid characters
	$base64_string = base64_encode($unique_string);
	// replaces + with .
	$mod_base64_string = str_replace('+', '.', $base64_string );
	// make string correct length
	$salt = substr($mod_base64_string, 0, $length);
	return $salt;
	}
	
	//Retrieves User's Information From User Table
	function getUser($conn, $username){	
	$query = "SELECT * FROM users WHERE username = '$username'";	
	$user_data = mysqli_query($conn, $query);	
	if($user = mysqli_fetch_assoc($user_data)){
		return $user;
		
	} else {
		return null;
	}
	}
	
	//Retrieves User's Information From Userdetails Table
	function getDetails($conn, $userid){
	$query = "SELECT * FROM userdetails WHERE userid = '$userid'";
	$user_data = mysqli_query($conn, $query);
	if($user = mysqli_fetch_assoc($user_data)){
		return $user;
		
	} else {
		return null;
	}	
	}

	
	//Retrieves The User's Id from the Database
	function getUserId($conn, $username){
	$id = "";
	$query = "SELECT userid from users WHERE username = '$username'";
	$resultID = mysqli_query($conn, $query) or die($query."<br/><br/>".mysql_error());
	if($resultID == false){
	echo "ERROR1";
	}
	else {
		foreach($resultID as $row){
		$id = $row['userid'];
			return $id;
		}	
	}
	}
	
	//Detects Whether Details Have Been Added (Boolean)
	function getDetailsAdded($conn, $userid){
	$detailsAdded = 0;
	$query = "SELECT detailsAdded from users WHERE userid = '$userid'";
	$resultID = mysqli_query($conn, $query) or die($query."<br/><br/>".mysqli_error());
	if($resultID == false){
	echo "ERROR1";
	}
	else {
		foreach($resultID as $row){
		$detailsAdded = $row['detailsAdded'];
			return $detailsAdded;
		}	
	}
	}
	
	//Function used to compare the Username Session to the ID session to validate the user (Still Insecure)
	function checkUsernameAgainstId($conn, $username, $userid){
	$query = "SELECT * from users WHERE username = '$username' AND userid = '$userid'";
	$result = mysqli_query($conn, $query);
	if($result == false){
		// echo "DOES NOT MATCH";
			header("Location: ../InteractiveAppsProject/logout.php");		
		return false;
	} else {
		// echo "DOES MATCH";
		return true;
	}
	}

	
	
	//Essentially a boolean. Checks password against variable and returns true or false.
	function attemptLogin($conn, $username, $password){
 	$userDetails = getUser($conn, $username);	
	if($userDetails){
		if(password_check($password, $userDetails["password"])){
			createSession($userDetails);
			return true;		
	} else  {
		return false;
			}
	}
}
function getAge($dob) {
    //calculate years of age (input string: YYYY-MM-DD)
    list($day, $month, $year) = explode("/", $dob);

    $day_diff   = date("d") - $day;
    $month_diff = date("m") - $month;
	$year_diff  = date("Y") - $year;

    if ($day_diff < 0 || $month_diff < 0)
        $year_diff--;

    return $year_diff;
}

function createSession($userDetails){
	$_SESSION['login'] = true;
	$_SESSION['username'] = $userDetails["username"];
	$_SESSION['userid'] = $userDetails["userid"];
}

function checkSession($conn){
	if (!(isset($_SESSION['login']) && $_SESSION['login'] != '' && (isset($_SESSION['username'])) && (isset($_SESSION['userid'])))) {
	header ("Location: login.php");
	}
	checkUsernameAgainstId($conn, $_SESSION['username'], $_SESSION['userid']);
}
function returnCheckSession(){
	if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	return true; //No Session
	} else {
	return false;
	}
}
function password_check($password, $existHash){
$hash = crypt ($password, $existHash);

if($hash == $existHash){
	return true;
} else {
	return false; 
	}

}


?>