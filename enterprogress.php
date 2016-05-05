<?php
	include 'includes/header.php';	
		checkSession($conn); //Checks Session Then Compares UserId With Username to confirm they are right.
		checkDetails($conn, $_SESSION['userid']); //Checks Whether User Has Set Extra Details
		
		$userid = $_SESSION['userid'];
	
	$problem = "";
	$success = "";
	
	//Detects Whether A Message Needs To Be Displayed From The Delete Item Page.
	if(isset($_SESSION['message'])){
		//Displays The Message
		$success = $_SESSION['message'];
		
		//Unsets It Since It Isn't Needed
		unset($_SESSION['message']);
	}
	
	if(isset($_POST['register2submit'])){	
	$passed = true;
			$stoneweight = mysqli_real_escape_string($conn, trim($_POST['stoneweight']));
			$poundweight = mysqli_real_escape_string($conn, trim($_POST['poundweight']));
			$time = mysqli_real_escape_string($conn, trim($_POST['time']));
			
			//Checks To See If Fields Are Empty
			if(isEmpty($stoneweight) == true){
			$fieldname = "Stone";
			$problem = outputError($problem, $fieldname);
			$passed = false;
			}
			if(isEmpty($poundweight) == true){
			$fieldname = "Pound";
			$problem = outputError($problem, $fieldname);
			$passed = false;
			}
			if(isEmpty($time) == true){
			$fieldname = "Time";
			$problem = outputError($problem, $fieldname);
			$passed = false;
			}	

			// Adds Zero If PoundWeight is Lower Than Ten So There Is Consistency in the Database (11st 2 -> 11st 02)
			if($poundweight < 10){
				$zero = 0;
				$poundweight = "{$zero}{$poundweight}";
			}
			// Used to output to the user that for every 14 pounds makes a stone. Consistency to tell the user.
			if($poundweight >= 14){
				$passed = false;
				$problem = "You cannot have more than 14 In a pound!";
			}
	
			if($passed == true){	
			$insertDetails = "INSERT INTO gymtime(userid, timeSpent, newstone, newpound) VALUES (?, ?, ?, ?)";
			$detailsStatement = $conn->prepare($insertDetails);
			$detailsStatement->bind_param("isii", $i, $t, $s, $p);
			$i = $userid;
			$t = $time;
			$s = $stoneweight;
			$p = $poundweight;
			$detailsStatement->execute();
			$detailsStatement->close();
			
			$weightUpdate = "UPDATE userdetails SET stone=?, pound=? WHERE userid=?";
			$stmt = $conn->prepare($weightUpdate);
			$stmt->bind_param('iii', $stoneweight, $poundweight, $userid);
			$stmt->execute();
			
			if($stmt->errno){
				echo "PROBLEM" . $stmt->errno;
			}
			else echo "Updated {$stmt->affected_rows} rows";
			
			$success = "Your Time And Weight Has Been Added!";
			}
	}	
	echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>';
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
				<p class="inputtext">Enter Weight(st):<input class="makefullsize" type="number"  id="stoneweight" name="stoneweight" value="" min="1" max="30"></p>	
				<p class="inputtext">Enter Weight(lbs):<input class="makefullsize" type="number"  id="poundweight" value="" name="poundweight"></p>
				<p class="inputtext">Enter Time(Minutes):<input class="makefullsize" type="text" id="time" name="time" value=""  /></p>
				<input type="submit" id="register2submit" name="register2submit" class="submitbutton" value="submit">
				</form>
				
				<form id="dataform" name="dataform" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				<div id="progresstable">					
					<div class="first">
					<div class="tableheader">
					<p>Time At Gym</p>
					</div>
					</div>
					<div class="tableheader">
					<p>Weight</p>
					</div>
					<div class="tableheader">
					<p>Time At</p>
					</div>
					<div class="tableheader">
					<p>Option</p>
					</div>

					<?php 
					$sql = "SELECT * FROM gymtime  where userid = '$userid' ORDER by dayGym";
					$result = $conn->query($sql);
					if ($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
						$outputstone = $row["newstone"];
						$outputpound = $row["newpound"];
						$outputweight = "{$outputstone}st {$outputpound}lbs";
					?>
					<div class="first">
					<div class="tablerow">
					<p><?php echo $row["timeSpent"]; ?></p>
					</div>
					</div>
					<div class="tablerow">
					<p><?php echo $outputweight ?></p>
					</div>
					<div class="tablerow">
					<p><?php echo $row["dayGym"]; ?></p>
					</div>
					<div class="tablerow">
					<br />
					<a href="deleteitem.php?delete=<?php echo $row["gymtimeid"];?>"/>Delete</a>
					</div>		
					<?php
					}
					} else {
					echo "0 results";
					}
					?>
					
				</div>
				</form>
				</fieldset>
				</div>
		</div>
<?php
	include 'includes/footer.php';
?>