<?php
	include 'includes/header.php';
		checkSession($conn); //Checks Session Then Compares UserId With Username to confirm they are right.
		checkDetails($conn, $_SESSION['userid']); //Checks Whether User Has Set Extra Details

	$userid = $_SESSION['userid'];	
	
	$userid = $_SESSION['userid'];	
	$sql = "SELECT timeSpent, dayGym FROM gymtime where userid = '$userid'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
    // output data of each row
	$timeSpent = array();
	$gymDate = array();
    while($row = $result->fetch_assoc()) {
		array_push($timeSpent, $row["timeSpent"]);
		$date_entered = date("d-m", strtotime($row["dayGym"])); 
		array_push($gymDate, $date_entered);
    }
	} else {
    $problem = "You Haven't Inputted Any Data! Data Is Entered On The Enter Progress Page.<a href='enterprogress.php' class='regularlink'>Click Here</a>";
	}
?>
<script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.1.3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script>
		<div id="bigbox">
				<div id="bigboxcontentholder">
				<fieldset>
				<legend>Graph BMI</legend>
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
				<ul class="graph-list">
    <li class="graph-item"><a href="graphtime.php">Time</a></li>
	</ul>
				<div class="radio-graph">
<form>
 <input id="radio-2" class="radio-custom" type="radio" name="timeValue" value="0" checked>
  <label for="radio-2" class="radio-custom-label">6 Months</label>
  <input id="radio-1" class="radio-custom" type="radio" name="timeValue" value="1">
  <label for="radio-1" class="radio-custom-label">12 Months</label></br>
 
</form>
</div>
<div style="width: 50%">
			<canvas id="canvas" height="450" width="600"></canvas>
		</div>


	<script>

window.onload = function(){
	alert("Window Loaded");
	var ctx = document.getElementById("canvas").getContext("2d");
	window.myBar = new Chart(ctx).Line(barChartData, {
	responsive : true
	});
}
	
// in php you simply need to create the arrays with 12 months data and the functionality will work	
	
// monthly set to minutes
var myBMIMon = [25.5,26.2,25,25.1,25.8,26.2,25.5,26,26.8,27,26.9,27];
var myMonths = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];

var bmiData = new Array();
var bmiLabels = new Array();
var value = 6;

// default values to be displayed when the page loads
var myLabels =  myMonths;
var mydata =  myBMIMon;

// store value of radiobutton
var currentValue = 0;
var displayData=[];


// function called when radio button is pressed
$( ".radio-custom" ).on( "click", function() {
	
	var myitem = $( "input:checked" ).val();
	// prevent radio button being clicked twice
	
	if(currentValue!=myitem){
		currentValue=myitem;
		
	// check to see if need to convert to minutes or hours
	if(myitem ==0){
		getSix();
		
	} else {
		getTwelve();
	}
	}
});

function getSix(){	
	var value = 6;
	destroyChart();
	sendData(value);
	
}
	
function getTwelve(){
	var value = 12;
	destroyChart();
	sendData(value);
	
}



// destroy the chart so that it does not load on top of itself
function destroyChart(){
   window.myBar.destroy();
   buildChart();
}

function sendData(value){
	alert(value);
	alert("Sending Data");
	$.ajax({
		type: 'POST',
		dataType: "json",
		data: {
			userId:<?php echo $userid ?>,
			graphTime:value
			},

		url: 'getBMIdata.php',
		success: function(data){
			console.log(data);
			bmiData=data.bmiValue;
			alert(bmiData);
			bmiLabels=data.gymDate;
			alert(bmiLabels);
			
			buildChart();
			
		},
		error: function(){
			alert('Problem With Data');
			console.log(data);
		}
	})
}
	
 function buildChart(){
	  	displayData = mydata;
		var barChartData = {
		labels : bmiLabels,
		//barValueSpacing : 25,
		//barStrokeWidth : 40,
		datasets : [
			{
				fillColor : "#19a2d4",
				strokeColor : "rgba(220,220,220,0.8)",
				highlightFill: "rgba(220,220,220,0.75)",
				highlightStroke: "rgba(220,220,220,1)",
				  data: bmiData
			}
		]

	}
	
		var ctx = document.getElementById("canvas").getContext("2d");
		window.myBar = new Chart(ctx).Line(barChartData, {
			  barValueSpacing : 10,
		});
	}
	
 buildChart();
 sendData(value);	
	
	</script>
				</fieldset>
				</div>
		</div>
<?php
	include 'includes/footer.php';
?>