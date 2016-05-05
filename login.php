<?php
	include 'includes/header.php'; //Includes The Contents Of Header
	
	//Sets The Values Of These Variables To Nothing, Overwritten If There Is a Problem or Success
	$problem = "";
	$success = "";	
	
	//Checks To See If The Loginform Has Been Posted. 
	if(isset($_POST['loginform'])){	
		$passed = true; //Used To Determine Whether Query Should Go Ahead
		
		//Here we use the function to trim whitespace and to remove any special characters for security reasons.
		$username = mysqli_real_escape_string($conn, trim($_POST['username']));
		$password = mysqli_real_escape_string($conn, trim($_POST['password']));
		
		//Checks Whether Field Is Empty And Returns Information Back For User feedback.
		if(isEmpty($username) == true){
			$fieldname = "Username";
			$problem = outputError($problem, $fieldname);
			$passed = false;
		}
		//Checks Whether Field Is Empty And Returns Information Back For User feedback.
		if(isEmpty($password) == true){
			$fieldname = "Password";
			$problem = outputError($problem, $fieldname);
			$passed = false;
		}	
		if($passed == true){
		//Checks Whether The Username And Password Are Correct Using The AttemptLogin Function.
		if(attemptLogin($conn, $username, $password) == true){
			//Used To Give The User Feedback
			$success = "Welcome back ".$username." we have missed you!";			
			//Directs The User To The Logged In Area.
			header("Location: ../InteractiveAppsProject/loggedin.php");			
		} else {
			//Used To Tell The User There Was A Problem
			$problem = "Your username or password was incorrect.";
		}
	}
	}
?>
		<div id="bigbox">
				<div id="bigboxcontentholder">
				<fieldset>
				<legend>Login</legend>
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
				<form id="login-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				<p class="inputtext">Username:<input class="makefullsize" type="text" id="username" name="username" value="" required></p>
				<p class="inputtext">Password:<input class="makefullsize" type="password" id="password" name="password" value="" ></p>
				<p> Not A Member? <a href="register.php" title="Register" />Sign up here</a><input type="submit" id="loginform" name="loginform" class="submitbutton" value="submit"></p>
				
				</form>
				</fieldset>
				</div>
		</div>
<?php
	include 'includes/footer.php';
?>