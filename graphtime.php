<?php
	include 'includes/header.php';
		checkSession($conn); //Checks Session Then Compares UserId With Username to confirm they are right.
		checkDetails($conn, $_SESSION['userid']); //Checks Whether User Has Set Extra Details
	
	$problem = "";
	$success = "";
	
	//Searches The Database For Entries To Do With Progress And TimeSpent At Gym. If No Results Echo Problem.
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
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="Chart.js-master/Chart.js"></script>
		<div id="bigbox">
				<div id="bigboxcontentholder">
				
				

<fieldset>
				<legend>Time At GYM</legend>
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
    <li class="graph-item"><a href="graphbmi.php">BMI</a></li>
 </ul>	
<form>				
  <input id="radio-1" class="radio-custom" type="radio" name="timeValue" value="m" checked>
  <label for="radio-1" class="radio-custom-label">Minutes</label></br>
  <input id="radio-2" class="radio-custom" type="radio" name="timeValue" value="h">
  <label for="radio-2" class="radio-custom-label">Hours</label>
</form>
	<div style="width: 50%">
			<canvas id="canvas" height="450" width="600"></canvas>
		</div>


	<script>
window.onload = function(){
	var ctx = document.getElementById("canvas").getContext("2d");
	alert("Window Loaded");
	window.myBar = new Chart(ctx).Line(barChartData, {
	responsive : true
	});
}
// in php you simply need to create the two arrays and teh functionality will work	
var myData = new Array();
var myDataLabels = new Array();

function sendData(){
	alert("Sending Data");
	$.ajax({
		type: 'POST',
		dataType: "json",
		data: {
			userId: <?php echo $userid ?>},
		url:'getDataProgress.php',
		success: function(data){
			console.log(data);
			myData=data.timeSpent;
			alert(myData);
			myDataLabels=data.gymDate;
			alert(myDataLabels);
			
			buildChart();
		},
		error: function(){
			alert('There Was An Error With Your Data');
			console.log(data);

		}
	})
}
	

var currentValue = "m"

var displayData=[];


// function called when radio button is pressed
$( ".radio-custom" ).on( "click", function() {
	
	var myitem = $( "input:checked" ).val();
	// prevent radio button being clicked twice
	if(currentValue!=myitem){
		currentValue=myitem;
		
	// check to see if need to convert to minutes or hours
	if(myitem =="h"){
		contoHours();
	} else {
		contoMins();
	}
	}
});


function contoMins(){
	// change the values of the array
	for(i=0; i<myData.length; i++){
		myData[i]=myData[i]*60;
	}
	destroyChart();
}

function contoHours(){
	
	for(i=0; i<myData.length; i++){
		myData[i]=myData[i]/60;
	}
	
	destroyChart();
}

// destroy the chart so that it does not load on top of itself
function destroyChart(){
   window.myBar.destroy();
   buildChart();
}


//
function myGetWeek(){
	// set radio but for minutes to be  checked
	$('input:radio[class=radio-custom][id=radio-1]').prop('checked', true);
	mydata =  myTimeWeek;
	destroyChart();
}

function myGetMonth(){
	// set radio but for minutes to be  checked
	$('input:radio[class=radio-custom][id=radio-1]').prop('checked', true);
	myData =  myTimeMon;
	destroyChart();
}
	
function buildChart(){
	  	displayData = myData;
		var barChartData = {
		labels : myDataLabels,
		//barValueSpacing : 60,
		//barStrokeWidth : 100,
		datasets : [
			{
				fillColor : "#19a2d4",
				strokeColor : "#19a2d4",
				highlightFill: "#50c1eb",
				highlightStroke: "#50c1eb",
				  data: displayData
			}
		]

	}
	
		var ctx = document.getElementById("canvas").getContext("2d");
		window.myBar = new Chart(ctx).Bar(barChartData, {
			  barValueSpacing : 10,
		});
	}
	sendData();	
	buildChart();
 //sendData();	
	
	</script>
</fieldset>
</div>
				</div>
				
				</div>
		</div>
<?php
	include 'includes/footer.php';
?>