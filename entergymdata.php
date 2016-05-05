<?php
	include 'includes/header.php';	
		checkSession($conn); //Checks Session Then Compares UserId With Username to confirm they are right.
		checkDetails($conn, $_SESSION['userid']); //Checks Whether User Has Set Extra Details
		
		$userid = $_SESSION['userid'];
	
	$problem = "";
	$success = "";
	$foot = "";
	$inch = "";
	$stone = "";
	$pound = "";
	
	if(isset($_POST['register2submit'])){	
	$passed = true;
			$footheight = mysqli_real_escape_string($conn, trim($_POST['footheight']));
			$inchheight = mysqli_real_escape_string($conn, trim($_POST['inchheight']));
			$stoneweight = mysqli_real_escape_string($conn, trim($_POST['stoneweight']));
			$poundweight = mysqli_real_escape_string($conn, trim($_POST['poundweight']));
			
			//Checks To See If Fields Are Empty
			if(isEmpty($footheight) == true){
			$fieldname = "Foot";
			$problem = outputError($problem, $fieldname);
			$passed = false;
			}
			//Checks To See If Fields Are Empty
			if(isEmpty($inchheight) == true){
			$fieldname = "Inch";
			$problem = outputError($problem, $fieldname);
			$passed = false;
			}
			//Checks To See If Fields Are Empty
			if(isEmpty($stoneweight) == true){
			$fieldname = "Stone";
			$problem = outputError($problem, $fieldname);
			$passed = false;
			}
			//Checks To See If Fields Are Empty
			if(isEmpty($poundweight) == true){
			$fieldname = "Pound";
			$problem = outputError($problem, $fieldname);
			$passed = false;
			}			
			if($passed == true){	
				
			}
	}
	if(retrieveDetailsId($conn, $userid) == 1){
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
				<legend>Enter GYM Data</legend>
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
				<form id="bmicalculate-form" action="#" method="post">
				<p class="inputtext">Enter Height (foot): <input type="text"  class="makefullsize" id="footheight" name="footheight" value="<?php echo $foot; ?>" required></p> 
				<p class="inputtext">Enter Height (inch): <input type="text" class="makefullsize" id="inchheight" name="inchheight" value="<?php echo $inch; ?>" required></p>
				<p class="inputtext">Enter Weight(st):<input type="text" class="makefullsize" id="stoneweight" name="stoneweight" value="<?php echo $stone; ?>" required></p>	
				<p class="inputtext">Enter Weight(lbs):<input type="text" class="makefullsize" id="poundweight" name="poundweight" value="<?php echo $pound; ?>" required></p>								
				<input type="button" id="bmicalculatesubmit" value="Check your BMI"><input type="submit" id="bmireset" value="Reset">
				<br />
				<div class="inputtext" id="bmivalue"></div>
				</form>
				</fieldset>
				</div>
		</div>
<?php
	include 'includes/footer.php';
?>