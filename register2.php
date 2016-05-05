<?php
	include 'includes/header.php';	
		checkSession($conn); //Checks Session Then Compares UserId With Username to confirm they are right.
	
	//Turns the sessions into variables so they can be handled with easier.
	$userid = $_SESSION['userid'];
	$username = $_SESSION['username'];
	//Sets these variables as nothing as if there are no entries within the database
	//then this will be set. If not the information will be loaded in.
	$problem = "";
	$success = "";
	$foot = "";
	$inch = "";
	$stone = "";
	$pound = "";
	$gym = "";
	
	$idName = "gym"; //Sets the name of the Id for the function below.
	if(isset($_POST['register2submit'])){	
	$passed = true; //Sets Passed True, If any conditions are not met then they are set to false thus preventing a query.
	//Prevents unwanted characters from being posted and set as a variable. Removes any unwanting information and stores as variable.
			$footheight = mysqli_real_escape_string($conn, trim($_POST['footheight']));
			$inchheight = mysqli_real_escape_string($conn, trim($_POST['inchheight']));
			$stoneweight = mysqli_real_escape_string($conn, trim($_POST['stoneweight']));
			$poundweight = mysqli_real_escape_string($conn, trim($_POST['poundweight']));
			$gym = mysqli_real_escape_string($conn, trim($_POST['gym']));
			
			//Checks To See If Fields Are Empty Using The isEmpty field from /includes/function.php
			if(isEmpty($footheight) == true){
			$fieldname = "Foot";
			$problem = outputError($problem, $fieldname);
			$passed = false;
			}
			//Checks To See If Fields Are Empty Using The isEmpty field from /includes/function.php
			if(isEmpty($inchheight) == true){
			$fieldname = "Inch";
			$problem = outputError($problem, $fieldname);
			$passed = false;
			}
			//Checks To See If Fields Are Empty Using The isEmpty field from /includes/function.php
			if(isEmpty($stoneweight) == true){
			$fieldname = "Stone";
			$problem = outputError($problem, $fieldname);
			$passed = false;
			}
			//Checks To See If Fields Are Empty Using The isEmpty field from /includes/function.php
			if(isEmpty($poundweight) == true){
			$fieldname = "Pound";
			$problem = outputError($problem, $fieldname);
			$passed = false;
			}
			//Checks To See If Fields Are Empty Using The isEmpty field from /includes/function.php
			if(isEmpty($gym) == true){
			$fieldname = "Gym";
			$problem = outputError($problem, $fieldname);
			$passed = false;			
			}	
			//Checks Whether It Is Between Given Values
			if(isBetween($footheight, 1, 8) == false){
			$fieldname = "Foot";
			$problem = outputErrorBetween($fieldname, 1, 8);
			$passed = false;
			}
			//Checks Whether It Is Between Given Values
			if(isBetween($inchheight, 0, 12) == false){
			$fieldname = "Inch";
			$problem = outputErrorBetween($fieldname, 0, 12);
			$passed = false;
			}
			//Checks Whether It Is Between Given Values
			if(isBetween($stoneweight, 1, 30) == false){
			$fieldname = "Stone";
			$problem = outputErrorBetween($fieldname, 1, 30);
			$passed = false;
			}
			//Checks Whether It Is Between Given Values
			if(isBetween($poundweight, 0, 14) == false){
			$fieldname = "Pound";
			$problem = outputErrorBetween($fieldname, 0, 14);
			$passed = false;
			}
			
			
			
			//If All Criteria is met then Passed is true
			if($passed == true){
						//Changes Chosen Gym Into Its Id so it can be stored into the database
						$sql = "SELECT gymid FROM gyms WHERE gymaddress = '$gym'";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
						// output data of each row
						while($row = $result->fetch_assoc()) {
						$gymid = $row["gymid"];
						}
						} else {
						echo "0 results";
						}
						mysqli_free_result($result);
			
				// Updates Userdetails with the given Height and Weight.
				$userid = $_SESSION['userid'];
				$updateDetails = "UPDATE userdetails SET foot='$footheight', inch='$inchheight', stone='$stoneweight', pound='$poundweight', gymid='$gymid' WHERE userid = '$userid'";
				$result = mysqli_query($conn, $updateDetails); //Retrieves Input And Adds To Database
				
				$updateDetailsAdded = "UPDATE users SET detailsAdded='1' WHERE userid = '$userid'";
				$result2 = mysqli_query($conn, $updateDetailsAdded);
			}
	}
	//Loads the data in using the retrieveDetailsId function in /includes/function.php
	if(retrieveDetailsId($conn, $userid) == 1){			
		//Adds the data into the database
		$success = "Welcome Back {$username} Your Data Has Been Loaded In";
		$details = getDetails($conn, $userid);
		if($details){
		$foot = $details['foot'];
		$inch = $details['inch'];
		$stone = $details['stone'];
		$pound = $details['pound'];
		} else {
		echo "NONE";
		}	
	}	
?>
		<div id="bigbox">
				<div id="bigboxcontentholder">
				<fieldset>
				<legend>Edit Profile</legend>
				<button class="backbutton" onClick="goBack()">Back</button>
				<?php
				if(!(empty($problem))){
				?>
				<div class="warning"><?php echo $problem ?></div>
				<?php
				}
				?>
				
				<?php
				if(!(empty($success))){
				?>
				<div class="success"><?php echo $success ?></div>
				<?php
				}
				?>	
				<form id="register2-form" name="register2form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				<p class="inputtext">Enter Height (foot): <input class="makefullsize" type="number" id="footheight" name="footheight" value="<?php echo $foot; ?>"></p> 
				<p class="inputtext">Enter Height (inch): <input class="makefullsize" type="number" id="inchheight" name="inchheight" value="<?php echo $inch; ?>"></p>
				<p class="inputtext">Enter Weight(st):<input class="makefullsize" type="number"  id="stoneweight" name="stoneweight" value="<?php echo $stone; ?>"></p>	
				<p class="inputtext">Enter Weight(lbs):<input class="makefullsize" type="number"  id="poundweight" value="<?php echo $pound; ?>" name="poundweight"></p>
				<p class="inputtext">Gym:<?php gymSelectBox($conn, $idName);?></p>
				<input type="submit" id="register2submit" name="register2submit" class="submitbutton" value="submit">
				</form>
				</fieldset>
				</div>
		</div>
<?php
	include 'includes/footer.php';
?>