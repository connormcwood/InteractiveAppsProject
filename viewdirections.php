<?php
	include 'includes/header.php';
		checkSession($conn); //Checks Session Then Compares UserId With Username to confirm they are right.
		checkDetails($conn, $_SESSION['userid']); //Checks Whether User Has Set Extra Details
			
		$userid = $_SESSION['userid'];	

	//Retrieves GymId from Database
	$details = getDetails($conn, $userid);
		if($details){
		$gymid = $details['gymid'];
		} else {
		echo "NONE";
		}	
?>
<link href="includes/stylesheet.css" rel="stylesheet" type="text/css">
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDd8av06i6S53MCFjBB68WHBHgNoRBwvd4&signed_in=true&callback=getLocation"
        async defer></script>

		
		<div id="bigbox">
				<div id="bigboxcontentholder">	
				<fieldset>			
				<legend>View Directions</legend>
				<div id="floating-panel">
				<?php		
	$sql = "SELECT * FROM gyms WHERE gymid = '$gymid'";
	$result = $conn->query($sql);
	echo "<select id='end' name='end' class='makefullsize'>";
	if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		  echo "<option value=\"".$row["gymaddress"]."\">".$row["gymname"]."</option>"; 
	}
	} else {
    echo "0 results";
	}
	echo "</select>";
	
				?>
				</div>
					<div id="map"></div>
					<div id="warnings-panel"></div>
    
 <script>
var myCentre = new google.maps.LatLng(40.712784,-74.005941);

function getLocation() {
    // Try HTML5 geolocation.
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var pos = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      };
	  initMap(pos);
	});
  }
} // close function
	
	
function initMap(myLoc) {
  var markerArray = [];

  // Instantiate a directions service.
  var directionsService = new google.maps.DirectionsService;

  // Create a map and center it on Manhattan.
  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 13,
    center: myLoc
  });

  // Create a renderer for directions and bind it to the map.
  var directionsDisplay = new google.maps.DirectionsRenderer({map: map});
  directionsDisplay.setPanel(document.getElementById('bottom-panel'));

  // Instantiate an info window to hold step text.
  var stepDisplay = new google.maps.InfoWindow;

  // Display the route between the initial start and end selections.
  calculateAndDisplayRoute(
      directionsDisplay, directionsService, markerArray, stepDisplay, map, myLoc);
  // Listen to change events from the start and end lists.
  var onChangeHandler = function() {
    calculateAndDisplayRoute(
        directionsDisplay, directionsService, markerArray, stepDisplay, map, myLoc);
  };
  document.getElementById('end').addEventListener('change', onChangeHandler);
}

function calculateAndDisplayRoute(directionsDisplay, directionsService,
    markerArray, stepDisplay, map, myLoc) {
  // First, remove any existing markers from the map.
  
  for (var i = 0; i < markerArray.length; i++) {
    markerArray[i].setMap(null);
  }

  // Retrieve the start and end locations and create a DirectionsRequest using
  // WALKING directions.
  directionsService.route({
	  
	// start and end points of route
    //origin: document.getElementById('start').value,
	origin: myLoc,
    destination: document.getElementById('end').value,
	// change for car etc..
    travelMode: google.maps.TravelMode.DRIVING
  }, function(response, status) {
    // Route the directions and pass the response to a function to create
    // markers for each step.
    if (status === google.maps.DirectionsStatus.OK) {
      document.getElementById('warnings-panel').innerHTML =
          '<b>' + response.routes[0].warnings + '</b>';
      directionsDisplay.setDirections(response);
      showSteps(response, markerArray, stepDisplay, map);
    } else {
      window.alert('Directions request failed due to ' + status);
    }
  });
}

function showSteps(directionResult, markerArray, stepDisplay, map) {
  // For each step, place a marker, and add the text to the marker's infowindow.
  // Also attach the marker to an array so we can keep track of it and remove it
  // when calculating new routes.
  var myRoute = directionResult.routes[0].legs[0];
  for (var i = 0; i < myRoute.steps.length; i++) {
    var marker = markerArray[i] = markerArray[i] || new google.maps.Marker;
    marker.setMap(map);
    marker.setPosition(myRoute.steps[i].start_location);
    attachInstructionText(
        stepDisplay, marker, myRoute.steps[i].instructions, map);
  }
}

function attachInstructionText(stepDisplay, marker, text, map) {
  google.maps.event.addListener(marker, 'click', function() {
    // Open an info window when the marker is clicked on, containing the text
    // of the step.
    stepDisplay.setContent(text);
    stepDisplay.open(map, marker);
  });
}

getLocation();
    </script>
   
   	<div id="bottom-panel"></div>  
</fieldset>
</div>
</div>
<?php
	include 'includes/footer.php';
?>