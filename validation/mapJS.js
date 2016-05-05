window.onload = getMyLocation;

var map;
function getMyLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(displayLocation);
  } else {
    alert('Oops, no geolocation support');
  }
}

//This function is inokved asynchronously by the HTML5 geolocation API.
function displayLocation(position) {
  //The latitude and longitude values obtained from HTML 5 API.
  var latitude = position.coords.latitude;
  var longitude = position.coords.longitude;

  //Creating a new object for using latitude and longitude values with Google map.
  var latLng = new google.maps.LatLng(latitude, longitude);

  showMap(latLng);

  addNearByPlaces(latLng);
  apiMarkerCreate(latLng);

}

function showMap(latLng) {
  //Setting up the map options like zoom level, map type.
  var mapOptions = {
    center: latLng,
    zoom: 14,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };

  //Creating the Map instance and assigning the HTML div element to render it in.
  map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
}

function addNearByPlaces(latLng) {

  var nearByService = new google.maps.places.PlacesService(map);

  var request = {
    location: latLng,
    radius: 10936,
    types: ['gym']
  };

  nearByService.nearbySearch(request, searchNearBy);
}

function searchNearBy(results, status) {
  if (status == google.maps.places.PlacesServiceStatus.OK) {
    for (var i = 0; i < results.length; i++) {
      var place = results[i];
      apiMarkerCreate(place.geometry.location, place);
    }
  }
}

function apiMarkerCreate(latLng, placeResult) {
  var markerOptions = {
    position: latLng,
    map: map,
    animation: google.maps.Animation.DROP,
    clickable: true
  }
  //Setting up the marker object to mark the location on the map canvas.
  var marker = new google.maps.Marker(markerOptions);

  if (placeResult) {
    var content = placeResult.name+'<br/>'+placeResult.vicinity+'<br/>'+placeResult.types+'<br/><a href="addmap.php?name='+placeResult.name+'&address='+placeResult.vicinity+'">Add</a>';
    windowInfoCreate(marker, latLng, content);
  }
  else {
    var content = 'You are here: ' + latLng.lat() + ', ' + latLng.lng();
    windowInfoCreate(marker, latLng, content);
  }

}

function windowInfoCreate(marker, latLng, content) {
  var infoWindowOptions = {
    content: content,
    position: latLng
  };

  var infoWindow = new google.maps.InfoWindow(infoWindowOptions);

  google.maps.event.addListener(marker, 'click', function() {
    infoWindow.open(map);
  });
}
//JS script helped with  http://www.webcodegeeks.com/