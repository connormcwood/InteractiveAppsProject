<?php
	include 'includes/header.php';	
	
	$problem = "";
	$success = "";
	
	if(isset($_POST['registerform'])){
		$passed = true;
		
			//Strips The Inputted Data from the user of any special characters and whitespace.
			$firstname = mysqli_real_escape_string($conn, trim($_POST['firstname']));
			$secondname = mysqli_real_escape_string($conn, trim($_POST['secondname']));
			$username = mysqli_real_escape_string($conn, trim($_POST['username']));
			$email = mysqli_real_escape_string($conn, trim($_POST['email']));
			$password = mysqli_real_escape_string($conn, trim($_POST['password']));
			$password2 = mysqli_real_escape_string($conn, trim($_POST['password2']));
			$day = mysqli_real_escape_string($conn, trim($_POST['dob-day']));
			$month = mysqli_real_escape_string($conn, trim($_POST['dob-month']));
			$year = mysqli_real_escape_string($conn, trim($_POST['dob-year']));
		
		
		//Checks The Variable To Set If It Exists and is not empty.
		if(isEmpty($firstname) == true){
			$fieldname = "Firstname";
			$problem = outputError($problem, $fieldname);
			$passed = false;
		}
		//Check If It Contains Letters
		if(containNumber($firstname) == true){
			$passed = false;
			$problem = "First Name Field Shouldn't Contain Numbers";
		}
		//Checks Whether Field Is Empty And Returns Information Back For User feedback.
		if(isEmpty($secondname) == true){
			$fieldname = "Secondname";
			$problem = outputError($problem, $fieldname);
			$passed = false;
		}
		//Check If It Contains Letters
		if(containNumber($secondname) == true){
			$passed = false;
			$problem = "Second Name Field Shouldn't Contain Numbers";
		}
		//Checks Whether Field Is Empty And Returns Information Back For User feedback.
		if(isEmpty($username) == true){
			$fieldname = "Username";
			$problem = outputError($problem, $fieldname);
			$passed = false;
		}
		//Checks Whether Field Is Empty And Returns Information Back For User feedback.
		if(isEmpty($email) == true){
			$fieldname = "Email";
			$problem = outputError($problem, $fieldname);
			$passed = false;
		}
		//Checks Whether Field Is Empty And Returns Information Back For User feedback.
		if(isEmpty($password) == true){
			$fieldname = "Password";
			$problem = outputError($problem, $fieldname);
			$passed = false;
		}
		//Checks Whether Field Is Empty And Returns Information Back For User feedback.
		if(isEmpty($password2) == true){
			$fieldname = "Password2";
			$problem = outputError($problem, $fieldname);
			$passed = false;
		}
		//Checks Whether Field Is Empty And Returns Information Back For User feedback.
		if(isEmpty($day) == true){
			$fieldname = "Day";
			$problem = outputError($problem, $fieldname);
			$passed = false;
		}
		//Checks Whether Field Is Empty And Returns Information Back For User feedback.
		if(isEmpty($month) == true){
			$fieldname = "Month";
			$problem = outputError($problem, $fieldname);
			$passed = false;
		}
		//Checks Whether Field Is Empty And Returns Information Back For User feedback.
		if(isEmpty($year) == true){
			$fieldname = "Year";
			$problem = outputError($problem, $fieldname);
			$passed = false;
		}
		//Checks To See If The Email Is Valid
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$problem = "Your Email Is Invalid";
			$passed = false;
		}
		//Checks Whether The Username Exists By Comparing The User Variable To The Database To See If Any Values Occur
		if(getUser($conn, $username) == true){
			$problem = "{$username} is not available!";
			$passed = false;
		}
		//Checks Whether Firstname is not empty and whether it has a value. If it completes the check then escapes special characters to prevent scripts being inputted.		
		if(!($password == $password2)){
			$problem = "Your Password Fields Do Not Match.";
			$passed = false;
		}
		// Regular Expression (Regex)
		// Checks Whether Password Contains Upper, Lower, Numbers & is atleast 8 characters long.
		$uppercase = preg_match('@[A-Z]@', $password);
		$lowercase = preg_match('@[a-z]@', $password);
		$number    = preg_match('@[0-9]@', $password);
		if(!$uppercase || !$lowercase || !$number || strlen($password) < 8) {
			//Used To Give Feedback To The User
			$problem = "Your Passwod must start with a capital letter,contain text and numbers.";
			$passed = false; //Used To Tell The Server Whether To Go Along With The Query.
		}
		//Encrpts The Password Using The Encrypt Function In Function.php
		$encryptedPassword = encrypt($password);
	//Determines Whether Query Should Go Ahead(Met Previous Requirements) And Determines Whether The Request Is From The Same Server (This Site)
	if($passed == true && request_is_same_domain() == true){
	mysqli_autocommit($conn,FALSE); //Prevents Mysqli From Auto Committing. 

	//Prepared Statement
	$insertUser = "INSERT INTO users(username, password) VALUES (?,?)";
	$userStatement = $conn->prepare($insertUser); //Prepares The Database For An Incoming Insert
	$userStatement->bind_param("ss", $u, $p); //Binds The Parameters So They Are Strings In This Case
	//The Variables Which Are Being Binded.
	$u = $username;
	$p = $encryptedPassword;	
	$userStatement->execute(); //Executes The Insert Statement
	$userStatement->close(); //Closes The Statement
	
	//Logs The User In, Also Checks To Make Sure It Has Been Created. Provides Sessions.
	if(attemptLogin($conn, $username, $password) == true){
	//Feedback To The User
	$success = "Congratulations ".$firstname." your account, ".$username.", has been created!"; 
	}
	$userid = $_SESSION['userid'];
	//Builds The Birthday From The Register Form
	$buildbirthday = "{$day}/{$month}/{$year}";
	
	//Prepared Statement
	$insertDetails = "INSERT INTO userdetails(userid, firstname, lastname, birthdate, email) VALUES (?, ?, ?, ?, ?)";
	$detailsStatement = $conn->prepare($insertDetails);  //Prepares The Database For An Incoming Insert
	$detailsStatement->bind_param("issss", $i, $f, $n, $b, $e); //Binds The Parameters And Determines Whether The Parameters Are Equal To What They Are Expected To Be (Int, String x4)
	//The Variables Which Are Being Binded.
	$i = $userid;
	$f = $firstname;
	$n = $secondname;
	$b = $buildbirthday;
	$e = $email;
	$detailsStatement->execute(); //Executes The Insert Statement
	$detailsStatement->close(); //Closes The Statement

	//Feedback To The User
	$passed = "<a href='loggedin.php'>Click Here</a> To Skip Waiting.";
	//Redirects The User To Loggedin.php After 1 
	header( "Refresh:1; url=loggedin.php", true, 303);
	}	
	
	}	
?>

		<div id="bigbox">
				<div id="bigboxcontentholder">
				<fieldset>
				<legend>Register</legend>
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
				<form id="registration-form" name="registration-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				<p class="inputtext">Firstname:<input class="makefullsize" type="text" id="firstname" name="firstname" placeholder="First Name"></p>
				<p class="inputtext">Secondname:<input class="makefullsize" type="text" id="secondname" name="secondname" placeholder="Second Name"></p>
				<p class="inputtext">Email:<input class="makefullsize" type="email" id="email" name="email" placeholder="Enter Email"></p>
				<div class="control-group">
				<p class="inputtext">Date Of Birth:
	 <select name="dob-year" class="makedobsize3" id="dob-year">
      <option value="2003">2003</option>
      <option value="2002">2002</option>
      <option value="2001">2001</option>
      <option value="2000">2000</option>
      <option value="1999">1999</option>
      <option value="1998">1998</option>
      <option value="1997">1997</option>
      <option value="1996">1996</option>
      <option value="1995">1995</option>
      <option value="1994">1994</option>
      <option value="1993">1993</option>
      <option value="1992">1992</option>
      <option value="1991">1991</option>
      <option value="1990">1990</option>
      <option value="1989">1989</option>
      <option value="1988">1988</option>
      <option value="1987">1987</option>
      <option value="1986">1986</option>
      <option value="1985">1985</option>
      <option value="1984">1984</option>
      <option value="1983">1983</option>
      <option value="1982">1982</option>
      <option value="1981">1981</option>
      <option value="1980">1980</option>
      <option value="1979">1979</option>
      <option value="1978">1978</option>
      <option value="1977">1977</option>
      <option value="1976">1976</option>
      <option value="1975">1975</option>
      <option value="1974">1974</option>
      <option value="1973">1973</option>
      <option value="1972">1972</option>
      <option value="1971">1971</option>
      <option value="1970">1970</option>
      <option value="1969">1969</option>
      <option value="1968">1968</option>
      <option value="1967">1967</option>
      <option value="1966">1966</option>
      <option value="1965">1965</option>
      <option value="1964">1964</option>
      <option value="1963">1963</option>
      <option value="1962">1962</option>
      <option value="1961">1961</option>
      <option value="1960">1960</option>
      <option value="1959">1959</option>
      <option value="1958">1958</option>
      <option value="1957">1957</option>
      <option value="1956">1956</option>
      <option value="1955">1955</option>
      <option value="1954">1954</option>
      <option value="1953">1953</option>
      <option value="1952">1952</option>
      <option value="1951">1951</option>
      <option value="1950">1950</option>
      <option value="1949">1949</option>
      <option value="1948">1948</option>
      <option value="1947">1947</option>
      <option value="1946">1946</option>
      <option value="1945">1945</option>
      <option value="1944">1944</option>
      <option value="1943">1943</option>
      <option value="1942">1942</option>
      <option value="1941">1941</option>
      <option value="1940">1940</option>
      <option value="1939">1939</option>
      <option value="1938">1938</option>
      <option value="1937">1937</option>
      <option value="1936">1936</option>
      <option value="1935">1935</option>
      <option value="1934">1934</option>
      <option value="1933">1933</option>
      <option value="1932">1932</option>
      <option value="1931">1931</option>
      <option value="1930">1930</option>
      <option value="1929">1929</option>
      <option value="1928">1928</option>
      <option value="1927">1927</option>
      <option value="1926">1926</option>
      <option value="1925">1925</option>
      <option value="1924">1924</option>
      <option value="1923">1923</option>
      <option value="1922">1922</option>
      <option value="1921">1921</option>
      <option value="1920">1920</option>
      <option value="1919">1919</option>
      <option value="1918">1918</option>
      <option value="1917">1917</option>
      <option value="1916">1916</option>
      <option value="1915">1915</option>
      <option value="1914">1914</option>
      <option value="1913">1913</option>
      <option value="1912">1912</option>
      <option value="1911">1911</option>
      <option value="1910">1910</option>
      <option value="1909">1909</option>
      <option value="1908">1908</option>
      <option value="1907">1907</option>
      <option value="1906">1906</option>
      <option value="1905">1905</option>
      <option value="1904">1904</option>
      <option value="1903">1903</option>
      <option value="1901">1901</option>
	  <option value="1900">1900</option>
						</select>
   <select name="dob-month" class="makedobsize2" id="dob-month">
      <option value="01">January</option>
      <option value="02">February</option>
      <option value="03">March</option>
      <option value="04">April</option>
      <option value="05">May</option>
      <option value="06">June</option>
      <option value="07">July</option>
      <option value="08">August</option>
      <option value="09">September</option>
      <option value="10">October</option>
      <option value="11">November</option>
      <option value="12">December</option>
    </select>
	 <select name="dob-day" class="makedobsize" id="dob-day">
      <option value="01">01</option>
      <option value="02">02</option>
      <option value="03">03</option>
      <option value="04">04</option>
      <option value="05">05</option>
      <option value="06">06</option>
      <option value="07">07</option>
      <option value="08">08</option>
      <option value="09">09</option>
      <option value="10">10</option>
      <option value="11">11</option>
      <option value="12">12</option>
      <option value="13">13</option>
      <option value="14">14</option>
      <option value="15">15</option>
      <option value="16">16</option>
      <option value="17">17</option>
      <option value="18">18</option>
      <option value="19">19</option>
      <option value="20">20</option>
      <option value="21">21</option>
      <option value="22">22</option>
      <option value="23">23</option>
      <option value="24">24</option>
      <option value="25">25</option>
      <option value="26">26</option>
      <option value="27">27</option>
      <option value="28">28</option>
      <option value="29">29</option>
      <option value="30">30</option>
      <option value="31">31</option>
    </select>
   </p>
				<p class="inputtext">Username:<input class="makefullsize" type="text" id="username" name="username" placeholder="Username"></p>
				<p class="inputtext">Password:<input class="makefullsize" type="password" id="password" name="password" value=""></p>
				<p class="inputtext">ReType Password:<input class="makefullsize" type="password" id="password2" name="password2" value=""></p>
				<input type="submit" id="registerform" name="registerform" class="submitbutton" value="register">
				</form>
				</fieldset>
				</div>
		</div>
<?php
	include 'includes/footer.php';
?>